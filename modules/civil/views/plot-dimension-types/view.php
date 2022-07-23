<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = Yii::t('app', 'Detail of Plot Of Lands');
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="row">
    <div class="col-12 col-lg-8 col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><?= $this->title ?></h4>
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
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('desc') ?></td>
                            <td>:</td>
                            <td><?= $model->desc ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold">Project</td>
                            <td>:</td>
                            <td><?= $model->project_id ?$model->project->title: "-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold">Length</td>
                            <td>:</td>
                            <td><?= $model->length ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('width') ?></td>
                            <td>:</td>
                            <td><?= $model->width ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('dimension_unit_code_id') ?></td>
                            <td>:</td>
                            <td><?= $model->dimension_unit_code_id?$model->dimensionUnitCode->title:"-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('dimension_unit_code_id_str') ?></td>
                            <td>:</td>
                            <td><?= $model->dimension_unit_code_id_str??"-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('plot_type_id') ?></td>
                            <td>:</td>
                            <td><?= $model->plot_type_id?$model->plotType->value:"-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('plot_type_str') ?></td>
                            <td>:</td>
                            <td><?= $model->plot_type_str??"-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('total') ?></td>
                            <td>:</td>
                            <td><?= $model->total??"-" ?></td>
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
                                <td class="tw-font-bold"><?= $model->getAttributeLabel('contractor_id') ?></td>
                                <td>:</td>
                                <td><?= $model->contractor->title ?? "-" ?></td>
                            </tr>
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
                                <td><?= $model->created_by&&$model->createdBy->status == 10 ? "<span class='badge badge-primary'>" . Yii::t('app', 'Active') . "</span>" : "<span class='badge badge-warning'>" . Yii::t('app', 'Inactive') . "</span>" ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="form-group float-right">
                    <?= Html::a('<i class="fas fa-undo-alt"></i> ', 'index', ['class' => 'btn btn-sm btn-info m-1']);  ?>
                    <?= Html::a('<i class="fas fa-edit"></i> ', Url::to(['update', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-warning m-1']);  ?>
                    <?= Html::button('<i class="fas fa-trash"></i> ', ['class' => 'btn btn-sm btn-danger m-1', 'id' => 'delete', 'data-id' => Yii::$app->encryptor->encodeUrl($model->id), 'data-title' => Yii::t('app', 'Hapus data ini?'), 'data-desc' => Yii::t('app', 'Tindakan ini tidak bisa diurungkan')]);  ?>
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
                $.pjax({url:'index', container:'#p0', timeout: false});
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
    $('#delete').click(function(){
        processData("delete", $(this).data('id'), $(this).data("title"), $(this).data("desc"));
    })
    $('.lazy').lazy();
}

init();
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>