<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = Yii::t('app', 'List of Projects');

?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Wupa'), ['create'], ['class' => 'btn btn-info m-1']) ?>
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
                                    'attribute' => 'title',
                                    // 'label' => Yii::t('app', 'Title'),
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->title ?? "-";
                                    }
                                ],
                                [
                                    'attribute' => 'status',
                                    'label' => Yii::t('app', 'Status'),
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        switch ($model->status):
                                            case 1:
                                                return "<span class='tw-bg-blue-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-whitespace-nowrap'>" . Yii::t('app', 'aktif') . "</span>";
                                                break;
                                            case 0:
                                                return "<span class='tw-bg-red-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-whitespace-nowrap'>" . Yii::t('app', 'tidak aktif') . "</span>";
                                                break;
                                            default:
                                                return "<span class='tw-bg-yellow-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-whitespace-nowrap'>" . Yii::t('app', 'lainnya') . "</span>";
                                                break;
                                        endswitch;
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