<?php
use yii\helpers\{
    Html, Url
};
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = "Data of $title";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <p>
                <?= Html::a("<i class='fa fa-plus'></i> $title", ['create', 'type'=>$type], ['class' => 'btn btn-info m-1']) ?>
            </p>
            <div class="card">
                <div class="card-header">
                    <h4> <?=  $this->title ?></h4>
                    <div class="card-header-action">
                        <?= $this->render('_search', ['model' => $searchModel, 'type'=>$type]); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                // 'filterModel' => $searchModel,
                                'tableOptions' => ['class' => 'table table-striped'],
                                'summaryOptions' => ['class' => 'badge badge-light m-2'],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'header' => 'No.',
                                        'contentOptions' => ['style' => 'width:100px;'],
                                    ],
                                    [
                                        'attribute' => 'value',
                                        'label' => 'Code',
                                        'format' => 'raw',
                                        'value' => function($model){
                                            return $model->value??"-";
                                        }
                                    ],
                                    [
                                        'attribute' => 'value_',
                                        'label' => 'Name',
                                        'format' => 'raw',
                                        'value' => function($model){
                                            return $model->value_??"-";
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'contentOptions' => ['style' => 'width:300px;'],    
                                        'header' => 'Action',
                                        'visibleButtons' => [
                                            'update' => true,
                                            'delete' => true,
                                            'view' => false,
                                        ],
                                        'template' => '{update}{delete}',
                                        'buttons' => array(
                                            'update' => function($url, $model, $key) {
                                                return Html::a('<i class="fas fa-edit"></i> Update', Url::to(['update', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-warning m-1']);
                                            },
                                            'delete' => function($url, $model, $key) {
                                                return Html::button('<i class="fas fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger m-1 delete', 'data-pjax'=>0, 'style'=>'color:#fff', 'data'=>Yii::$app->encryptor->encodeUrl($model->id)]);
                                            },
                                        )
                                    ],
                                ],
                            ]); ?>
                    </div>
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
            url= 'delete'
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
                $.pjax.reload({container: '#p0', timeout: false});
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
    $('.delete').click(function(){
        processData("delete", $(this).attr('data'))
    });
};
// call function
init();

$(document).on('pjax:popstate', function(){
    $.pjax.reload({container: '#p0', timeout: false});
});

JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>