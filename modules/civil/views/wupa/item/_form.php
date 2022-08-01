<?php

use yii\helpers\{
    Html,
    Url
};
use yii\widgets\ActiveForm;
use app\utils\template\Template;
?>

<?php $form = ActiveForm::begin([
    'id' => 'form-items',
    'enableClientValidation' => true,
    'enableAjaxValidation' => true,
    'options' => ['data-pjax' => 1],
    'validationUrl' => Url::toRoute($model->isNewRecord ? ['validate-item'] : ['validate', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]),
]); ?>
<div class="row">
    <div class="col-12">
        <div class="form" id="multiple-form">
            <?= $form->field($model, 'code', Template::template('fas fa-edit'))->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Kode')])->label(Yii::t('app', 'Code')) ?>
            <?= $form->field($model, 'occupation_id')
                ->dropDownList($units ?? [], ['class' => 'form-control', 'prompt' => Yii::t('app', '--choose one--'), 'value' => isset($units) ? array_keys($units) : [], 'id' => 'get-occupations'])->label(Yii::t('app', 'Occupation')); ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('<i class="fas fa-save"></i> ' . Yii::t('app', 'simpan'), ['class' => 'btn-submit btn btn-sm btn-primary m-1 float-right']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php

$js = <<< JS
function init(){
    
    enterSubmit(".btn-submit");
    let hasClick = 0;
    $("body").on("beforeSubmit", "form#form-items", function (e) {
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
                $('#modal').modal('hide')
                $.pjax.reload({container: '#p0', timeout: false});
                return;
            },
            error  : function (e) {
                // window.location.reload();
                alert(JSON.stringify(e));
            }
        });
        hasClick++;
        e.stopImmediatePropagation();
        return false;
    });

    $('#get-occupations').select2({
        dropdownParent: '#modal',
        ajax: {
            url: 'get-occupations',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });
}
init()
JS;
$this->registerJs($js);
?>