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

$this->title = 'Detail Lowongan Kerja';
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
                <?php if ($model->thumbnail) : ?>
                    <div class="tw-bg-slate-100 tw-w-full tw-flex tw-justify-center tw-mb-4 tw-max-h-80">
                        <img src="<?= $model->thumbnail ?>" class="img-fluid tw-mx-auto lazy tw-object-contain" />
                    </div>
                <?php endif; ?> <div class="tw-block">
                    <h1 class="tw-text-lg mb-1"><?= $model->title ?? "-" ?></h1>
                    <span class='tw-bg-red-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs'><?= $model->skill_needed ?? "-"; ?></span>
                </div>
                <div class="tw-text-base mt-3"><?= $model->requirements ?? "-" ?></div>
                <div class="tw-grid tw-space-y-3">
                    <span>
                        <p class="tw-text-base tw-font-bold tw-mb-1">Schools:</p>
                        <?php
                        if ($model->schools) :
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
                        <p class="tw-text-base tw-font-bold tw-mb-1">Salary Range:</p>
                        <span><?= $model->salary_range ?? "Tidak disebutkan"; ?></span>
                    </span>
                    <span>
                        <p class="tw-text-base tw-font-bold tw-mb-1">Submition Deadline:</p>
                        <span><?= $model->submition_deadline ? date('d/m/Y', $model->submition_deadline) : "Tidak disebutkan"; ?></span>
                    </span>
                    <span>
                        <p class="tw-text-base tw-font-bold tw-mb-1">Company</p>
                        <p class="tw-mb-0"><?= $model->company_str ?? "-"; ?></p>
                        <p><?= $model->company_address_str ?? "-" ?></p>
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
                            <td><?= date("d/m/Y h:m:s", $model->created_at) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Created by</strong></td>
                            <td>:</td>
                            <td><?= $model->createdBy->full_name ?? "-" ?></td>
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
$(document).on('pjax:popstate', function(){
    document.referrer;
});
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>