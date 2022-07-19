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
    VerbFilter,
    AccessControl
};
use app\models\mains\{
    generals\MMaterials,
    generals\Settings,
    searches\MMaterials as MMaterialsSearch
};
use app\utils\{
    gdrive\GDrive
};

use yii\widgets\ActiveForm;

class MaterialsController extends Controller
{
    public $title = "Materials";
    public $layout = '@app/views/layouts/administrator';

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete', 'validate', 'handle-file'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
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
        if (Yii::$app->user->can('/materials/index') || 1) :
            $searchModel = new MMaterialsSearch();
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
        if (Yii::$app->user->can('/materials/create') || 1) :
            $model = new MMaterials();
            $msg = "";
            if ($model->load(Yii::$app->request->post())) :
                if ($model->save()) :
                    $msg = "Data berhasil di tambah";
                    Yii::$app->session->setFlash('success', $msg);
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['status' => 1, 'id' => Yii::$app->encryptor->encodeUrl($model->id), 'from' => 'create', 'type' => null, 'msg' => $msg];
                endif;
                $err = $model->getErrors();
                $msg = $err[key($err)][0];
                Yii::$app->session->setFlash('danger', $msg);
            endif;
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionValidate($code = '')
    {
        $model = new MMaterials();
        if ($code) :
            $code = Yii::$app->encryptor->decodeUrl($code);
            $model = MMaterials::findOne($code);
        endif;
        if ($model->load(Yii::$app->request->post())) :
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        return false;
    }

    public function actionView($code)
    {
        if (Yii::$app->user->can('/companies/view') || 1) :
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
        if (Yii::$app->user->can('/materials/view') || 1) :
            $code = Yii::$app->encryptor->decodeUrl($code);
            $model = $this->findModel($code);
            $msg = "";
            if ($model->load(Yii::$app->request->post())) :
                $model->updated_by = Yii::$app->user->id;
                if ($model->save()) :
                    $msg = "Data berhasil di ubah";
                    Yii::$app->session->setFlash('success', $msg);
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['status' => 1, 'id' => Yii::$app->encryptor->encodeUrl($model->id), 'from' => 'update', 'type' => null, 'msg' => $msg];
                endif;
                $err = $model->getErrors();
                $msg = $err[key($err)][0];
                Yii::$app->session->setFlash('danger', $msg);
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
        if (Yii::$app->user->can('/materials/delete') || 1) :
            $code  = Yii::$app->encryptor->decodeUrl(Yii::$app->request->post('code'));
            $model = $this->findModel($code);
            if ($model) :
                $msg = "Data berhasil di hapus";
                Yii::$app->session->setFlash('success', $msg);
                $model->deleted_at = time();
                $model->deleted_by = Yii::$app->user->id;
                $model->save(false);
                return ['status' => 1];
            endif;
            $msg = "Data gagal di hapus";
            Yii::$app->session->setFlash('danger', $msg);
            return ['status' => -1];
        endif;
        return ['status' => -99];
    }

    protected function findModel($id)
    {
        $model = MMaterials::find()->where(['id' => $id])
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
        } catch (Exception $e) {
            Yii::$app->response->statusCode = 500;
        }
    }
}
