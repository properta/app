<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = Yii::t('app', 'Detail of Occupation');
/**
 *
 * @var $model \app\models\mains\generals\Projects
 */
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
                    </table>
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
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('created_at') ?></td>
                            <td>:</td>
                            <td><?= $model->created_at ? date("d/m/Y h:m:s", $model->created_at) : "-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('created_by') ?></td>
                            <td>:</td>
                            <td><?= $model->createdBy->full_name ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td class="tw-font-bold"><?= $model->getAttributeLabel('status') ?></td>
                            <td>:</td>
                            <td><?= $model->status == 1 ? "<span class='badge badge-primary'>" . Yii::t('app', 'Active') . "</span>" : "<span class='badge badge-warning'>" . Yii::t('app', 'Inactive') . "</span>" ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="form-group">
                    <?= Html::a('<i class="fas fa-undo-alt"></i> ' . Yii::t('app', 'Back'), 'index', ['class' => 'btn btn-sm btn-info m-11', 'style' => 'color:#fff', 'data-pjax' => 1]);  ?>
                    <?= Html::a('<i class="fas fa-edit"></i> ' . Yii::t('app', 'Update'), Url::to(['update', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-warning m-1', 'style' => 'color:#fff', 'data-pjax' => 1]);  ?>
                    <?= Html::button('<i class="fas fa-trash"></i> ' . Yii::t('app', 'Delete'), ['class' => 'btn btn-sm btn-danger m-1', 'data-pjax' => 0, 'style' => 'color:#fff', 'id' => 'delete', 'data' => Yii::$app->encryptor->encodeUrl($model->id), 'data-pjax' => 1]);  ?>
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
        title: messageConfirmDelete,
        text: textConfirmDelete,
        type: 'warning',
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
            swal(
                messageSuccess,
                textSuccess,
                'success'
            ).then(function () {
                $.pjax({url:'index', container:'#p0', timeout: false});
            });
        }
        else if(data==-1){
            swal(
                messageFailed,
                textFailed,
                'error'
            ).then(function () {
                window.location.reload();
            });
        }
        else{
            swal(
                messageAnauthorized,
                textAnauthorized,
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
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>