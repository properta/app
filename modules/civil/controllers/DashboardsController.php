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
    VerbFilter,
    AccessControl
};
use app\models\alumnuses\{
    generals\Announcements,
    generals\Settings, 
    searches\Announcements as AnnouncementsSearch
};
use app\models\smart\{
    generals\MTahunAjaran,
    generals\PublicSekolah,
};
use app\utils\{
    gdrive\GDrive
};

use yii\widgets\ActiveForm;

class DashboardsController extends Controller
{
    public $title = "Beranda";
    public $layout = '@app/views/layouts/civil';

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                        'rules' => [
                            [
                                'actions' => ['index', 'view', 'create', 'update', 'delete', 'validate', 'handle-file', 'get-year-of-graduates', 'get-schools'],
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

    public function beforeAction($action) {
        if($action->id == 'handle-file') :
            Yii::$app->request->enableCsrfValidation = false;
        endif;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (Yii::$app->user->can('/administrator/dashboards/index')||1):
            return $this->render('index');
        endif;
        
        throw new ForbiddenHttpException("You Can't Access This Page");
    }
}