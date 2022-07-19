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
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4><?= $this->title ?></h4>
            </div>
            <div class="card-body col-6 m-auto">
                <div class="form">
                    <?= $form->field($model, 'code', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true, 'placeholder' =>'RSND'])->label('Code') ?>

                    <?= $form->field($model, 'name', Template::template('fas fa-building'))->textInput(['maxlength' => true, 'placeholder' =>'PT. RUSSINDO'])->label('Company Name') ?>

                    <?= $form->field($model, 'address')->textArea(['maxlength' => true, 'placeholder' =>'Jl. Sukamaju'])->label('Company Address') ?>

                    <?= $form->field($model, 'npwp', Template::template('fas fa-file'))->textInput(['maxlength' => true, 'placeholder' =>'Type NPWP Here'])->label('NPWP') ?>

                    <?= $form->field($model, 'telp', Template::template('fas fa-phone'))->textInput(['maxlength' => true, 'placeholder' =>'076312345'])->label('Telp') ?>


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
$homeUrl=Yii::$app->homeUrl;
$csrf=Yii::$app->request->getCsrfToken();
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
});
JS;
$this->registerJs($js);
?>