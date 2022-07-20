<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = 'Update Welder';
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>

<div class="row">
    <div class="col-12 col-lg-8 col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><?= $this->title ?></h4>
                <div class="card-header-action">
                    <img class="img-fluid profile-widget-picture rounded-circle" alt="welder" src="<?= $model->image ?>" style="max-width:58px" />
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-md table-striped">
                        <tr>
                            <td><strong>Code</strong></td>
                            <td>:</td>
                            <td><?= $model->code ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td><strong>Full Name</strong></td>
                            <td>:</td>
                            <td><?= $model->name ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td><strong>Identity Number</strong></td>
                            <td>:</td>
                            <td>
                                <?php
                                $id = $model->identity_number ?? "-";
                                $idType = $model->identityType->value ?? "-";
                                ?>
                                <?= "<strong>{$id}</strong> ({$idType})" ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Date of Born</strong></td>
                            <td>:</td>
                            <td>
                                <?php
                                $date = $model->born_at ? date('d/m/Y', strtotime($model->born_at)) : "-";
                                $bornIn = $model->born_in ?? "-";
                                ?>
                                <?= "<strong>{$bornIn}</strong>, {$date}" ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Company Base</strong></td>
                            <td>:</td>
                            <td><?= $model->company->name ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td><strong>Position</strong></td>
                            <td>:</td>
                            <td><?= $model->position ?? "-" ?></td>
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
                            <td>Created at</td>
                            <td>:</td>
                            <td><?= date("d/m/Y h:m:s", $model->created_at) ?></td>
                        </tr>
                        <tr>
                            <td>Created by</td>
                            <td>:</td>
                            <td><?= $model->createdBy->full_name ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td><?= $model->status == 1 ? "<span class='badge badge-primary'>Active</span>" : "<span class='badge badge-warning'>Inactive</span>" ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="form-group">
                    <?= Html::a('<i class="fas fa-undo-alt"></i> Back', Yii::$app->request->referrer, ['class' => 'btn btn-sm btn-info m-1']);  ?>
                    <?= Html::a('<i class="fas fa-edit"></i> Update', Url::to(['update', 'code' => $encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-warning m-1']);  ?>
                    <?= Html::button('<i class="fas fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger m-1', 'data-pjax' => 0, 'style' => 'color:#fff', 'id' => 'delete', 'data' => $encryptor->encodeUrl($model->id)]);  ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= Html::a('&nbsp;', [Url::to(['index'])], ['class' => 'redirectHelper', 'style' => 'display:none']);  ?>
<?php
$mod = Yii::$app->controller->module->id;
$con = Yii::$app->controller->id;
$homeUrl = Yii::$app->homeUrl;
$csrf = Yii::$app->request->getCsrfToken();
$js = <<< JS

function processData(type, code){
    let url;
    switch(type){
        case "delete":
            url= '$homeUrl$mod/$con/delete'
            break;
    }
    swal({
        code: 'Are you sure?',
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
                    data: 'code='+code+'&_csrf=$csrf',
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
                // window.location='$homeUrl$mod/$con/index';
                $('.redirectHelper').click();
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

$('document').ready(()=>{
    $('#delete').click(function(){
        processData("delete", $(this).attr('data'))
    })
});
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>