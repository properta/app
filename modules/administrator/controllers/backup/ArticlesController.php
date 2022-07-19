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
    generals\Articles,
    generals\Settings,
    searches\Articles as ArticlesSearch
};
use app\utils\{
    gdrive\GDrive
};

use yii\widgets\ActiveForm;

class ArticlesController extends Controller
{
    public $title = "Artikel";

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete', 'validate', 'handle-file', 'get-categories', 'get-tags'],
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
        if (Yii::$app->user->can('/articles/index') || 1) :
            $searchModel    = new ArticlesSearch();

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

    public function actionView($code)
    {
        if (Yii::$app->user->can('/articles/view') || 1) :
            $code       = Yii::$app->encryptor->decodeUrl($code);

            $model = $this->findModel($code);

            return $this->render('view', [
                'model' => $model,
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionCreate()
    {
        if (Yii::$app->user->can('/articles/create') || 1) :
            $model      = new Articles();
            $msg        = "";
            if ($model->load(Yii::$app->request->post())) :
                $model->seo_meta_data = json_encode(['title' => $model->seo_meta_data['title'] ?? '', 'desc' => $model->seo_meta_data['desc'] ?? '']);
                $model->thumbnail = $model->thumbnail ?? NULL;
                $model->tags = $model->tags ? json_encode($model->tags) : NULL;
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
        $model = new Articles();
        if ($code) {
            $code       = Yii::$app->encryptor->decodeUrl($code);
            $model      = Articles::findOne($code);
        }
        if ($model->load(Yii::$app->request->post())) :
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        return false;
    }

    public function actionUpdate($code)
    {
        if (Yii::$app->user->can('/articles/view') || 1) :
            $code = Yii::$app->encryptor->decodeUrl($code);

            $model = $this->findModel($code);
            $msg = "";
            $thumbnail = $model->thumbnail;
            if ($model->load(Yii::$app->request->post())) :
                $model->updated_by = Yii::$app->user->id;
                $model->seo_meta_data = json_encode(['title' => $model->seo_meta_data['title'] ?? '', 'desc' => $model->seo_meta_data['desc'] ?? '']);
                $model->thumbnail = $model->thumbnail ? $model->thumbnail : $thumbnail;
                $model->tags = $model->tags ? json_encode($model->tags) : NULL;
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
                'categories' => ArrayHelper::map(Settings::find()
                    ->where(['id' => $model->category_id])
                    ->all(), 'id', 'value_'),
                'meta' => $model->seo_meta_data && $this->isJson($model->seo_meta_data) ? json_decode($model->seo_meta_data) : null,
                'tags' => $this->isJson($model->tags) ? ArrayHelper::map(json_decode($model->tags), function ($data) {
                    return $data;
                }, function ($data) {
                    return $data;
                }) : []
            ]);
        endif;
        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionDelete()
    {
        if (Yii::$app->user->can('/articles/delete') || 1) :
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
        $model = Articles::find()->where(['id' => $id])
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

    public function actionGetCategories()
    {
        $term = Yii::$app->request->get('search') ?? "";
        $term = trim($term);
        $model = Settings::find()
            ->where(['like', 'value_', $term])
            ->andWhere(['name' => 'article_categories'])
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
        return json_encode(['results' => $data ?? []]);
    }

    public function actionGetTags()
    {
        $term = Yii::$app->request->get('search') ?? "";
        $term = trim($term);
        $model = Articles::find()
            ->where(['like', 'tags', $term])
            ->limit(20)
            ->all();

        $result = array_filter(array_unique(ArrayHelper::getColumn(explode(",", join(",", ArrayHelper::getColumn($model, 'tags'))), function ($val) {
            return preg_replace('/[^a-zA-Z0-9]/', " ", $val);
        })), function ($item) use ($term) {
            if (stripos($item, $term) !== false) {
                return true;
            }
            return false;
        });

        $tags = [];
        $tags_tmp = [];
        foreach ($result as $key => $value) :
            $tags[] = ['id' => trim($value), 'text' => trim($value)];
            $tags_tmp[] = trim($value);
        endforeach;

        if (strlen($term) >= 3 && !in_array($term, $tags_tmp)) :
            array_unshift($tags, ['id' => trim($term), 'text' => trim($term . " (new)")]);
        endif;

        return json_encode(['results' => $tags]);
    }

    protected function isJson($str)
    {
        $json = json_decode((string)$str);
        return $json && $str != $json;
    }
}
