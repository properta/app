<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = Yii::t('app', 'List of Currencies');
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Currency'), ['create'], ['class' => 'btn btn-info m-1', 'id' => 'modalCreate']) ?>
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
                                    'label' => Yii::t('app', 'Country'),
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
                                        'delete' => true,
                                        'view' => true,
                                    ],
                                    'template' => '{view}{delete}',
                                    'buttons' => array(
                                        'view' => function ($url, $model, $key) {
                                            $url = Url::to(['view', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]);
                                            return Html::a('<i class="fa fa-file"></i>', $url, ['class' => 'btn btn-sm btn-icon btn-primary m-1']);
                                        },
                                        'delete' => function ($url, $model, $key) {
                                            return Html::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-sm delete btn-icon btn-danger m-1']);
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
$this->registerJsVar('title', Yii::t('app', 'Add Currency'));
$js = <<< JS
function processData(type, code){
    let url;
    switch(type){
        case "delete":
            url= baseUrl+module+'/'+controller+'/delete'
            break;
    }
    Swal.fire({
        title: messageConfirmDelete,
        text: textConfirmDelete,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: textDelete,
        cancelButtonText: textCancle,
        buttonsStyling: true,
        showLoaderOnConfirm: true,
        preConfirm: function (data) {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: url,
                    data: {
                        code: code,
                        _csrf: _csrf
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success:function(result){
                        resolve(result.status);
                    },
                });

            })
        },
    }).then(function (data) {
        if(data==1){
            Swal.fire(
                messageSuccess,
                textSuccess,
                'success'
            ).then(function () {
                $.pjax({url:'index', container:'#p0', timeout: false});
            });
        }
        else if(data==-1){
            Swal.fire(
                messageFailed,
                textFailed,
                'error'
            ).then(function () {
                window.location.reload();
            });
        }
        else{
            Swal.fire(
                messageAnauthorized,
                textAnauthorized,
                'error'
            ).then(function () {
                window.location.reload();
            });
        }
    }, function (dismiss) {
        if (dismiss === 'cancel') {
            Swal.fire(
            messageCanceled,
            textCanceled,
            'error'
            )
        }
    });
}

function init(){
    $('#modalCreate').click(function (e){
        $('#modalTitle').html(title)
        e.preventDefault();
        let url = $(this).attr('href');
        $.get(url, function(data) {
            $('#modal').modal('show').find('#modalContent').html(data)
        });
        return false;
    });
    $('.delete').click(function(){
        processData("delete", $(this).attr('data'))
    });
}

init();

JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>