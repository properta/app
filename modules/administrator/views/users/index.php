<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = Yii::t('app', 'List of Users');

?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'User'), ['create'], ['class' => 'btn btn-info m-1']) ?>
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
                                    'attribute' => 'username',
                                    // 'label' => Yii::t('app', 'Username'),
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->username ?? "-";
                                    }
                                ],
                                [
                                    'attribute' => 'full_name',
                                    // 'label' => Yii::t('app', 'Full Name'),
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->full_name ?? "-";
                                    }
                                ],
                                [
                                    'attribute' => 'email',
                                    // 'label' => 'Yii::t('app', 'Email'),
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->email ?? "-";
                                    }
                                ],
                                [
                                    'attribute' => 'image',
                                    // 'label' => Yii::t('app', 'Image'),
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        $img = $model->image ? $model->image : Yii::$app->homeUrl . "theme/stisla/assets/img/avatar/avatar-1.png";
                                        return "<img alt='image' src='{$img}' class='rounded-circle profile-widget-picture' style='width:40px; height:40px'>";
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