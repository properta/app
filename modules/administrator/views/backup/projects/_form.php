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

                    <?= $form->field($model, 'code', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true])->label('Code') ?>

                    <?= $form->field($model, 'name', Template::template('fas fa-building'))->textInput(['maxlength' => true])->label('Name') ?>

                    <?= $form->field($model, 'company_id')->dropDownList($companies??[], ['prompt' => 'Choose Company', 'class'=>'form-control get-companies'])->label('Company') ?>

                    <?= $form->field($model, 'project_area', Template::template('fas fa-map-marker-alt'))->textInput(['maxlength' => true])->label('Area') ?>

                    <?= $form->field($model, 'desc')->textArea(['maxlength' => true])->label('Desc') ?>

                    <?= $form->field($model, 'pic_user_str', Template::template('fas fa-user'))->textInput(['maxlength' => true])->label('PIC Name') ?>

                    <?= $form->field($model, 'pic_user_phone', Template::template('fas fa-phone'))->textInput(['maxlength' => true])->label('PIC Phone') ?>

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

    $('.get-companies').select2({
        ajax: {
            url: 'get-companies',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });
    
});
JS;
$this->registerJs($js);
?>