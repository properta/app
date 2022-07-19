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
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Project', ['create'], ['class' => 'btn btn-info m-1']) ?>
            </p>
            <div class="card">
                <div class="card-header">
                    <h4> <?= $this->title ?></h4>
                    <div class="card-header-action">
                        <?= $this->render('_search', ['model' => $searchModel]) ?>
                    </div>
                </div>
                <div class="card-body">
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
                                        'attribute' => 'code',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->code ?? "-";
                                        }
                                    ],
                                    [
                                        'attribute' => 'name',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->name ?? "-";
                                        }
                                    ],
                                    [
                                        'attribute' => 'project_area',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->project_area ?? "-";
                                        }
                                    ],
                                    [
                                        'attribute' => 'company_id',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->company->name ?? "-";
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