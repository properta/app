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
    generals\JobVacancies,
    generals\Settings,
    searches\JobVacancies as JobVacanciesSearch
};
use app\models\smart\{
    generals\MTahunAjaran,
    generals\PublicSekolah,
};
use app\utils\{
    gdrive\GDrive
};

use yii\widgets\ActiveForm;

class JobVacanciesController extends Controller
{
    public $title = "Lowongan Kerja";

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete', 'validate', 'handle-file', 'get-skill-needed', 'get-schools', 'get-companies', 'get-company-address'],
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
        if (Yii::$app->user->can('/job-vacancies/index') || 1) :
            $searchModel    = new JobVacanciesSearch();

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
        if (Yii::$app->user->can('/job-vacancies/create') || 1) :
            $model      = new JobVacancies();
            $msg        = "";
            if ($model->load(Yii::$app->request->post())) :
                $model->thumbnail = $model->thumbnail ?? NULL;
                $model->salary_range = $model->salary_range ?? NULL;
                if ($model->schools) :
                    $modelSchool = PublicSekolah::find()->where(['in', 'sekolah_id', $model->schools])->all();
                    $school = ArrayHelper::getColumn($modelSchool, function ($data) {
                        return [
                            'id' => $data->sekolah_id,
                            'text' => $data->nama,
                        ];
                    });
                    $model->schools = json_encode($school);
                else :
                    $model->schools = NULL;
                endif;

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
        $model = new JobVacancies();
        if ($code) {
            $code       = Yii::$app->encryptor->decodeUrl($code);
            $model      = JobVacancies::findOne($code);
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
        if (Yii::$app->user->can('/job-vacancies/view') || 1) :
            $code = Yii::$app->encryptor->decodeUrl($code);

            $model = $this->findModel($code);
            $schools = ArrayHelper::getColumn($model->schools ? json_decode($model->schools) : [], 'id');
            $msg = "";
            $thumbnail = $model->thumbnail;
            if ($model->load(Yii::$app->request->post())) :
                $model->updated_by = Yii::$app->user->id;
                $model->thumbnail = $model->thumbnail ? $model->thumbnail : $thumbnail;

                if ($model->schools) :
                    $modelSchool = PublicSekolah::find()->where(['in', 'sekolah_id', $model->schools])->all();
                    $school = ArrayHelper::getColumn($modelSchool, function ($data) {
                        return [
                            'id' => $data->sekolah_id,
                            'text' => $data->nama,
                        ];
                    });
                    $model->schools = json_encode($school);
                else :
                    $model->schools = NULL;
                endif;
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
                'schools' => ArrayHelper::map(PublicSekolah::find()
                    ->where(['in', 'sekolah_id', $schools])
                    ->all(), 'sekolah_id', 'nama'),
                'skill_needes' => $model->skill_needed ? [$model->skill_needed => $model->skill_needed] : [],
                'companies' => $model->company_str ? [$model->company_str => $model->company_str] : [],
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionDelete()
    {
        if (Yii::$app->user->can('/job-vacancies/delete') || 1) :
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
        $model = JobVacancies::find()->where(['id' => $id])
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
        $term = Yii::$app->request->get('search') ?? "";
        $term = trim($term);
        $model = PublicSekolah::find()
            ->where(['like', 'nama', $term])
            ->andWhere(['aktif' => 1])
            ->andWhere(['soft_delete' => 0])
            ->limit(20)
            ->all();
        $data = ArrayHelper::getColumn($model, function ($data) {
            return [
                'id' => $data->sekolah_id,
                'text' => $data->nama,
            ];
        });
        return json_encode(['results' => $data ?? []]);
    }

    public function actionGetCompanies()
    {
        //return what user type if lenght >=3
        $term = Yii::$app->request->get('search') ?? " ";
        $term = trim($term);
        $model = JobVacancies::find()
            ->where(['like', 'company_str', $term])
            ->having("COUNT(company_str) >= 3")
            ->limit(20)
            ->all();
        $data = ArrayHelper::getColumn($model, function ($data) {
            return [
                'id' => trim($data->company_str),
                'text' => trim($data->company_str),
            ];
        });
        if (strlen($term) >= 3 && !in_array(strtolower($term), ArrayHelper::getColumn($data, function ($data) {
            return strtolower($data['id']);
        }))) :
            array_unshift($data, ['id' => trim($term), 'text' => trim($term . " (new)")]);
        endif;
        return json_encode(['results' => $data ?? []]);
    }

    public function actionGetSkillNeeded()
    {
        //return what user type if lenght >=3
        $term = Yii::$app->request->get('search') ?? " ";
        $term = trim($term);
        $model = JobVacancies::find()
            ->where(['like', 'skill_needed', $term])
            ->having("COUNT(skill_needed) >= 3")
            ->limit(20)
            ->all();
        $data = ArrayHelper::getColumn($model, function ($data) {
            return [
                'id' => trim($data->skill_needed),
                'text' => trim($data->skill_needed),
            ];
        });
        if (strlen($term) >= 3 && !in_array(strtolower($term), ArrayHelper::getColumn($data, function ($data) {
            return strtolower($data['id']);
        }))) :
            array_unshift($data, ['id' => trim($term), 'text' => trim($term . " (new)")]);
        endif;
        return json_encode(['results' => $data ?? []]);
    }

    public function actionGetCompanyAddress()
    {
        //return what user type if lenght >=3
        $company_name = Yii::$app->request->get('company_name');
        $term = trim($company_name);
        $model = JobVacancies::find()
            ->where(['company_str' => $company_name])
            ->andWhere(['is not', 'company_address_str', new \yii\db\Expression('null')])
            ->having("COUNT(company_address_str) >= 2")
            ->one();
        return json_encode(['result' => $model->company_address_str ?? ""]);
    }

    public function isJson($str)
    {
        $json = json_decode((string)$str);
        return $json && $str != $json;
    }
}
