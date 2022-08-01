<?php

use yii\helpers\{
    Html,
    Url
};
use yii\widgets\ActiveForm;
use app\utils\template\Template;
?>

<?php $form = ActiveForm::begin([
    'id' => 'form-categories',
    'enableClientValidation' => true,
    'enableAjaxValidation' => true,
    'options' => ['data-pjax' => 1],
    'validationUrl' => Url::toRoute($model->isNewRecord ? ['validate', 'validate' => 0] : ['validate', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]),
]); ?>
<div class="row">
    <div class="col-12">
        <div class="form" id="multiple-form">
            <?= $form->field($model, 'code', Template::template('fas fa-edit'))->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Kode')])->label(false) ?>
            <?= $form->field($model, 'title')->textArea(['maxlength' => true, 'placeholder' => Yii::t('app', 'Kategori')])->label(false) ?>
            <?= $form->field($model, 'default_unit_code_id')
                ->dropDownList($units ?? [], ['class' => 'form-control', 'prompt' => Yii::t('app', '--choose one--'), 'value' => isset($units) ? array_keys($units) : [], 'id' => 'get-units'])->label(false); ?>

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
    $("body").on("beforeSubmit", "form#form-categories", function (e) {
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
                    $('#modal').modal('hide')
                }
                if((from=='update') && status){
                    $('#modal').modal('hide')
                }
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

    $('#get-units').select2({
        dropdownParent: '#modal',
        ajax: {
            url: 'get-units',
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