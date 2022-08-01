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
    generals\MaterialPrices,
    generals\Projects,
    searches\MMaterials as MMaterialsSearch
};
use app\utils\{
    gdrive\GDrive
};

use yii\widgets\ActiveForm;

class SetMaterialPricesController extends Controller
{
    public $title = "Set Material Prices";
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
                            'actions' => ['index', 'create'],
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
        if (Yii::$app->user->can('/set-material-prices/index') || 1) :
            $searchModel = new MMaterialsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query
                ->joinWith('price')
                ->andWhere(['m_materials.deleted_at' => NULL])
                // ->andWhere(['material_prices.project_id' => Yii::$app->helper->activeProject])
                ->orderBy(['m_materials.id' => SORT_DESC]);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        endif;

        throw new ForbiddenHttpException("You Can't Access This Page");
    }

    public function actionCreate(){
        if (Yii::$app->user->can('/set-material-prices/index') || 1) :
            foreach($_POST as $keyMaterial => $valueMaterial){
                if($keyMaterial=="_csrf" || $keyMaterial=="MMaterials"){
                    continue;
                }
                $materialPrices = MaterialPrices::find()->where(['project_id' => Yii::$app->helper->activeProject])->andWhere(['material_id' => $keyMaterial])->one();
                if(!empty($materialPrices->id)){
                    $materialPrices->price = $valueMaterial;
                }else{
                    $materialPrices = new MaterialPrices();
                    $materialPrices->project_id = Yii::$app->helper->activeProject;
                    $materialPrices->material_id = $keyMaterial;
                    $materialPrices->price = $valueMaterial;
                }
                $materialPrices->save();
                $msg = Yii::t("app", "Harga material berhasil diubah");
                Yii::$app->session->setFlash('success', $msg);
                return $this->redirect('index');
            }
            return $this->redirect('index');
        endif;
        
        throw new ForbiddenHttpException("You Can't Access This Page");
    }
}