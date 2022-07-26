<?php

namespace app\modules\civil\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\{
    Controller,
    NotFoundHttpException,
    ForbiddenHttpException,
    Response,
    UploadedFile
};
use yii\filters\{
    VerbFilter
};
use app\models\mains\{
    generals\WupaMasters,
    generals\Settings,
    generals\Contractors,
    generals\WupaItems,
    generals\MWupaItems,
    generals\WupaCoefficients,
    searches\WupaMasters as ProjectsSearch,
    searches\WupaItems as WupaItemsSearch
};
use app\utils\{
    gdrive\GDrive
};
use Google\Service\Calendar\Setting;
use yii\widgets\ActiveForm;

class WupaController extends Controller
{
    public $title = "Work Unit Price Analysis";
    public $layout = '@app/views/layouts/administrator';

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function beforeAction($action)
    {
        if ($action->id == 'handle-file') :
            Yii::$app->request->enableCsrfValidation = false;
        endif;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (Yii::$app->user->can('/wupa/index') || 1) :
            $searchModel = new ProjectsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query
                ->andWhere(['deleted_at' => NULL])
                ->orderBy(['id' => SORT_DESC]);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        endif;

        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionCreate()
    {
        if (Yii::$app->user->can('/wupa/create') || 1) :
            $model = new WupaMasters();
            $msg = "";
            if ($model->load(Yii::$app->request->post())) :
                Yii::$app->response->format = Response::FORMAT_JSON;
                $model->code = Yii::$app->helper->generateCode(6, new WupaMasters, 'code');
                if ($model->save()) :
                    $msg = Yii::t("app", "Data berhasil di tambah");
                    Yii::$app->session->setFlash('success', $msg);
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['status' => 1, 'id' => Yii::$app->encryptor->encodeUrl($model->id), 'from' => 'create', 'type' => null, 'msg' => $msg];
                endif;
                $err = $model->getErrors();
                $msg = $err[key($err)][0];
                Yii::$app->session->setFlash('danger', $msg);
                return ['status' => 0, 'msg' => $msg];
            endif;
            return $this->render('create', [
                'model' => $model,
                'contractors' => ArrayHelper::map(
                    Contractors::find()
                        ->where(['status' => 1])
                        ->andWhere(['deleted_at' => NULL])
                        ->all(),
                    'id',
                    'title'
                )
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionValidate($code = '')
    {
        $model = new WupaMasters();
        if ($code) :
            $code = Yii::$app->encryptor->decodeUrl($code);
            $model = $model::findOne($code);
        endif;
        if ($model->load(Yii::$app->request->post())) :
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        return false;
    }

    public function actionView($code)
    {
        if (Yii::$app->user->can('/wupa/view') || 1) :
            $code = Yii::$app->encryptor->decodeUrl($code);
            $model = $this->findModel($code);

            $searchModel = new WupaItemsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query
                ->andWhere(['deleted_at' => NULL])
                ->andWhere(['wupa_master_id' => $model->id])
                ->orderBy(['id' => SORT_DESC]);

            return $this->render('view', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionUpdate($code)
    {
        if (Yii::$app->user->can('/wupa/view') || 1) :
            $code = Yii::$app->encryptor->decodeUrl($code);
            $model = $this->findModel($code);
            $msg = "";
            if ($model->load(Yii::$app->request->post())) :
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($model->save()) :
                    $msg = Yii::t("app", "Data berhasil di ubah");
                    Yii::$app->session->setFlash('success', $msg);
                    return ['status' => 1, 'id' => Yii::$app->encryptor->encodeUrl($model->id), 'from' => 'update', 'type' => null, 'msg' => $msg];
                endif;
                $err = $model->getErrors();
                $msg = $err[key($err)][0];
                Yii::$app->session->setFlash('danger', $msg);
                return ['status' => 0, 'msg' => $msg];
            endif;
            return $this->render('update', [
                'model' => $model
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->user->can('/wupa/delete') || 1) :
            $code = Yii::$app->encryptor->decodeUrl(Yii::$app->request->post('code'));
            $model = $this->findModel($code);
            if ($model->delete()) :
                return ['status' => 1];
            endif;
            return ['status' => -1];
        endif;
        return ['status' => -99];
    }

    protected function findModel($id)
    {
        $model = WupaMasters::find()->where(['id' => $id])
            ->andWhere(['deleted_at' => NULL])
            ->one();
        if ($model !== null) :
            return $model;
        endif;

        throw new NotFoundHttpException('Page Not Found');
    }

    public function actionAddItem($code)
    {
        if (Yii::$app->user->can('/wupa/create') || 1) :
            $code = Yii::$app->encryptor->decodeUrl($code);
            $parent = $this->findModel($code);
            $model = new WupaItems();
            $msg = "";
            if ($model->load(Yii::$app->request->post())) :
                Yii::$app->response->format = Response::FORMAT_JSON;
                $model->wupa_master_id = $parent->id;
                if ($model->save()) :
                    $msg = Yii::t("app", "Data berhasil di tambah");
                    Yii::$app->session->setFlash('success', $msg);
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['status' => 1, 'id' => Yii::$app->encryptor->encodeUrl($model->id), 'from' => 'create', 'type' => null, 'msg' => $msg];
                endif;
                $err = $model->getErrors();
                $msg = $err[key($err)][0];
                Yii::$app->session->setFlash('danger', $msg);
                return ['status' => 0, 'msg' => $msg];
            endif;
            return $this->renderAjax('item/create', [
                'model' => $model
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionDeleteItem()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->user->can('/wupa/delete-item') || 1) :
            $code = Yii::$app->encryptor->decodeUrl(Yii::$app->request->post('code'));
            $model = WupaItems::findOne($code);
            if ($model->delete()) :
                return ['status' => 1];
            endif;
            return ['status' => -1];
        endif;
        return ['status' => -99];
    }

    public function actionAddCoe($code)
    {
        if (Yii::$app->user->can('/wupa/create') || 1) :
            $code = Yii::$app->encryptor->decodeUrl($code);
            $parent = WupaItems::findOne($code);
            $model = new WupaCoefficients();
            $msg = "";
            if ($model->load(Yii::$app->request->post())) :
                Yii::$app->response->format = Response::FORMAT_JSON;
                $model->wupa_master_id = $parent->id;
                if ($model->save()) :
                    $msg = Yii::t("app", "Data berhasil di tambah");
                    Yii::$app->session->setFlash('success', $msg);
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['status' => 1, 'id' => Yii::$app->encryptor->encodeUrl($model->id), 'from' => 'create', 'type' => null, 'msg' => $msg];
                endif;
                $err = $model->getErrors();
                $msg = $err[key($err)][0];
                Yii::$app->session->setFlash('danger', $msg);
                return ['status' => 0, 'msg' => $msg];
            endif;
            return $this->renderAjax('coe/create', [
                'model' => $model
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionHandleFile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') :
            Yii::$app->response->statusCode = 200;
            return;
        endif;
        $tmp1 = array_key_first($_FILES);
        $tmp2 = array_key_first($_FILES[$tmp1]['name']);
        $fileIs = "$tmp1" . "[" . $tmp2 . "]";
        try {
            $file = UploadedFile::getInstanceByName($fileIs);
            $gdrive = new GDrive();
            $_file = $gdrive->uploadFile($file->name, $file->tempName, $file->type);
            Yii::$app->response->statusCode = 200;
            return Yii::$app->params['drive']['urlOpen'] . $_file;
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
        }
    }

    public function actionGetItems()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $term = Yii::$app->request->get('search') ?? "";
        $term = trim($term);
        $model = MWupaItems::find()
            ->where(['or', ['like', 'code', $term], ['like', 'title', $term]])
            ->andWhere(['level' => 2])
            ->andWhere(['status' => 1])
            ->andWhere(['deleted_at' => NULL])
            ->limit(20)
            ->all();
        $data = ArrayHelper::getColumn($model, function ($data) {
            return [
                'id' => $data->id,
                'text' => $data->code . " | " . $data->title . " ({$data->defaultUnitCode->code})",
            ];
        });
        return ['results' => $data ?? []];
    }

    public function actionGetSubItemGroups()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $term = Yii::$app->request->get('search') ?? "";
        $term = trim($term);
        $model = Settings::find()
            ->where(['like', 'value_', $term])
            ->andWhere(['name' => 'wupa_sub_item_groups'])
            ->andWhere(['status' => 1])
            ->andWhere(['deleted_at' => NULL])
            ->limit(20)
            ->all();
        $data = ArrayHelper::getColumn($model, function ($data) {
            return [
                'id' => $data->id,
                'text' => $data->value_,
            ];
        });
        return ['results' => $data ?? []];
    }

    public function actionGetSubItems()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $term = Yii::$app->request->get('search') ?? "";
        $term = trim($term);
        $parent = Yii::$app->request->get('group_id');
        $check = Settings::findOne($parent);

        switch ($check->value):
            case "A":
                $model = MProficiencies::find();
                break;
            case "B":
                $model = MMaterials::find();
                break;
            case "C":
                $model = MMaterials::find();
                break;
        endswitch;

        $model = Settings::find()
            ->where(['like', 'value_', $term])
            ->andWhere(['name' => 'wupa_sub_item_groups'])
            ->andWhere(['status' => 1])
            ->andWhere(['deleted_at' => NULL])
            ->limit(20)
            ->all();
        $data = ArrayHelper::getColumn($model, function ($data) {
            return [
                'id' => $data->id,
                'text' => $data->value_,
            ];
        });
        return ['results' => $data ?? []];
    }

    public function actionValidateItem($code = '')
    {
        $model = new WupaItems();
        if ($code) :
            $code = Yii::$app->encryptor->decodeUrl($code);
            $model = $model::findOne($code);
        endif;
        if ($model->load(Yii::$app->request->post())) :
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        return false;
    }
}