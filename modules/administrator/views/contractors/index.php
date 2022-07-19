<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = Yii::t('app', 'List of Contractors');

?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <p>
                <?= $model->availableCreateContractor ? Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Contractor'), ['create'], ['class' => 'btn btn-info m-1']) : '' ?>
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
                                    // 'label' => Yii::t('app', 'Code'),
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->code ?? "-";
                                    }
                                ],
                                [
                                    'attribute' => 'title',
                                    // 'label' => Yii::t('app', 'Title'),
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->title ?? "-";
                                    }
                                ],
                                [
                                    'attribute' => 'address',
                                    // 'label' => 'Yii::t('app', 'Address'),
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->address ?? "-";
                                    }
                                ],
                                [
                                    'attribute' => 'logo',
                                    // 'label' => Yii::t('app', 'Logo'),
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        $img = $model->logo ? $model->logo : Yii::$app->homeUrl . "theme/stisla/assets/img/avatar/avatar-1.png";
                                        return "<img alt='logo' src='{$img}' class='rounded-circle profile-widget-picture' style='width:40px; height:40px'>";
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
                                        'view' => function ($url, $model, $key) {
                                            $url = Url::to(['view', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]);
                                            return Html::a('<i class="fa fa-file"></i> ' . Yii::t('app', 'detail'), $url, ['data-pjax' => 1, 'class' => 'btn btn-sm btn-icon btn-primary m-1']);
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
<?php
$js = <<< JS
$(document).on('pjax:popstate', function(){
    $.pjax.reload({container: '#p0', timeout: false});
});
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>