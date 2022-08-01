<?php

namespace app\modules\administrator\controllers;

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
    generals\MWupaItems,
    generals\Contractors,
    searches\MWupaItems as MWupaItemsSearch
};
use app\utils\{
    gdrive\GDrive
};

use yii\widgets\ActiveForm;

class WupaCategoriesController extends Controller
{
    public $title = "MWupaItems";
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
        if (Yii::$app->user->can('/MWupaItems/index') || 1) :
            $searchModel = new MWupaItemsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query
                ->andWhere(['level' => 1])
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
        if (!Yii::$app->request->isAjax) :
            return $this->redirect('index');
        endif;
        if (Yii::$app->user->can('/MWupaItems/create') || 1) :
            $model = new MWupaItems();
            $model->scenario = "wupa-category";
            $msg = "";
            if ($model->load(Yii::$app->request->post())) :
                Yii::$app->response->format = Response::FORMAT_JSON;
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
            return $this->renderAjax('create', [
                'model' => $model
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionValidate($code = '')
    {
        $model = new MWupaItems();
        if ($code) :
            $code = Yii::$app->encryptor->decodeUrl($code);
            $model = MWupaItems::findOne($code);
        endif;
        if ($model->load(Yii::$app->request->post())) :
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        return false;
    }

    public function actionView($code)
    {
        if (Yii::$app->user->can('/MWupaItems/view') || 1) :
            $code = Yii::$app->encryptor->decodeUrl($code);
            $model = $this->findModel($code);
            return $this->render('view', [
                'model' => $model
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionUpdate($code)
    {
        if (!Yii::$app->request->isAjax) :
            return $this->redirect('index');
        endif;
        if (Yii::$app->user->can('/MWupaItems/view') || 1) :
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
            return $this->renderAjax('update', [
                'model' => $model
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->user->can('/MWupaItems/delete') || 1) :
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
        $model = MWupaItems::find()->where(['id' => $id])
            ->andWhere(['deleted_at' => NULL])
            ->one();
        if ($model !== null) :
            return $model;
        endif;

        throw new NotFoundHttpException('Page Not Found');
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

    public function actionGetContractors()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $term = Yii::$app->request->get('search') ?? "";
        $term = trim($term);
        $model = Contractors::find()
            ->where(['like', 'title', $term])
            ->andWhere(['status' => 1])
            ->andWhere(['deleted_at' => NULL])
            ->limit(20)
            ->all();
        $data = ArrayHelper::getColumn($model, function ($data) {
            return [
                'id' => $data->id,
                'text' => $data->title,
            ];
        });
        return ['results' => $data ?? []];
    }

    public function actionGetMWupaItems()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $term = Yii::$app->request->get('search') ?? "";
        $term = trim($term);
        $model = MWupaItems::find()
            ->where(['like', 'title', $term])
            ->andWhere(['deleted_at' => NULL])
            ->limit(20)
            ->all();
        $data = ArrayHelper::getColumn($model, function ($data) {
            return [
                'id' => $data->id,
                'text' => $data->code . ' | ' . $data->title,
            ];
        });
        return ['results' => $data ?? []];
    }
}