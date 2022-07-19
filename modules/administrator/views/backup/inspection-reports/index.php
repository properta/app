<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'Data of Projects';
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4> <?= $this->title ?></h4>
                    <div class="card-header-action">
                        <?= $this->render('_search', ['model' => $searchModel]) ?>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills float-right" id="myTab3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="home-tab3" data-toggle="tab" href="#home3" role="tab"
                                aria-controls="home" aria-selected="true">Req Entered</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab"
                                aria-controls="profile" aria-selected="false">In Progress</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab"
                                aria-controls="profile" aria-selected="false">I'prete Status</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#contact3" role="tab"
                                aria-controls="contact" aria-selected="false">Result</a>
                        </li>
                    </ul>
                    <div class="table-responsive">
                        <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                // 'filterModel' => $searchModel,
                                'tableOptions' => ['class' => 'table table-striped'],
                                'summaryOptions' => ['class' => 'badge badge-light m-2'],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'header' => 'No.'
                                    ],
                                    [
                                        'label' => 'Date',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->created_at ? date('d/m/Y',$model->created_at): "-";
                                        }
                                    ],
                                    [
                                        'label' => 'Req Number',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->request_number ?? "-";
                                        }
                                    ],
                                    [
                                        'label' => 'Company',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->request->company->name ?? "-";
                                        }
                                    ],
                                    [
                                        'label'=>'Project',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->request->project->name ?? "-";
                                        }
                                    ],
                                    [
                                        'label' => 'Area',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->request->project_area ?? "-";
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'contentOptions' => ['style' => 'width:200px;'],
                                        'header' => 'Action',
                                        'visibleButtons' => [
                                            'update' => false,
                                            'delete' => false,
                                            'view' => true,
                                        ],
                                        'template' => '{view}',
                                        'buttons' => array(
                                            'view' => function ($url, $model, $key) use ($encryptor) {
                                                $url = Url::to(['view', 'code' => $encryptor->encodeUrl($model->id)]);
                                                return Html::a('<i class="fa fa-file"></i> Detail', $url, ['class' => 'btn btn-sm btn-icon btn-primary m-1']);
                                            },
                                        )
                                    ],
                                ],
                            ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>

<?php
$homeUrl = Yii::$app->homeUrl;
$csrf = Yii::$app->request->getCsrfToken();
$js = <<< JS
$('document').ready(()=>{
});
JS;
$this->registerJs($js);
?>