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
use app\models\alumnuses\{
    generals\PpdbInformations,
    generals\Settings,
    searches\PpdbInformations as PpdbInformationsSearch
};
use app\models\smart\{
    generals\MTahunAjaran,
    generals\PublicSekolah,
};
use app\utils\{
    gdrive\GDrive
};

use yii\widgets\ActiveForm;

class PpdbInformationsController extends Controller
{
    public $title = "Info PPDB";

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete', 'validate', 'handle-file', 'get-schools', 'get-school-address'],
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
        if (Yii::$app->user->can('/ppdb-informations/index') || 1) :
            $searchModel    = new PpdbInformationsSearch();

            $dataProvider   = $searchModel->search(Yii::$app->request->queryParams);
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
        if (Yii::$app->user->can('/ppdb-informations/create') || 1) :
            $model      = new PpdbInformations();
            $msg        = "";
            if ($model->load(Yii::$app->request->post())) :
                $model->thumbnail = $model->thumbnail ?? NULL;
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
            return $this->render('create', [
                'model' => $model,
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionValidate($code = '')
    {
        $model = new PpdbInformations();
        if ($code) {
            $code       = Yii::$app->encryptor->decodeUrl($code);
            $model      = PpdbInformations::findOne($code);
        }
        if ($model->load(Yii::$app->request->post())) :
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        return false;
    }

    public function actionView($code)
    {
        if (Yii::$app->user->can('/companies/view') || 1) :
            $code       = Yii::$app->encryptor->decodeUrl($code);

            $model = $this->findModel($code);

            return $this->render('view', [
                'model' => $model
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionUpdate($code)
    {
        if (Yii::$app->user->can('/ppdb-informations/view') || 1) :
            $code = Yii::$app->encryptor->decodeUrl($code);

            $model = $this->findModel($code);
            $msg = "";
            $thumbnail = $model->thumbnail;
            if ($model->load(Yii::$app->request->post())) :
                $model->updated_by = Yii::$app->user->id;
                $model->thumbnail = $model->thumbnail ? $model->thumbnail : $thumbnail;
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
                'model' => $model,
                'schools' => $model->school_str ? [$model->school_str => $model->school_str] : [],
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionDelete()
    {
        if (Yii::$app->user->can('/ppdb-informations/delete') || 1) :
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
        $model = PpdbInformations::find()->where(['id' => $id])
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

    public function actionGetSchools()
    {
        //return what user type if lenght >=3
        $term = Yii::$app->request->get('search') ?? "";
        $term = trim($term);
        $model = PpdbInformations::find()
            ->where(['like', 'school_str', $term])
            ->having("COUNT(school_str) >= 3")
            ->limit(20)
            ->all();
        $data = ArrayHelper::getColumn($model, function ($data) {
            return [
                'id' => trim($data->school_str),
                'text' => trim($data->school_str),
            ];
        });
        if (strlen($term) >= 3 && !in_array(strtolower($term), ArrayHelper::getColumn($data, function ($data) {
            return strtolower($data['id']);
        }))) :
            array_unshift($data, ['id' => trim($term), 'text' => trim($term . " (new)")]);
        endif;
        return json_encode(['results' => $data ?? []]);
    }

    public function actionGetSchoolAddress()
    {
        //return what user type if lenght >=3
        $school_name = Yii::$app->request->get('school_name');
        $term = trim($school_name);
        $model = PpdbInformations::find()
            ->where(['school_str' => $school_name])
            ->andWhere(['is not', 'school_address_str', new \yii\db\Expression('null')])
            ->having("COUNT(school_address_str) >= 2")
            ->one();
        return json_encode(['result' => $model->school_address_str ?? ""]);
    }

    public function isJson($str)
    {
        $json = json_decode((string)$str);
        return $json && $str != $json;
    }
}
