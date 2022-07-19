<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\utils\template\Template;
?>

<?php $form = ActiveForm::begin([
    'id'=>'request-form',
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>true,
    'options'=>['data-pjax'=>1],
    'validationUrl' => Url::toRoute($model->isNewRecord?['validate']:['validate', 'code'=>$encryptor->encodeUrl($model->id)]),
    ]); ?>
<div class="card-body">

    <div class="row">

        <div class="col-6">
            <?= $form->field($model, 'code', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true, 'placeholder' =>'R001'])->label('Code') ?>
        </div>

        <div class="col-6">
            <?= $form->field($model, 'name', Template::template('fas fa-user'))->textInput(['maxlength' => true, 'placeholder' =>'REQ 00XX'])->label('Name') ?>

        </div>

        <div class="col-12">
            <?= $form->field($model, 'report_number', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true, 'placeholder' =>'Type Here'])->label('Report Number') ?>
        </div>

        <div class="col-12">
            <?= $form->field($model, 'desc')->textArea(['rows' => '6', 'cols'=>'8', 'placeholder' =>'Type Here...', ])->label('Desc') ?>

        </div>

        <div class="col-6">
            <?= $form->field($model, 'date', Template::template('fas fa-calendar-alt'))->textInput(['maxlength' => true, 'class'=>'form-control datepicker'])->label('Date of Request') ?>
        </div>

        <div class="col-6">
            <?= $form->field($model, 'location', Template::template('fas fa-edit'))->textInput(['maxlength' => true, 'placeholder' =>'PKU'])->label('Location') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fas fa-save"></i> Save', ['class' => 'btn btn-sm btn-primary m-1 float-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php // Html::a('&nbsp;',[Url::to(['index'])], ['class'=>'redirectHelper', 'style'=>'display:none']);  ?>
<?php
$homeUrl = Yii::$app->homeUrl;
$mod = Yii::$app->controller->module->id;
$con = Yii::$app->controller->id;

$csrf = Yii::$app->request->getCsrfToken();
$js = <<< JS
$('document').ready(()=>{
    $('.datepicker').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        singleDatePicker: true,
    });

    let hasClick = 0;
    $("form#request-form").on("beforeSubmit", function (e) {
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
                    $('#modal').modal('hide');
                    $.pjax.reload({container: '#p0', async: false});
                    return;
                }
                if(from=='update' && status){
                    let url = $('.redirectHelper').attr('href');
                    $('.redirectHelper').attr('href', 'view?code='+id);
                    // $('.redirectHelper').click();
                    return;
                }
                $.pjax.reload({container: '#p1', async: false});
            },
            error  : function () {
                // window.location.reload();
            }
        });
        hasClick++;
        return false;
    });

});
JS;
$this->registerJs($js);
?>