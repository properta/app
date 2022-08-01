<?php

use yii\helpers\{
    Html,
    Url,
    HtmlPurifier
};
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Kategori Kampanye');

?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'wupa item'), ['create'], ['class' => 'btn btn-info m-1 add-category', 'data-title' => Yii::t('app', 'Add Wupa Items')]) ?>
            </p>
            <div class="card">
                <div class="card-header">
                    <h4> <?= $this->title ?></h4>
                    <div class="card-header-action">
                        <?= $this->render('_search', ['model' => $searchModel ?? []]) ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider ?? [],
                            // 'filterModel' => $searchModel,
                            'tableOptions' => ['class' => 'table table-striped'],
                            'summaryOptions' => ['class' => 'badge badge-light m-2'],
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'contentOptions' => ['style' => 'width:10px;'],
                                    'header' => 'No.'
                                ],
                                [
                                    'attribute' => 'code',
                                    'label' => Yii::t('app', 'Code'),
                                    'format' => 'raw',
                                    'contentOptions' => ['style' => 'width:72px;'],
                                    'value' => function ($model) {
                                        return $model->code ?? "-";
                                    }
                                ],
                                [
                                    'attribute' => 'title',
                                    'label' => Yii::t('app', 'Category'),
                                    'format' => 'raw',
                                    'contentOptions' => ['style' => 'width:300px;'],
                                    'value' => function ($model) {
                                        return $model->title ?? "-";
                                    }
                                ],
                                [
                                    'attribute' => 'default_unit_code_id',
                                    'label' => Yii::t('app', 'Satuan'),
                                    'format' => 'raw',
                                    'contentOptions' => ['style' => 'width:64px;'],
                                    'value' => function ($model) {
                                        return $model->defaultUnitCode->code ?? "-";
                                    }
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'contentOptions' => ['style' => 'width:150px;'],
                                    'header' => 'Action',
                                    'visibleButtons' => [
                                        'update' => false,
                                        'delete' => true,
                                        'view' => true,
                                    ],
                                    'template' => '{view}{delete}',
                                    'buttons' => array(
                                        'view' => function ($url, $model, $key) {
                                            return Html::a('<i class="fas fa-edit"></i> ' . Yii::t('app', 'ubah'), Url::to(['update', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-info m-1 edit', 'data-title' => Yii::t('app', 'Changw Wupa Item')]);
                                        },
                                        'delete' => function ($url, $model, $key) {
                                            return Html::button('<i class="fas fa-trash"></i> ' . Yii::t('app', 'hapus'), ['class' => 'btn btn-sm btn-danger m-1 delete', 'data-pjax' => 1, 'code' => Yii::$app->encryptor->encodeUrl($model->id), 'data-title' => Yii::t('app', 'Delete Item?'), 'data-desc' => Yii::t('app', 'Sure for this action?')]);
                                        }
                                    )
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<< JS

function processData(type, code, title="", msg=""){
    let url;
    switch(type){
        case "delete":
            url= baseUrl+module+'/'+controller+'/delete'
            break;
    }
    Swal.fire({
        title: title ?? messageConfirm,
        text: msg ?? textConfirm,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: textYes,
        cancelButtonText: textNo,
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
                    success:function({status}){
                        resolve(status);
                    },
                    error:function(){
                        resolve(-1)
                    }
                });

            })
        },
    }).then(function ({isDismissed, value}) {
        if(isDismissed){
            Swal.fire(
                messageCanceled,
                textCanceled,
                'error'
            )
            return;
        }
        if(value==1){
            Swal.fire(
                messageSuccess,
                textSuccess,
                'success'
            ).then(function () {
                 $.pjax.reload({container: '#p0', timeout: false});
            });
        }
        else if(value==-1){
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
    });
}

function init(){
    $('a.add-category').click(function(e){
        e.preventDefault();
        $('#modalTitle').html($(this).data('title'));
        let url = $(this).attr('href');
        $.get(url, function(data) {
            $('#modal').modal('show').find('#modalContent').html(data)
        });
    });

    $('a.edit').click(function(e){
        e.preventDefault();
        $('#modalTitle').html($(this).data('title'))
        let url = $(this).attr('href');
        $.get(url, function(data) {
            $('#modal').modal('show').find('#modalContent').html(data)
        });
    });
    
    $('.delete').click(function(){
        processData("delete", $(this).attr('code'), $(this).data("title"), $(this).data("desc"));
    });
};

init()

$('.lazy').Lazy()

$(document).on('pjax:popstate', function(){
    $.pjax.reload({container: '#p0', timeout: false});
});

JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>