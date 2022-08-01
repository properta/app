<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;


$this->title = Yii::t('app', 'Detail of Work Unit Price Analysis');
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
                            <td colspan="3">
                                <p title="<?= $model->getAttributeLabel('desc') ?>"><?= $model->desc ?? "" ?></p>
                            </td>
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
                                <td>
                                    <?php
                                    switch ($model->status):
                                        case 1:
                                            echo "<span class='tw-bg-blue-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-whitespace-nowrap'>" . Yii::t('app', 'aktif') . "</span>";
                                            break;
                                        case 0:
                                            echo "<span class='tw-bg-red-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-whitespace-nowrap'>" . Yii::t('app', 'tidak aktif') . "</span>";
                                            break;
                                        default:
                                            echo "<span class='tw-bg-yellow-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-whitespace-nowrap'>" . Yii::t('app', 'lainnya') . "</span>";
                                            break;
                                    endswitch;
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="form-group float-right">
                    <?= Html::a('<i class="fas fa-undo-alt"></i> ', 'index', ['class' => 'btn btn-sm btn-info m-1']);  ?>
                    <?= Html::a('<i class="fas fa-edit"></i> ', Url::to(['update', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-warning m-1']);  ?>
                    <?= Html::button('<i class="fas fa-trash"></i> ', ['class' => 'btn btn-sm btn-danger m-1', 'id' => 'delete', 'data-id' => Yii::$app->encryptor->encodeUrl($model->id), 'data-title' => Yii::t('app', 'Hapus data ini?'), 'data-desc' => Yii::t('app', 'Tindakan ini tidak bisa diurungkan!')]);  ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <p>
            <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'item'), ['add-item', 'code' => Yii::$app->encryptor->encodeUrl($model->id)], ['class' => 'btn btn-info m-1', 'data-title' => Yii::t('app', 'Add Wupa Coefficient')]) ?>
        </p>
        <div class="card">
            <div class="card-header">
                <h4> <?= $this->title ?></h4>
                <div class="card-header-action tw-flex">
                    <?= isset(Yii::$app->request->get('Disbursement')['date_begin']) ? Html::button('<i class="fas fa-undo"></i> reset', ['data-href' => 'index', 'id' => 'reset', 'class' => 'mr-4 btn btn-warning tw- tw-whitespace-nowrap']) : '' ?>
                    <?= Html::button('<i class="fas fa-filter"></i> filter', ['data-href' => Yii::$app->homeurl . 'auth/purchase/filter', 'id' => 'filter', 'class' => 'mr-4 btn btn-primary tw- tw-whitespace-nowrap']) ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summaryOptions' => ['class' => 'badge badge-light m-2'],
                        'tableOptions' => ['class' => 'table table-striped'],
                        'afterRow' => function ($model, $key, $index, $grid) {
                            $date = Yii::t('app', 'Thumbnail');
                            $item = Yii::t('app', 'Kode Materi');
                            $total = Yii::t('app', 'Judul');
                            $amount = Yii::t('app', 'Jenis');
                            $receipt = Yii::t('app', 'Kapasitas');
                            $action = Yii::t('app', 'Aksi');
                            $reports = "<tr><td colspan='7' style='text-align:center;'>Tidak/ Belum ada Materi</td></tr>";
                            if ($model->wupaCoefficients) :
                                $reports = "";
                                foreach ($model->wupaCoefficients as $iskey => $isvalue) :
                                    $dropdown = '<div class="btn-group mb-2">
                                                    <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    ' . Yii::t('app', 'aksi') . '
                                                    </button>
                                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 29px, 0px);">
                                                        <a href="view?code=' . Yii::$app->encryptor->encodeUrl($isvalue->id) . '" class="dropdown-item" href="#">detail</a>
                                                        <a class="dropdown-item delete" data-key="' . $key . '" data-id="' . Yii::$app->encryptor->encodeUrl($isvalue->id) . '" href="#">hapus</a>
                                                    </div>
                                                </div>';
                                    $reports .= '<tr><td>#</td><td><img class="tw-w-full tw-h-auto lazy" src="' . ($isvalue->thumbnail ?? Yii::$app->setting->app('def_avt')) . '" /></td><td>' . ($isvalue->code ?? "-") . '</td><td>' . ($isvalue->title ?? "-") . '</td><td> ' . ($isvalue->media_type ?? "-") . '</td><td>' . ($isvalue->media_weight ?? "-") . '</td><td>' . $dropdown . '</td></tr>';
                                endforeach;
                                $remaining = 0;
                                $reports .= "<tr><td>&nbsp;</td><td colspan='3'><strong>Total</strong></td><td colspan='3'> <strong>IDR " . '-' . "</strong></td></tr>";
                                $reports .= "<tr><td>&nbsp;</td><td colspan='3'><strong>Sisa Dana</strong></td><td colspan='3'> <strong style='" . ($remaining ? "color:red;" : "") . "'>IDR " . number_format(($remaining), 0, '.', '.') . "</strong></td></tr>";
                            endif;
                            return '<tr class="row-collapse collapse-' . $key . '" style="display: none;">
                                        <td colspan="12" class="p-0">
                                            <div class="card-header">
                                                <h4>Daftar Materi (Video dan File)</h4>
                                            </div>
                                            <div class="row" style="margin:0px; padding-bottom:12px; background-color:#fefefe;">
                                                <table class="table table-sm"><tr><td style="width:32px;">#</td><th style="width:128px;">' . $date . '</th><th style="width:320px;">' . $item . '</th><th style="width:96px;">' . $total . '</th><th>' . $amount . '</th><th>' . $receipt . '</th><th>' . $action . '</th></tr>' . $reports . '</table>
                                            </div>
                                        </td>
                                    </tr>';
                        },
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'contentOptions' => ['style' => 'width:10px;'],
                                'header' => 'No.'
                            ],
                            [
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width:32px;'],
                                'value' => function ($model, $key) {
                                    return '<i data-key="' . $key . '" style="cursor: pointer; border-radius:999px" class="fas fa-arrow-down btn-collapse p-2 btn-warning"></i>';
                                }
                            ],
                            [
                                'label' => Yii::t('app', 'Code'),
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width:96px;'],
                                'value' => function ($model) {
                                    $code = $model->code ?? "-";
                                    return "<span class='tw-text-bold'>{$code}</span>";
                                }
                            ],
                            [
                                'label' => Yii::t('app', 'Parent Code'),
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width:96px;'],
                                'value' => function ($model) {
                                    $code = $model->wupaMaster->code ?? "-";
                                    return "<span class='tw-text-bold'>{$code}</span>";
                                }
                            ],
                            [
                                'label' => Yii::t('app', 'Item '),
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width:240px;'],
                                'value' => function ($model) {
                                    return $model->item->title ?? "";
                                }
                            ],
                            [
                                'label' => Yii::t('app', 'Unit'),
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width:240px;'],
                                'value' => function ($model) {
                                    return $model->item->defaultUnitCode->code ?? "";
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'label' => Yii::t('app', 'Status'),
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width:50px;'],
                                'value' => function ($model) {
                                    switch ($model->status):
                                        case 1:
                                            return "<span class='tw-bg-blue-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-whitespace-nowrap'>" . Yii::t('app', 'aktif') . "</span>";
                                            break;
                                        case 0:
                                            return "<span class='tw-bg-red-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-whitespace-nowrap'>" . Yii::t('app', 'tidak aktif') . "</span>";
                                            break;
                                        default:
                                            return "<span class='tw-bg-yellow-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-whitespace-nowrap'>" . Yii::t('app', 'lainnya') . "</span>";
                                            break;
                                    endswitch;
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'contentOptions' => ['style' => 'width:200px;'],
                                'header' => 'Action',
                                'visibleButtons' => [
                                    'update' => false,
                                    'delete' => false,
                                    'view' => false,
                                ],
                                'template' => '{add}{more}',
                                'buttons' => array(
                                    'add' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-plus"></i> ', Url::to(['add-coe', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-primary m-1 add-coe', 'data-title' => Yii::t('app', 'Tambah Coe'), 'data-key' => $key]);
                                    },
                                    'more' => function ($url, $model, $key) {
                                        return '<div class="dropdown d-inline">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            ' . Yii::t('app', 'more') . '
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            ' . Html::a(Yii::t('app', 'delete'), null, ['class' => 'delete-item dropdown-item tw-whitespace-nowrap', 'data-id' => Yii::$app->encryptor->encodeUrl($model->id), 'data-title' => Yii::t('app', 'Delete Item'), 'data-desc' => Yii::t('app', 'Tindakan ini tidak bisa dibatalkan!')]) . '
                                                        </div>
                                                    </div>';
                                    }
                                )
                            ],
                        ],
                    ]); ?>
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
        case "delete-item":
            url= baseUrl+module+'/'+controller+'/delete-item'
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
                if(type=="delete"){
                    $.pjax({url:'index', container:'#p0', timeout: false});
                }
                if(type=="delete-item"){
                     $.pjax.reload({container: '#p0', timeout: false});
                }
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
    $('a.delete-item').click(function(e){
        e.preventDefault();
        processData("delete-item", $(this).data('id'), $(this).data("title"), $(this).data("desc"));
    })
    $('a.add-coe').click(function(e){
        e.preventDefault();
        let key = $(this).data('key');
        $('#modalTitle').html($(this).data('title'))
        let url = $(this).attr('href');
        $.get(url, function(data) {
            data = "<div>"+data+"<span id='iskey' data-key="+key+">&nbsp;</span></div>";
            $('#modal').modal('show').find('#modalContent').html(data)
        });
    });
    
    $('.btn-collapse').click(function(e){
        e.preventDefault();
        const key = $(this).data('key');
        let selector = $('.collapse-'+key)
        if($(selector).is(':visible')) {
            $('.collapse-' + key).hide('slow');
            $('i[data-key="'+key+'"]').removeClass('fa-arrow-up');
            $('i[data-key="'+key+'"]').addClass('fa-arrow-down');
        } else {
            $('.collapse-' + key).show('slow');
            $('i[data-key="'+key+'"]').removeClass('fa-arrow-down');
            $('i[data-key="'+key+'"]').addClass('fa-arrow-up');
        }
    });

    $('#filter').click(function(e){
        e.preventDefault();
        var str = window.location.search.replace("?", "");
        $('#modalTitle').html('Filter')
        let url = $(this).data('href');
        $.get(url+(str?("?"+str):""), function(data) {
            $('#modal').modal('show').find('#modalContent').html(data)
        });
    })

    $('#reset').click(function(e){
        $.pjax({url:'index', container:'#p0', timeout: false});
    })
    
    $('.lazy').lazy();
}

init();
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>