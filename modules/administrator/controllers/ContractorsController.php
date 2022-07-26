<?php

namespace app\modules\administrator\controllers;

use Yii;
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
    generals\Contractors,
    searches\Contractors as ContractorsSearch
};
use app\utils\{
    gdrive\GDrive
};

use yii\widgets\ActiveForm;

class ContractorsController extends Controller
{
    public $title = "Contractor";
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
        if (Yii::$app->user->can('/projects/index') || 1) :
            $searchModel = new ContractorsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query
                ->andWhere(['deleted_at' => NULL])
                ->orderBy(['id' => SORT_DESC]);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => new Contractors()
            ]);
        endif;

        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionCreate()
    {
        if (Yii::$app->user->can('/projects/create') || 1) :
            $model = new Contractors();
            $msg = "";
            if ($model->availableCreateContractor) :
                if ($model->load(Yii::$app->request->post())) :
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    if ($model->save()) :
                        $msg = Yii::t("app", "Data berhasil di tambah");
                        Yii::$app->session->setFlash('success', $msg);
                        return ['status' => 1, 'id' => Yii::$app->encryptor->encodeUrl($model->id), 'from' => 'create', 'type' => null, 'msg' => $msg];
                    endif;
                    $err = $model->getErrors();
                    $msg = $err[key($err)][0];
                    Yii::$app->session->setFlash('danger', $msg);
                    return ['status' => 0, 'msg' => $msg];
                endif;
                return $this->render('create', [
                    'model' => $model,
                ]);
            endif;
            $msg = Yii::t('app', "You Can't Create More Contractors!");
            throw new ForbiddenHttpException($msg);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionValidate($code = '')
    {
        $model = new Contractors();
        if ($code) :
            $code = Yii::$app->encryptor->decodeUrl($code);
            $model = Contractors::findOne($code);
        endif;
        if ($model->load(Yii::$app->request->post())) :
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        return false;
    }

    public function actionView($code)
    {
        if (Yii::$app->user->can('/projects/view') || 1) :
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
        if (Yii::$app->user->can('/projects/view') || 1) :
            $code = Yii::$app->encryptor->decodeUrl($code);
            $model = $this->findModel($code);
            $model->scenario = 'update';
            $msg = "";
            $logo = $model->logo ?? NULL;
            if ($model->load(Yii::$app->request->post())) :
                Yii::$app->response->format = Response::FORMAT_JSON;
                $model->logo = $model->logo ? $model->logo : $logo;
                if ($model->save()) :
                    $msg = Yii::t("app", "Data berhasil di ubah");
                    Yii::$app->session->setFlash('success', $msg);
                    return ['status' => 1, 'id' => Yii::$app->encryptor->encodeUrl($model->id), 'from' => 'update', 'type' => null, 'msg' => $msg];
                endif;
                $err = $model->getErrors();
                $msg = $err[key($err)][0];
                Yii::$app->session->setFlash('danger', $msg);
                return ['status' => 0, 'mmsg' => $msg];
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
        if (Yii::$app->user->can('/projects/delete') || 1) :
            $code  = Yii::$app->encryptor->decodeUrl(Yii::$app->request->post('code'));
            $model = $this->findModel($code);
            $model->scenario = 'delete';
            if ($model) :
                $msg = Yii::t("app", "Data berhasil di hapus");
                Yii::$app->session->setFlash('success', $msg);
                $model->save(false);
                return ['status' => 1];
            endif;
            $msg = Yii::t("app", "Data gagal di hapus");
            Yii::$app->session->setFlash('danger', $msg);
            return ['status' => -1];
        endif;
        return ['status' => -99];
    }

    protected function findModel($id)
    {
        $model = Contractors::find()->where(['id' => $id])
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
}