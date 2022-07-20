<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = 'View Request';
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
                            <td><strong><?= $model->getAttributeLabel('code')  ?></strong></td>
                            <td>:</td>
                            <td><?= $model->code ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td><strong><?= $model->getAttributeLabel('name')  ?></strong></td>
                            <td>:</td>
                            <td><?= $model->name ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td><strong><?= $model->getAttributeLabel('desc')  ?></strong></td>
                            <td>:</td>
                            <td><?= $model->desc ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td><strong><?= $model->getAttributeLabel('company_id')  ?></strong></td>
                            <td>:</td>
                            <td><?= $model->company->name ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td><strong><?= $model->getAttributeLabel('pic_user_str')  ?></strong></td>
                            <td>:</td>
                            <td><?= $model->pic_user_str ?? "-" ?></td>
                        </tr>

                        <tr>
                            <td><strong><?= $model->getAttributeLabel('pic_user_phone')  ?></strong></td>
                            <td>:</td>
                            <td><?= $model->pic_user_phone ?? "-" ?></td>
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
                            <td><strong>Created at</strong></td>
                            <td>:</td>
                            <td><?= date("d/m/Y h:m:s", $model->created_at) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Created by Oleh</strong></td>
                            <td>:</td>
                            <td><?= $model->createdBy->full_name ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>:</td>
                            <td><?= $model->status == 1 ? "<span class='badge badge-primary'>Active</span>" : "<span class='badge badge-warning'>Inactive</span>" ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="form-group">
                    <?= Html::a('<i class="fas fa-undo-alt"></i> Back', Yii::$app->request->referrer, ['class' => 'btn btn-sm btn-info m-1', 'style' => 'color:#fff', 'data-pjax' => 1]);  ?>
                    <?= Html::a('<i class="fas fa-eye"></i> Detail', Url::to(['/administrator/request-details/index', 'code' => $encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-info m-1', 'style' => 'color:#fff', 'data-pjax' => 1]);  ?>
                    <?= Html::a('<i class="fas fa-edit"></i> Update', Url::to(['update', 'code' => $encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-warning m-1', 'style' => 'color:#fff', 'data-pjax' => 1]);  ?>
                    <?= Html::button('<i class="fas fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger m-1', 'data-pjax' => 0, 'style' => 'color:#fff', 'id' => 'delete', 'data' => $encryptor->encodeUrl($model->id), 'data-pjax' => 1]);  ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8 col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <input type="file" class="fileond" , data-allow-reorder="true" , data-max-file-size="3MB" , data-max-files="1" />
                    <button class="btn btn-primary" id="start-import">Import Excel</button>
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
$id = $model->id;
$js = <<< JS

function processData(type, code){
    let url;
    switch(type){
        case "delete":
            url= 'delete'
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

        FilePond.registerPlugin(FilePondPluginFileValidateType);
        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement);
        pond.setOptions({
            acceptedFileTypes: ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
            server: 'handle-file',
        });

        $("#start-import").click(async function(){
            try{
                swal({
                    title: "Import this file?",
                    text: "You will import this data!",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#6777ef",
                    confirmButtonText: "Yes, import it!",
                    closeOnConfirm: false
                }, function (isConfirm) {
                    if (!isConfirm) return;
                    $.ajax({
                        data : 'data='+data+"&&id=$id",
                        url : '$homeUrl'+'administrator/requests/import',
                        type : "POST",
                        dataType : "JSON",
                        success: function (resp) {
                            res = resp
                        }
                    });
                })
            }catch(e){
                // let result = await 
            }
            let data = $("input[name=filepond]").val();
            let res;
            })
    });
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>