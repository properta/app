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
    'validationUrl' => Url::toRoute(['validate', 'code'=>Yii::$app->encryptor->encodeUrl($model->id)]),
    ]); ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4><?= $this->title ?></h4>
            </div>
            <div class="card-body col-6 m-auto">
                <div class="row">

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'code', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true, 'placeholder' =>'IDR']) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($model, 'title', Template::template('fas fa-flag'))->textInput(['maxlength' => true, 'placeholder' =>'Indonesia']) ?>
                        </div>
                        <div class="col-12">
                            <?= $form->field($model, 'desc')->textArea(['maxlength' => true, 'placeholder' =>Yii::t('app', 'Indonesian Rupiah')]) ?>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fas fa-save"></i> '.Yii::t('app','Update'), ['class' => 'btn btn-sm btn-primary m-1 float-right']) ?>
                    <?= Html::a('<i class="fas fa-undo-alt"></i> '.Yii::t('app','Back'), Url::to(['view', 'code'=>Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-info m-1 float-right']);  ?>
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
                    if((from=='update') && status){
                        $.pjax({url:'view?code='+id, container:'#p0', timeout: false});
                        return;
                    }
                    $.pjax.reload({container: '#p0', async: false});
                },
                error  : function (e) {
                    console.log(e);
                    // window.location.reload();
                }
        });
        hasClick++;
        e.stopImmediatePropagation();
        return false;
    });
    $('.datepicker').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        singleDatePicker: true,
    });
};
init();
JS;
$this->registerJs($js);
?>