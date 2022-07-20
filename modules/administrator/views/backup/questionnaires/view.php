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
<?= $this->render('@app/views/message/alert') ?>
<div class="row">
    <div class="col-12 col-lg-8 col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><?= $this->title ?></h4>
            </div>
            <div class="card-body pb-4">
                <div class="tw-block">
                    <h1 class="tw-text-lg mb-1"><?= $model->title ?? "-" ?></h1>
                </div>
                <div class="tw-text-base mt-3"><?= $model->content ?? "-" ?></div>
                <div class="tw-grid tw-space-y-3">
                    <span>
                        <p class="tw-text-base tw-font-bold tw-mb-1">Sekolah:</p>
                        <?php
                        if ($model->schools && $model->privacy === "auth") :
                            $school = json_decode($model->schools);
                            echo "<div class='tw-flex tw-flex-wrap tw-gap-1'>";
                            foreach ($school as $key => $val) :
                                echo "<p class='tw-mb-1 tw-bg-blue-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-w-fit'>{$val->text}</p>";
                            endforeach;
                            echo "</div>";
                        else :
                            echo "<span class='tw-bg-blue-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs'>Semua Sekolah</span>";
                        endif;
                        ?>
                    </span>
                    <span>
                        <p class="tw-text-base tw-font-bold tw-mb-1">Angkatan:</p>
                        <?php
                        if ($model->year_of_graduates  && $model->privacy === "auth") :
                            $year = json_decode($model->year_of_graduates);
                            echo "<div class='tw-flex tw-flex-wrap tw-gap-1'>";
                            foreach ($year as $key => $val) :
                                echo "<p class='tw-mb-1 tw-bg-gray-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-w-fit'>{$val->text}</p>";
                            endforeach;
                            echo "</div>";
                        else :
                            echo "<span class='tw-bg-gray-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs'>Semua Angkatan</span>";
                        endif;
                        ?>
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
                            <td><strong>Tanggal dibuat</strong></td>
                            <td>:</td>
                            <td><?= date("d/m/Y h:m:s", $model->created_at) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat Oleh</strong></td>
                            <td>:</td>
                            <td><?= $model->createdBy->full_name ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td><strong>Privasi</strong></td>
                            <td>:</td>
                            <td><?= $model->privacy == "auth" ? "<span class='badge badge-danger'>User in app</span>" : "<span class='badge badge-danger'>Public</span>" ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>:</td>
                            <td><?= $model->status == 1 ? "<span class='badge badge-success'>Publish</span>" : "<span class='badge badge-primary'>Draft</span>" ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="form-group">
                    <?= Html::a('<i class="fas fa-undo-alt"></i> Back', 'index', ['class' => 'btn btn-sm btn-info m-1', 'style' => 'color:#fff', 'data-pjax' => 1]);  ?>
                    <?= Html::a('<i class="fas fa-edit"></i> Update', Url::to(['update', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-warning m-1', 'style' => 'color:#fff', 'data-pjax' => 1]);  ?>
                    <?= Html::button('<i class="fas fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger m-1', 'data-pjax' => 0, 'style' => 'color:#fff', 'id' => 'delete', 'data' => Yii::$app->encryptor->encodeUrl($model->id), 'data-pjax' => 1]);  ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body pb-4">
                OK
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Pertanyaan Kuisioner</h4>
            </div>
            <div class="card-body pb-4">
                <div class="tw-block">
                    <h1 class="tw-text-lg mb-1"><?= $model->title ?? "-" ?></h1>
                </div>
                <div class="tw-text-base mt-3"><?= $model->content ?? "-" ?></div>
                <div class="tw-grid tw-space-y-3">
                    <span>
                        <p class="tw-text-base tw-font-bold tw-mb-1">Sekolah:</p>
                        <?php
                        if ($model->schools && $model->privacy === "auth") :
                            $school = json_decode($model->schools);
                            echo "<div class='tw-flex tw-flex-wrap tw-gap-1'>";
                            foreach ($school as $key => $val) :
                                echo "<p class='tw-mb-1 tw-bg-blue-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-w-fit'>{$val->text}</p>";
                            endforeach;
                            echo "</div>";
                        else :
                            echo "<span class='tw-bg-blue-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs'>Semua Sekolah</span>";
                        endif;
                        ?>
                    </span>
                    <span>
                        <p class="tw-text-base tw-font-bold tw-mb-1">Angkatan:</p>
                        <?php
                        if ($model->year_of_graduates  && $model->privacy === "auth") :
                            $year = json_decode($model->year_of_graduates);
                            echo "<div class='tw-flex tw-flex-wrap tw-gap-1'>";
                            foreach ($year as $key => $val) :
                                echo "<p class='tw-mb-1 tw-bg-gray-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-w-fit'>{$val->text}</p>";
                            endforeach;
                            echo "</div>";
                        else :
                            echo "<span class='tw-bg-gray-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs'>Semua Angkatan</span>";
                        endif;
                        ?>
                    </span>
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