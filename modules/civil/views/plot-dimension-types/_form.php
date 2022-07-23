<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\utils\template\Template;
?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => true,
    'id' => 'form-plot-dimension-types',
    'enableAjaxValidation' => true,
    'options' => ['data-pjax' => 1],
    'validationUrl' => Url::toRoute($model->isNewRecord ? ['validate'] : ['validate', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]),
]); ?>
<div class="row">
    <div class="col-12 col-lg-6 col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><?= $this->title ?></h4>
            </div>
            <div class="card-body">
                <?= $form->field($model, 'code', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true, 'placeholder' => '0A1B2']) ?>

                <?= $form->field($model, 'title', Template::template('fas fa-edit'))->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Plot Of Lands ABC')]) ?>

                <?= $form->field($model, 'desc')->textArea(['maxlength' => true, 'placeholder' => Yii::t('app', 'Type Description Here')]) ?>
                
                <?= $form->field($model, 'project_id')
                    ->dropDownList($project??[],['class' => 'form-control select2', 'id' => 'projectId', 'prompt' => Yii::t('app', '--choose one--')]);
                ?>
                
                <?= $form->field($model, 'length', Template::template('fas fa-flag'))->textInput(['maxlength' => true, 'placeholder' => 'PKU001']) ?>

            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="form">
                    <?= $form->field($model, 'width', Template::template('fas fa-user'))->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', '100')])->label(Yii::t('app', 'Width')) ?>

                    <?= $form->field($model, 'dimension_unit_code_id')
                        ->dropDownList($project??[],['class' => 'form-control select2', 'id' => 'unitCode', 'prompt' => Yii::t('app', '--choose one--')]);
                    ?>

                    <?= $form->field($model, 'dimension_unit_code_id_str', Template::template('fas fa-edit'))->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Plot Of Lands ABC')]) ?>

                    <?= $form->field($model, 'plot_type_id')
                    ->dropDownList($project??[],['class' => 'form-control select2', 'id' => 'plotTypeId', 'prompt' => Yii::t('app', '--choose one--')]); ?>

                    <?= $form->field($model, 'plot_type_str', Template::template('fas fa-edit'))->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Plot Of Lands ABC')]) ?>
                    
                    <?= $form->field($model, 'total', Template::template('fas fa-phone'))->textInput(['maxlength' => true, 'placeholder' => '+628 1234 1234 123']) ?>
                </div>

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
$homeUrl = yii::$app->homeUrl;
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

    $('#projectId').select2({
        ajax: {
            url: '$homeUrl'+'administrator/projects/get-projects',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('#unitCode').select2({
        ajax: {
            url: '$homeUrl'+'administrator/unit-codes/get-unit-codes',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('#plotTypeId').select2({
        ajax: {
            url: '$homeUrl'+'administrator/settings/get-plot-types',
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