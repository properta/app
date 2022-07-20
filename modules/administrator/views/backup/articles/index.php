<?php

use yii\helpers\{
    Html,
    Url,
    HtmlPurifier
};
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'List Artikel';

?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Artikel', ['create'], ['class' => 'btn btn-info m-1']) ?>
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
                                    'attribute' => 'thumbnail',
                                    'label' => 'Thumbnail',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->thumbnail ? "<img src='{$model->thumbnail}' class='img-fluid lazy' style='width:68px' alt='thumnail'/>" : "";
                                    }
                                ],
                                [
                                    'attribute' => 'created_at',
                                    'label' => 'Tanggal Post',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->created_at ? date('d/m/Y H:i:s', $model->created_at) : "-";
                                    }
                                ],
                                [
                                    'attribute' => 'title',
                                    'label' => 'Title',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->title ? "<p>{$model->title}</p><p class='-tw-mt-4 tw-text-xs tw-py-1 tw-px-3 tw-bg-slate-400 tw-rounded-full tw-text-white tw-w-fit'>{$model->category->value_}</p>" : "-";
                                    }
                                ],
                                [
                                    'attribute' => 'status',
                                    'label' => 'Status',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->status == 1 ? "<span class='tw-bg-green-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs'>Publish</span>" : "<span class='tw-bg-blue-400 tw-text-xs tw-px-3 tw-py-1 tw-rounded-full tw-text-white'>Draft</span>";
                                    }
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'contentOptions' => ['style' => 'width:300px;'],
                                    'header' => 'Action',
                                    'visibleButtons' => [
                                        'update' => true,
                                        'delete' => true,
                                        'view' => true,
                                    ],
                                    'template' => '{view}{update}{delete}',
                                    'buttons' => array(
                                        'view' => function ($url, $model, $key) {
                                            return Html::a('<i class="fas fa-eye"></i> View', '', ['class' => 'btn btn-sm btn-primary m-1']);
                                        },
                                        'update' => function ($url, $model, $key) {
                                            return Html::a('<i class="fas fa-edit"></i> Update', Url::to(['update', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-warning m-1']);
                                        },
                                        'delete' => function ($url, $model, $key) {
                                            return Html::button('<i class="fas fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger m-1 delete', 'data-pjax' => 0, 'style' => 'color:#fff', 'data' => Yii::$app->encryptor->encodeUrl($model->id)]);
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
function processData(type, code){
    let url;
    switch(type){
        case "delete":
            url= baseUrl+module+'/'+controller+'/delete'
            break;
    }
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
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
            swal(
                'Delete Success',
                'Data berhasil di hapus :)',
                'success'
            ).then(function () {
                $.pjax.reload({container: '#p0', timeout: false});
            });
        }
        else if(data==0){
            swal(
                'Oups Galat!!!',
                'Sepertinya ada yang salah, coba ulangi',
                'error'
            ).then(function () {
                window.location.reload();
            });
        }
        else{
            swal(
                'Ups!!!',
                'Anda Tidak memiliki hak untuk menghapus lagi',
                'error'
            ).then(function () {
                window.location.reload();
            });
        }
    }, function (dismiss) {
        if (dismiss === 'cancel') {
            swal(
            'Cancelled',
            'Your imaginary file is safe :)',
            'error'
            )
        }
    });
}
function init(){
    $('.delete').click(function(){
        processData("delete", $(this).attr('data'))
    });
};
// call function
init();
$('.lazy').Lazy()
$(document).on('pjax:popstate', function(){
    $.pjax.reload({container: '#p0', timeout: false});
});

JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>