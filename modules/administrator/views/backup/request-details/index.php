<?php

use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


$mod = Yii::$app->controller->module->id;
$con = Yii::$app->controller->id;

$this->title = 'Data of Companies';



//
//echo "<pre>";
//print_r($resources);
//exit();


/**
 *
 * @var $request \app\models\mains\generals\Requests
 * @var $this \yii\web\View
 */

?>
<?= $this->render('@app/views/site/_message') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4> Detail of Request</h4>
                </div>
                <div class="card-body">
                    <div class="summary-item">
                        <ul class="list-unstyled list-unstyled-border">
                            <li class="media">
                                <div class="d-flex request-info">
                                    <div class="media-right">
                                        <div class="media-title">
                                            <?= $request->name ?? "-" ?>
                                        </div>
                                        <div class="text-small text-muted">
<<<<<<< HEAD:modules/administrator/views/backup/request-details/index.php
                                            Request Name
=======
                                            <?= $request->name ?? "-" ?>
>>>>>>> 08fb1d189837ba86e276f0309a890b635ffb421b:modules/administrator/views/request-details/index.php
                                        </div>
                                    </div>
                                    <div class="media-right">
                                        <div class="media-title">
                                            Code
                                        </div>
                                        <div class="text-small text-muted">
                                            <?= $request->code ?? "-" ?>
                                        </div>
                                    </div>
                                    <div class="media-left">
                                        <div class="media-title">
                                            Report Number
                                        </div>
                                        <div class="text-small text-muted">
                                            <?= $request->report_number ?? "-" ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="d-flex request-info">
                                    <div class="media-right">
                                        <div class="media-title">
                                            Project
                                        </div>
                                        <div class="text-small text-muted">
                                            <?= $request->project->name ?? "-" ?>
                                            / <?= $request->company->name ?? "-" ?>
                                        </div>
                                    </div>
                                    <div class="media-right">
                                        <div class="media-title">
                                            Date
                                        </div>
                                        <div class="text-small text-muted">
                                            <?= $request->date ?? "-" ?>
                                        </div>
                                    </div>
                                    <div class="media-left">
                                        <div class="media-title">
                                            Description
                                        </div>
                                        <div class="text-small text-muted">
                                            <?= $request->desc ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <input type="file" class="fileond" , data-allow-reorder="true" , data-max-file-size="3MB" ,
                            data-max-files="1" />
                        <button class="btn btn-primary" id="start-import">Import Excel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2 class="section-title">Request Detail</h2>
            <p class="section-lead">
                Desc here...
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Request Details</h4>
                </div>
                <div class="px-3 pt-4">
                    <?php $form = ActiveForm::begin([
                        'enableClientValidation' => false,
                        'enableAjaxValidation' => true,
                        'id' => 'form-request',
                        'validationUrl' => ['request-details/validation'],
                    ]); ?>
                    <?= $form->field($model, 'request_id')->hiddenInput(['value' => $request->id])->label(false) ?>
                    <div class="row">
<<<<<<< HEAD:modules/administrator/views/backup/request-details/index.php
                        <div class="col-2">
                            <?= $form->field($model, 'request_number')->textInput(['maxlength' => true, 'placeholder' => 'Req']) ?>
                        </div>
                        <div class="col-2">
                            <?= $form->field($model, 'joint_number')->textInput(['maxlength' => true, 'placeholder' => 'Joint']) ?>
                        </div>
                        <div class="col-2">
                            <?= $form->field($model, 'drawing_number')->textInput(['maxlength' => true, 'placeholder' => 'Drw']) ?>
                        </div>
                        <div class="col-2">
                            <?= $form->field($model, 'line_number')->textInput([]) ?>
                        </div>
                        <div class="col-2">
                            <?= $form->field($model, 'diameter_str')->textInput([]) ?>
                        </div>
                        <div class="col-2">
                            <?= $form->field($model, 'thickness')->textInput([]) ?>
                        </div>
                        <div class="col-2">
                            <?= $form->field($model, 'material_id')->dropDownList($resources['materials'] ?? [], ['class' => 'select2', 'prompt' => 'Choose Material']) ?>
                        </div>
                        <div class="col-2">
                            <?= $form->field($model, 'method_id')->dropDownList($resources['inspection_methods'] ?? [], ['class' => 'select2', 'prompt' => 'Choose Material']) ?>
                        </div>
                        <div class="col-2">
                            <?= $form->field($model, 'line_class_id')->dropDownList($resources['line_classes'] ?? [], ['class' => 'select2', 'prompt' => 'Choose Material']) ?>
                        </div>
                        <div class="col-2">
                            <?= $form->field($model, 'shop_id')->dropDownList($resources['shoops'] ?? [], ['class' => 'select2', 'prompt' => 'Choose Material']) ?>
                        </div>

                        <div class="col-2">
                            <?= $form->field($model, 'remark')->textInput([]) ?>
                        </div>
=======
>>>>>>> 08fb1d189837ba86e276f0309a890b635ffb421b:modules/administrator/views/request-details/index.php


                        <?php echo $this->render('_form', [
                                'resources' => $resources
                        ]) ?>

                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2 class="section-title">List Detail</h2>
            <p class="section-lead">
                Desc here....
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <?php Pjax::begin(); ?>
                <?= $this->render('_table_detail', [
                    'request_details' => $request_details,
                ]) ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>

</div>

<?php
$homeUrl = Yii::$app->homeUrl;
$this->registerJsVar('code', Yii::$app->encryptor->encodeUrl($request->id));
$this->registerJsVar('_csrf', Yii::$app->request->getCsrfToken());
$id = $_GET['code'];

$js = <<< JS

    $('document').ready(()=>{
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement);
        pond.setOptions({
            acceptedFileTypes: ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
            server: 'requests/handle-file',
        });

        $("#start-import").click(async function(){
            let file = $("input[name=filepond]").val()
            try{
                swal({
                    title: "Import this file?",
                    text: "You will import this data!",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, import it!',
                    cancelButtonText: 'No, cancel!',
                    buttonsStyling: true,
                    showLoaderOnConfirm: true,
                    preConfirm: function (data) {
                        return new Promise(function (resolve, reject) {
                            $.ajax({
                                data : 'data='+file+"&&id=$id",
                                url : '$homeUrl'+'administrator/requests/import',
                                type : "POST",
                                dataType : "JSON",
                                success: function (resp) {
                                    resolve(resp)
                                }
                            });

                        })
                    },
                }).then(function (data) {
                    if(data.status==200){
                        swal(
                            'Import Success',
                            'Success import '+data.data.success+' data and error '+data.data.error+' data',
                            'success'
                        ).then(function () {
                            $.pjax.reload({container: '#p0', async: false});
                        });
                    }
                    else{
                        swal(
                            'Oups Galat!!!',
                            'Sepertinya ada yang salah, coba ulangi',
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
            }catch(e){
                // let result = await 
            }
        })
    });

    $("#form-request").on('beforeSubmit',function(event) {
        event.preventDefault();
        event.stopPropagation();
     
        var data = $(this).serializeArray();
        var url = $(this).attr('action');
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: data,
            success:(resp) => {
                $('#form-request').trigger("reset");
                $.pjax.reload({container: '#p0'});
            }
        });
        
    return false;
});

function deleteDetails(id){
    console.log('id', id)
}
JS;
$this->registerJs($js);
?>