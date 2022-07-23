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
    generals\Settings,
    searches\MUnitCodes as MUnitCodesSearch
};
use app\utils\{
    gdrive\GDrive
};

use yii\widgets\ActiveForm;

class SettingsController extends Controller
{
    public $title = "Unit Code";
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
                            'actions' => ['get-plot-types'],
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

    public function actionGetPlotTypes(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $term = Yii::$app->request->get('search') ?? "";
        $term = trim($term);
        $model = Settings::find()
            ->where(['like', 'name', $term])
            ->andWhere(['name'=>'plot_type'])
            ->andWhere(['deleted_at' => NULL])
            ->andwhere(['status'=>1])
            ->limit(20)
            ->all();
        $data = ArrayHelper::getColumn($model, function ($data) {
            return [
                'id' => $data->id,
                'text' => $data->value,
            ];
        });
        return ['results' => $data ?? []];
    }
}