<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = Yii::t('app', 'Detail of Contractor');
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="row">
    <div class="col-12 col-lg-8 col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><?= $this->title ?></h4>
                <?php $img = $model->logo ? $model->logo : Yii::$app->homeUrl . "theme/stisla/assets/img/avatar/avatar-1.png"; ?>
                <img alt='logo' src="<?= $img ?>" class='rounded-circle profile-widget-picture card-header-action'
                    style='width:40px; height:40px'>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-md table-striped">
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('code') ?></td>
                            <td>:</td>
                            <td><?= $model->code ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('title') ?></td>
                            <td>:</td>
                            <td><?= $model->title ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('address') ?></td>
                            <td>:</td>
                            <td><?= $model->address ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('tax_number') ?></td>
                            <td>:</td>
                            <td><?= $model->tax_number ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('telp') ?></td>
                            <td>:</td>
                            <td><?= $model->telp ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('fax') ?></td>
                            <td>:</td>
                            <td><?= $model->fax ?? "-" ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <tr>
                                <td class="tw-font-bold"><?= $model->getAttributeLabel('created_at') ?></td>
                                <td>:</td>
                                <td><?= date("d/m/Y h:m:s", $model->created_at) ?></td>
                            </tr>
                            <tr>
                                <td class="tw-font-bold"><?= $model->getAttributeLabel('created_by') ?></td>
                                <td>:</td>
                                <td><?= $model->createdBy->full_name ?? "-" ?></td>
                            </tr>
                            <tr>
                                <td class="tw-font-bold"><?= $model->getAttributeLabel('status') ?></strong></td>
                                <td>:</td>
                                <td><?= $model->status == 10 ? "<span class='badge badge-primary'>" . Yii::t('app', 'Active') . "</span>" : "<span class='badge badge-warning'>" . Yii::t('app', 'Inactive') . "</span>" ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="form-group float-right">
                    <?= Html::a('<i class="fas fa-undo-alt"></i>', 'index', ['class' => 'btn btn-sm btn-info m-1']);  ?>
                    <?= Html::a('<i class="fas fa-edit"></i>', Url::to(['update', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-warning m-1']);  ?>
                    <?= Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-sm btn-danger m-1', 'data-pjax' => 0, 'style' => 'color:#fff', 'id' => 'delete', 'data' => Yii::$app->encryptor->encodeUrl($model->id)]);  ?>
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
    $('#delete').click(function(){
        processData("delete", $(this).attr('data'))
    });
};
// call function
init()
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>