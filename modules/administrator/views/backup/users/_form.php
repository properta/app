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
                <?= $form->field($model, 'username', Template::template('fas fa-at'))->textInput(['maxlength' => true, 'placeholder' =>'username'])->label('Username') ?>

                <?= $form->field($model, 'full_name', Template::template('fas fa-user'))->textInput(['maxlength' => true, 'placeholder' =>'Imron Rosadi'])->label('Full Name') ?>

                <?= $form->field($model, 'email', Template::template('fas fa-envelope-open'))->textInput(['maxlength' => true, 'placeholder' =>'user@domain.com'])->label('Email') ?>

            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="form">

                    <?= $form->field($model, 'phone', Template::template('fas fa-phone'))->textInput(['maxlength' => true, 'placeholder' =>'+6285212121212'])->label('Mobile Phone') ?>

                    <?= $form->field($model, 'role_id')
                        ->dropDownList($roles, ['class'=>'form-control', 'prompt'=>'--choose one--'])->label("Role"); 
                    ?>

                </div>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fas fa-save"></i> Save', ['class' => 'btn btn-sm btn-primary m-1 float-right btn-submit']) ?>
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
});
JS;
$this->registerJs($js);
?>