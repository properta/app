<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'Data of Requests';
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Request', ['create'], ['class' => 'btn btn-info m-1', 'id' => 'modalCreate']) ?>
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
                                    'attribute' => 'date',
                                    'label' => 'Date',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->date ? date('d/m/Y', strtotime($model->date)) : date('d/m/Y', strtotime($model->created_at));
                                    }
                                ],
                                [
                                    'attribute' => 'report_number',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->report_number ?? "-";
                                    }
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
                                    'attribute' => 'project_id',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->project->name ?? "-";
                                    }
                                ],
                                [
                                    'attribute' => 'company_id',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->project->company->name ?? "-";
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
                                            $url = Url::to([Yii::$app->homeUrl . Yii::$app->controller->module->id . "/request-details", 'code' => $encryptor->encodeUrl($model->id)]);
                                            return Html::a('<i class="fa fa-file"></i> Detail', $url, ['class' => 'btn btn-sm btn-icon btn-primary m-1', 'style' => 'color:#fff', 'data-pjax' => 0]);
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
$homeUrl = Yii::$app->homeUrl;
$csrf = Yii::$app->request->getCsrfToken();
$checkProject = Yii::$app->session->get('id') ?? false;

$js = <<< JS
$('document').ready(()=>{
    $('#modalCreate').click(function (e){
        if('$checkProject'){
            $('#modalTitle').html("Form Request")
            e.preventDefault();
            let url = $(this).attr('href');
            $.get(url, function(data) {
                $('#modal').modal('show').find('#modalContent').html(data)
            });
        }
        else{
            swal('Oups!', 'You must select project before input request!', 'warning');
        }
        return false;
    });

});
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>