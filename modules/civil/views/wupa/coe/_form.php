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
            <?= $form->field($model, 'sub_item_group_id')
                ->dropDownList($units ?? [], ['class' => 'form-control', 'prompt' => Yii::t('app', '--choose one--'), 'value' => isset($units) ? array_keys($units) : [], 'id' => 'get-sub-item-groups'])->label(Yii::t('app', 'Group')); ?>
            <?= $form->field($model, 'sub_item_str')
                ->dropDownList($units ?? [], ['class' => 'form-control', 'disabled' => true, 'prompt' => Yii::t('app', '--choose one--'), 'value' => isset($units) ? array_keys($units) : [], 'id' => 'get-sub-items'])->label(Yii::t('app', 'Item')); ?>
            <?= $form->field($model, 'coefficient', Template::template('fas fa-edit'))->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', '1')])->label(Yii::t('app', 'Coe')) ?>

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

    $('#get-sub-item-groups').select2({
        dropdownParent: '#modal',
        ajax: {
            url: 'get-sub-item-groups',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('#get-sub-item-groups').change(function () {
        $('#get-sub-items').removeAttr('disabled');
    })

    $('#get-sub-items').select2({
        dropdownParent: '#modal',
        ajax: {
            url: 'get-sub-items',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                    group_id: $('#get-sub-item-groups').val()
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