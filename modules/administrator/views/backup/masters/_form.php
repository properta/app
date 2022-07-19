<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
use app\utils\template\Template;
?>

<?php $form = ActiveForm::begin([
    'id' => 'form-masters',
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>true,
    'options'=>['data-pjax'=>1],
    'validationUrl' => Url::toRoute($model->isNewRecord?['validate', 'scenario'=>$scenario]:['validate', 'code'=>Yii::$app->encryptor->encodeUrl($model->id)]),
    ]); ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4><?= $this->title ?></h4>
            </div>
            <div class="card-body col-6 m-auto">
                <div class="form">

                    <?= $form->field($model, 'value', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true, 'placeholder' =>'Type Code Here'])->label('Code') ?>

                    <?= $form->field($model, 'value_', Template::template('fas fa-edit'))->textInput(['maxlength' => true, 'placeholder' =>'Type Name Here'])->label('Name/ Value') ?>

                </div>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fas fa-save"></i> Save', ['class' => 'btn btn-sm btn-primary m-1 float-right']) ?>
                    <?= Html::a('<i class="fas fa-undo-alt"></i> Back', 'index', ['class' => 'btn btn-sm btn-info m-1 float-right']);  ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
$js = <<< JS
function init(){
    let hasClick = 0;
    $("body").on("beforeSubmit", "form#form-masters", function (e) {
        var form = $(this);
        if (form.find(".has-error").length || hasClick > 0) 
        {
            return false;
        }
        $.ajax({
            url : form.attr("action"),
            type : form.attr("method"),
            data : form.serialize(),
            dataType : 'JSON',
            success: function (response){
                let {status, type} = response;
                if(status){
                    $.pjax({url:'index?type='+type, container:'#p0', timeout: false});
                    return;
                }
                $.pjax.reload({container: '#p0', timeout: false});
            },
            error  : function () {
                window.location.reload();
            }
        });
        hasClick++;
        return false;
    });
}
init()
JS;
$this->registerJs($js);
?>