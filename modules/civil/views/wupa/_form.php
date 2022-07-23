<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\utils\template\Template;
?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => true,
    'id' => 'form-projects',
    'enableAjaxValidation' => true,
    'options' => ['data-pjax' => 1],
    'validationUrl' => Url::toRoute($model->isNewRecord ? ['validate'] : ['validate', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]),
]); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4><?= $this->title ?></h4>
            </div>
            <div class="card-body col-6 m-auto">

                <?= $form->field($model, 'title', Template::template('fas fa-edit'))->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Project ABC')]) ?>

                <?= $form->field($model, 'desc')->textArea(['maxlength' => true, 'placeholder' => Yii::t('app', 'Type Description Here')]) ?>

                <?= $form->field($model, 'status')
                    ->radioList([1 => 'Aktif', 0 => 'Tidak Aktif'], ['value' => $model->isNewRecord ? 1 : $model->status]);
                ?>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fas fa-save"></i> ' . Yii::t('app', 'save'), ['class' => 'btn btn-sm btn-primary m-1 float-right btn-submit']) ?>
                    <?= Html::a('<i class="fas fa-undo-alt"></i> ' . Yii::t('app', 'back'), $model->isNewRecord ? 'index' : Url::to(['view', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-info m-1 float-right']);  ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
$js = <<< JS
function init(){

    $('#contractors').select2({
        ajax: {
            url: 'get-contractors',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

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
                // window.location.reload();
                alert(JSON.stringify(e));
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