<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'View Project';
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
                            <td><strong><?= $model->getAttributeLabel('project_area')  ?></strong></td>
                            <td>:</td>
                            <td><?= $model->project_area ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td><strong><?= $model->getAttributeLabel('company_id')  ?></strong></td>
                            <td>:</td>
                            <td><?= $model->company->name ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td><strong><?= $model->getAttributeLabel('desc')  ?></strong></td>
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
                            <td><strong><?= $model->getAttributeLabel('pic_user_str')  ?></strong></td>
                            <td>:</td>
                            <td><?= $model->pic_user_str ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td><strong><?= $model->getAttributeLabel('pic_user_phone')  ?></strong></td>
                            <td>:</td>
                            <td><?= $model->pic_user_phone ?? "-" ?></td>
                        </tr>
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
                    <?= Html::a('<i class="fas fa-edit"></i> Update', Url::to(['update', 'code' => $encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-warning m-1', 'style' => 'color:#fff', 'data-pjax' => 1]);  ?>
                    <?= Html::button('<i class="fas fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger m-1', 'data-pjax' => 0, 'style' => 'color:#fff', 'id' => 'delete', 'data' => $encryptor->encodeUrl($model->id), 'data-pjax' => 1]);  ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Add User Project</h4>
            </div>
            <div class="card-body">
                <form class="row" id="project-user">
                    <div class="form-group col-3">
                        <select name="user_id" class="form-control select2" id="get-users">
                            <option>Select User</option>
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <select name="company_id" class="form-control select2" id="get-companies">
                            <option>Select Company</option>
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <select name="role_id" class="form-control" id="get-roles">
                            <option>Select Role</option>
                            <?php foreach ($settings as $val) { ?>
                                <option value="<?= $val->id ?>"><?= $val->value_ ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <select name="role_id" class="form-control" id="get-methods">
                            <option>Select Methods</option>
                            <?php foreach ($settings as $val) { ?>
                                <option value="<?= $val->id ?>"><?= $val->value_ ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <select name="interpreter_queue" class="form-control">
                            <option>Select Queue</option>
                            <?php for ($a = 1; $a <= 5; $a++) { ?>
                                <option value="<?= $a ?>"><?= $a ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-1">
                        <span class="btn btn-primary float-right" id="save-project-user">Save</span>
                    </div>
                </form>
                <div class="table-responsive">
                    <?php Pjax::begin(['id' => 'p1']); ?>
                    <?= GridView::widget([
                        'dataProvider' => $projectUsers,
                        // 'filterModel' => $searchModel,
                        'tableOptions' => ['class' => 'table table-striped'],
                        'summaryOptions' => ['class' => 'badge badge-light m-2'],
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'No.'
                            ],
                            [
                                'attribute' => 'user_id',
                                'label' => 'User',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->user->full_name ?? "-";
                                }
                            ],
                            [
                                'attribute' => 'company_id',
                                'label' => 'Company',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->company->name ?? "-";
                                }
                            ],
                            [
                                'attribute' => 'role',
                                'label' => 'Role',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->userRole->value_ ?? "-";
                                }
                            ],
                            [
                                'attribute' => 'queue',
                                'label' => "I'preter Qeueu",
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->interpreter_queue ?? "-";
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'contentOptions' => ['style' => 'width:130px;'],
                                'header' => 'Action',
                                'visibleButtons' => [
                                    'update' => false,
                                    'delete' => true,
                                    'view' => false,
                                ],
                                'template' => '{delete}',
                                'buttons' => array(
                                    'delete' => function ($url, $model, $key) use ($encryptor) {
                                        return Html::button('<i class="fas fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger m-1 delete-user', 'style' => 'color:#fff', 'data' => $encryptor->encodeUrl($model->id)]);
                                    },
                                )
                            ],
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'contentOptions' => ['style' => 'width:8px;'],
                            ],
                        ],
                    ]); ?>












                    <?php Pjax::end(); ?>
                </div>
                <?= Html::button('<i class="fas fa-trash"></i> Bulk Delete', ['class' => 'btn btn-sm btn-danger m-1 delete float-right', 'id' => 'bulkDelete', 'disabled' => true]); ?>
            </div>
        </div>

        <div class="app"></div>

    </div>
    <?= Html::a('&nbsp;', [Url::to(['index'])], ['class' => 'redirectHelper', 'style' => 'display:none']);  ?>
    <?php

    $mod = Yii::$app->controller->module->id;
    $con = Yii::$app->controller->id;
    $homeUrl = Yii::$app->homeUrl;
    $csrf = Yii::$app->request->getCsrfToken();
    $code = $encryptor->encodeUrl($model->id);
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

function deleteProjectUser(){
    $('.delete-user').click(function(){
        let code = $(this).attr('data')
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
                        url: 'delete-project-user',
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
                    // $('.redirectHelper').click();
                    $.pjax.reload({container: '#p0', async: false});
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
    })
}

$(document).on('ready pjax:success', function(){
    deleteProjectUser();
});

$('document').ready(()=>{
    $('input:checkbox').change(()=>{
        let pk = $('#w0').yiiGridView('getSelectedRows');
        if(pk.length<=0){
            $('#bulkDelete').attr('disabled', true);
            return;
        }
        $('#bulkDelete').removeAttr('disabled');
    })
    
    $('#app').on('click', '.')

    $('#bulkDelete').click(()=>{
        swal("Fungsi ini belum tersedia");
    })
    deleteProjectUser();
    $('#delete').click(function(){
        processData("delete", $(this).attr('data'))
    })
    $('#get-users').select2({
        ajax: {
            url: '$homeUrl'+'administrator/projects/get-users',
            dataType: 'json',
            data: function (params) {
            var query = {
                search: params.term,
                page: params.page || 1
            }
            // Query parameters will be ?search=[term]&page=[page]
            return query;
            }
        }
    });

    $('#get-companies').select2({
        ajax: {
            url: '$homeUrl'+'administrator/projects/get-companies',
            dataType: 'json',
            data: function (params) {
            var query = {
                search: params.term,
                page: params.page || 1
            }
            // Query parameters will be ?search=[term]&page=[page]
            return query;
            }
        }
    });

    $("#save-project-user`").click(function(){
        let btn = $(this);
        btn.html('Loading')
        let data = $('#project-user').serialize();
        $.ajax({
            url: 'save-project-user',
            data: data+'&code=$code',
            type: 'POST',
            success:function(res){
                btn.html('Save')
                if(res==1){
                    swal({
                        title: "Success!",
                        text: "Successfully save data!",
                        icon: "success",
                        button: "Oke!",
                    });
                    $.pjax.reload({container: '#p1', async: false});
                }else{
                    swal({
                        title: "Error!",
                        text: "Failed to save data!",
                        icon: "error",
                        button: "Oke!",
                    });
                }
            }
        })
    })
});
JS;
    $this->registerJs($js);
    ?>
    <?php Pjax::end(); ?>