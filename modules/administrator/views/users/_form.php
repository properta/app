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
    'validationUrl' => Url::toRoute($model->isNewRecord?['validate']:['validate', 'code'=>Yii::$app->encryptor->encodeUrl($model->id)]),
    ]); ?>
<div class="row">
    <div class="col-12 col-lg-8 col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><?= $this->title ?></h4>
            </div>
            <div class="card-body">
                <?= $form->field($model, 'username', Template::template('fas fa-at'))->textInput(['maxlength' => true, 'placeholder' =>Yii::t('app', 'Username')]) ?>

                <?= $form->field($model, 'full_name', Template::template('fas fa-user'))->textInput(['maxlength' => true, 'placeholder' =>'Imron Rosadi']) ?>

                <?= $form->field($model, 'email', Template::template('fas fa-envelope-open'))->textInput(['maxlength' => true, 'placeholder' =>'user@domain.com']) ?>

            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="form">

                    <?= $form->field($model, 'phone', Template::template('fas fa-phone'))->textInput(['maxlength' => true, 'placeholder' =>'+6285212121212']) ?>

                    <?= $form->field($model, 'role')
                        ->dropDownList(['a','b','c','d'], ['class'=>'form-control', 'prompt'=>Yii::t('app','--choose one--')]); 
                    ?>

                </div>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fas fa-save"></i> '.Yii::t('app', 'Save'), ['class' => 'btn btn-sm btn-primary m-1 float-right btn-submit']) ?>
                    <?= Html::a('<i class="fas fa-undo-alt"></i> '.Yii::t('app', 'Back'), $model->isNewRecord ? 'index':Url::to(['view', 'code'=>Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-info m-1 float-right']);  ?>
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
            dataType : 'JSON',
            success: function (response){
                let {status, from, id} = response;
                if((from=='create') && status){
                    $.pjax({url:'index', container:'#p0', timeout: false});
                    return;
                }
                if((from=='update') && status){
                    $.pjax({url:'view?code='+id, container:'#p0', timeout: false});
                    return;
                }
                $.pjax.reload({container: '#p0', timeout: false});
            },
            error  : function (e) {
                window.location.reload();
            }
        });
        hasClick++;
        e.stopImmediatePropagation();
        return false;
    });
}
init()
JS;
$this->registerJs($js);
?>