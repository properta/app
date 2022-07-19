<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = Yii::t('app','List of Unit Codes');
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app','Unit Code'), ['create'], ['class' => 'btn btn-info m-1', 'id'=>'modalCreate']) ?>
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
                                        // 'label' => Yii::t('app','Code'),
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->code ?? "-";
                                        }
                                    ],
                                    [
                                        'attribute' => 'title',
                                        'label' => Yii::t('app','Country'),
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->title ?? "-";
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
                                                $url = Url::to(['view', 'code'=>Yii::$app->encryptor->encodeUrl($model->id)]);
                                                return Html::a('<i class="fa fa-file"></i> '.Yii::t('app','Detail'), $url, ['class' => 'btn btn-sm btn-icon btn-primary m-1']);
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
$this->registerJsVar('title', Yii::t('app','Add Unit Codes'));
$js = <<< JS
    $('#modalCreate').click(function (e){
        $('#modalTitle').html(title)
        e.preventDefault();
        let url = $(this).attr('href');
        $.get(url, function(data) {
            $('#modal').modal('show').find('#modalContent').html(data)
        });
        return false;
    });
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>