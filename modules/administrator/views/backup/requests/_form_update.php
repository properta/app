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
                <div class="row">

                    <div class="col-12">
                        <?= $form->field($model, 'code', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true, 'placeholder' =>'WL001'])->label('Code') ?>
                    </div>

                    <div class="col-12">
                        <?= $form->field($model, 'name', Template::template('fas fa-user'))->textInput(['maxlength' => true, 'placeholder' =>'Imron Rosadi'])->label('Welder Name') ?>

                    </div>

                    <div class="col-12">
                        <?= $form->field($model, 'report_number', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true, 'placeholder' =>'WL001'])->label('Code') ?>
                    </div>

                    <div class="col-12">
                        <?= $form->field($model, 'desc')->textArea(['rows' => '6', 'cols'=>'8', 'placeholder' =>'Imron Rosadi', ])->label('Welder Name') ?>

                    </div>

                    <div class="col-6">
                        <?= $form->field($model, 'date', Template::template('fas fa-calendar-alt'))->textInput(['maxlength' => true, 'class'=>'form-control datepicker'])->label('Date of Born') ?>
                    </div>

                    <div class="col-6">
                        <?= $form->field($model, 'location', Template::template('fas fa-edit'))->textInput(['maxlength' => true, 'placeholder' =>'Head Welder'])->label('Position') ?>
                    </div>

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