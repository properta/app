<?php

use yii\helpers\{
    Html,
    Url
};
use yii\widgets\{
    ActiveForm,
    DetailView,
    Pjax
};

$this->title = 'Detail Info PPDB';
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="row">
    <div class="col-12 col-lg-8 col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><?= $this->title ?></h4>
            </div>
            <div class="card-body pb-4">
                <?php if($model->thumbnail): ?>
                <div class="tw-bg-slate-100 tw-w-full tw-flex tw-justify-center tw-mb-4 tw-max-h-80">
                    <img src="<?= $model->thumbnail ?>" class="img-fluid tw-mx-auto lazy tw-object-contain" />
                </div>
                <?php endif; ?> <div class="tw-block">
                    <h1 class="tw-text-lg mb-1"><?= $model->title??"-" ?></h1>
                </div>
                <div class="tw-text-base mt-3"><?= $model->content??"-"?></div>
                <div class="tw-grid tw-space-y-3">
                    <span>
                        <p class="tw-text-base tw-font-bold tw-mb-1">Range of Registration:</p>
                        <span><?= $model->time_range??"Tidak disebutkan"; ?></span>
                    </span>
                    <span>
                        <p class="tw-text-base tw-font-bold tw-mb-1">Campus/ University</p>
                        <p class="tw-mb-0"><?= $model->campus_str??"-"; ?></p>
                        <p class="tw-mb-0"><?= $model->campus_website_str??"-"; ?></p>
                        <p class="tw-mb-0"><?= $model->campus_address_str??"-" ?></p>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <tr>
                            <td><strong>Created at</strong></td>
                            <td>:</td>
                            <td><?= date("d/m/Y h:m:s" ,$model->created_at) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Created by</strong></td>
                            <td>:</td>
                            <td><?= $model->createdBy->full_name??"-" ?></td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>:</td>
                            <td><?= $model->status==1 ? "<span class='badge badge-success'>Publish</span>" : "<span class='badge badge-primary'>Draft</span>" ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="form-group">
                    <?= Html::a('<i class="fas fa-undo-alt"></i> Back', 'index', ['class' => 'btn btn-sm btn-info m-1', 'style'=>'color:#fff', 'data-pjax'=>1]);  ?>
                    <?= Html::a('<i class="fas fa-edit"></i> Update', Url::to(['update', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-warning m-1', 'style'=>'color:#fff', 'data-pjax'=>1]);  ?>
                    <?= Html::button('<i class="fas fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger m-1', 'data-pjax'=>0, 'style'=>'color:#fff', 'id'=>'delete', 'data'=>Yii::$app->encryptor->encodeUrl($model->id), 'data-pjax'=>1]);  ?>
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
                $.pjax({url:'index', container:'#p0', timeout: false});
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
    $('#delete').click(function(){
        processData("delete", $(this).attr('data'))
    });
};
// call function
init()
$('.lazy').Lazy()
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>