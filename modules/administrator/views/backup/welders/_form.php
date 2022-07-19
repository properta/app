<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\utils\template\Template;
?>

<?php $form = ActiveForm::begin([
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>true,
    'options'=>['data-pjax'=>1],
    'validationUrl' => Url::toRoute($model->isNewRecord?['validate']:['validate', 'code'=>$encryptor->encodeUrl($model->id)]),
    ]); ?>
<div class="row">
    <div class="col-12 col-lg-8 col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><?= $this->title ?></h4>
            </div>
            <div class="card-body">
                <?= $form->field($model, 'code', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true, 'placeholder' =>'WL001'])->label('Code') ?>

                <?= $form->field($model, 'name', Template::template('fas fa-user'))->textInput(['maxlength' => true, 'placeholder' =>'Imron Rosadi'])->label('Welder Name') ?>

                <?= $form->field($model, 'identity_type_id')
                        ->dropDownList($identityType, ['class'=>'form-control select2'])->label("Identity Type"); 
                    ?>
                <?= $form->field($model, 'identity_number', Template::template('fas fa-file'))->textInput(['maxlength' => true, 'placeholder' =>'1403010101000000'])->label('Identity Number') ?>

            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="form">
                    <?= $form->field($model, 'company_id')
                        ->dropDownList($companies??[], ['class'=>'form-control get-companies select2', 'prompt'=>'--choose one--'])->label("Company Base"); 
                    ?>

                    <?= $form->field($model, 'born_in', Template::template('fas fa-edit'))->textInput(['maxlength' => true, 'placeholder' =>'Pekanbaru'])->label('City of Born') ?>

                    <?= $form->field($model, 'born_at', Template::template('fas fa-calendar-alt'))->textInput(['maxlength' => true, 'class'=>'form-control datepicker'])->label('Date of Born') ?>

                    <?= $form->field($model, 'position_str', Template::template('fas fa-edit'))->textInput(['maxlength' => true, 'placeholder' =>'Head Welder'])->label('Position') ?>

                    <?= $form->field($model, 'image', Template::image())->fileInput([
                        'class'=>'filepond',
                        'data-allow-reorder'=>true,
                        'data-max-file-size'=>'3MB',
                        // 'required'=>$model->image?false:true,
                        'data-max-files'=>'1'
                    ])->label('Upload Image') ?>

                </div>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fas fa-save"></i> Save', ['class' => 'btn btn-sm btn-primary m-1 float-right']) ?>
                    <?= Html::a('<i class="fas fa-undo-alt"></i> Back', Yii::$app->request->referrer, ['class' => 'btn btn-sm btn-info m-1 float-right']);  ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?= Html::a('&nbsp;',[Url::to(['index'])], ['class'=>'redirectHelper', 'style'=>'display:none']);  ?>
<?php
$homeUrl = Yii::$app->homeUrl;
$mod = Yii::$app->controller->module->id;
$con = Yii::$app->controller->id;

$csrf = Yii::$app->request->getCsrfToken();
$js = <<< JS
$('document').ready(()=>{
    let hasClick = 0;
    $("body").on("beforeSubmit", "form", function (e) {
        var form = $(this);
        if (form.find(".has-error").length || hasClick > 0) 
        {
            return false;
        }
        $.ajax({
            url : form.attr("action"),
            type : form.attr("method"),
            data : form.serialize(),
            dataType : 'json',
            success: function (response){
                let {status, from, id} = response;
                if(from=='create' && status){
                    $('.redirectHelper').click();
                    return;
                }
                if(from=='update' && status){
                    let url = $('.redirectHelper').attr('href');
                    $('.redirectHelper').attr('href', 'view?code='+id);
                    $('.redirectHelper').click();
                    return;
                }
                $.pjax.reload({container: '#p0', async: false});
            },
            error  : function () {
                window.location.reload();
            }
        });
        hasClick++;
        return false;
    });

    FilePond.registerPlugin(FilePondPluginFileValidateType);
    const inputElement = document.querySelector('input[type="file"]');
    const pond = FilePond.create(inputElement);
    pond.setOptions({
        acceptedFileTypes: ['image/jpeg', 'image/gif', 'image/png'],
        server: 'handle-file',
    });

    $('.get-companies').select2({
        ajax: {
            url: '$homeUrl$mod/$con/get-companies',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('.datepicker').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        singleDatePicker: true,
    });
});
JS;
$this->registerJs($js);
?>