<?php

namespace app\modules\administrator\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\{
    Controller,
    NotFoundHttpException,
    ForbiddenHttpException,
    Response
};
use yii\filters\{
    VerbFilter,
    AccessControl
};
use app\models\alumnuses\{
    generals\Settings,
    generals\Companies,
    searches\Settings as SettingsSearch
};
use yii\widgets\ActiveForm;

class MastersController extends Controller
{
    public $title = "Data Master";

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['index', 'create', 'update', 'delete', 'validate'],
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

    public function actionIndex($type)
    {
        if (Yii::$app->user->can('/masters/index') || 1) :
            $searchModel    = new SettingsSearch();

            $isType = $this->handleType($type);

            $dataProvider   = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query
                ->andWhere(['deleted_at' => NULL])
                ->andWhere(['name' => $isType['name']])
                ->orderBy(['id' => SORT_DESC]);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'title' => $isType['title'],
                'type' => $isType['type'],
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionCreate($type)
    {
        if (Yii::$app->user->can('/masters/create') || 1) :
            $model      = new Settings();
            $msg        = "";
            $isType = $this->handleType($type);
            $model->scenario = 'article-categories';
            if ($model->load(Yii::$app->request->post())) :
                $model->name = $isType['name'];
                if ($model->save()) :
                    $msg = "Data berhasil di tambah";
                    Yii::$app->session->setFlash('success', $msg);
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['status' => 1, 'id' => Yii::$app->encryptor->encodeUrl($model->id), 'from' => 'create', 'type' => $isType['type'], 'msg' => $msg];
                endif;
                $err = $model->getErrors();
                $msg = $err[key($err)][0];
                Yii::$app->session->setFlash('danger', $msg);
            endif;
            return $this->render('create', [
                'model' => $model,
                'title' => $isType['title'],
                'scenario' => $isType['type'],
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionValidate($code = '', $scenario = '')
    {
        $model = new Settings();
        $model->scenario = $scenario;
        if ($code) {
            $code       = Yii::$app->encryptor->decodeUrl($code);
            $model      = Settings::findOne($code);

            $model->scenario = str_replace('_', '-', $model->name);
        }
        if ($model->load(Yii::$app->request->post())) :
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        return false;
    }

    public function actionUpdate($code)
    {
        if (Yii::$app->user->can('/masters/view') || 1) :
            $code       = Yii::$app->encryptor->decodeUrl($code);

            $model = $this->findModel($code);
            $type = str_replace('_', '-', $model->name);
            $isType = $this->handleType($type);
            $model->scenario = $type;
            $msg = "";
            if ($model->load(Yii::$app->request->post())) :
                $model->updated_at = time();
                $model->updated_by = Yii::$app->user->id;
                if ($model->save()) :
                    $msg = "Data berhasil di ubah";
                    Yii::$app->session->setFlash('success', $msg);
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['status' => 1, 'id' => Yii::$app->encryptor->encodeUrl($model->id), 'from' => 'update', 'type' => $isType['type'], 'msg' => $msg];
                endif;
                $err = $model->getErrors();
                $msg = $err[key($err)][0];
                Yii::$app->session->setFlash('danger', $msg);
            endif;
            return $this->render('update', [
                'model' => $model,
                'title' => $isType['title']
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionDelete()
    {
        if (Yii::$app->user->can('/masters/delete') || 1) :
            $code       = Yii::$app->encryptor->decodeUrl(Yii::$app->request->post('code'));
            $model = $this->findModel($code);

            if ($model) :
                $model->deleted_at = time();
                $model->deleted_by = Yii::$app->user->id;
                $model->save(false);
                return json_encode(['status' => 1]);
            endif;
            return json_encode(['status' => 0]);
        endif;
        return -1;
    }

    protected function findModel($id)
    {
        $model = Settings::find()->where(['id' => $id])
            ->andWhere(['deleted_at' => NULL])
            ->one();
        if ($model !== null) :
            return $model;
        endif;

        throw new NotFoundHttpException('Page Not Found');
    }

    protected function handleType($type = '')
    {
        $isType = '';
        switch ($type) {
            case 'article-categories':
                $isType = ['type' => 'article-categories', 'name' => 'article_categories', 'title' => 'Kategori Artikel'];
                break;
            case 'materials':
                $isType = ['type' => 'materials', 'name' => 'materials', 'title' => 'Material'];;
                break;
            case 'welder-processes':
                $isType = ['type' => 'welder-processes', 'name' => 'welder_processes', 'title' => 'Welder Proccess'];;
                break;
            case 'shoops':
                $isType = ['type' => 'shoops', 'name' => 'shoops', 'title' => 'Shoop'];;
                break;
            case 'line-classes':
                $isType = ['type' => 'line-classes', 'name' => 'line_classes', 'title' => 'Line Class'];;
                break;
            default:
                throw new NotFoundHttpException('Type Not Found');
                break;
        }
        return $isType;
    }
}
