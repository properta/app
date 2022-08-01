<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\utils\template\Template;
?>

<?php $form = ActiveForm::begin([
    'id'=>'request-form',
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>true,
    'options'=>['data-pjax'=>1],
    'validationUrl' => Url::toRoute(['validate']),
    ]); ?>
<div class="card-body">
    <div class="row">
        <!-- <div class="col-6">
            <?= $form->field($model, 'code', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true, 'placeholder' =>'PL-001']) ?>
        </div> -->
        <div class="col-12">
            <?= $form->field($model, 'title', Template::template('fas fa-flag'))->textInput(['maxlength' => true, 'placeholder' =>'']) ?>
        </div>
        <div class="col-12">
            <?= $form->field($model, 'dimension_id')->dropDownList($dimension??[],['class' => 'form-control select2', 'id' => 'dimension_id', 'prompt' => Yii::t('app', '--choose one--')]); ?>
        </div>
        <div class="col-12">
            <?= $form->field($model, 'desc')->textArea(['maxlength' => true, 'placeholder' =>Yii::t('app', '')]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'building_permit_number', Template::template('fas fa-flag'))->textInput(['maxlength' => true, 'placeholder' =>'']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'excess_str', Template::template('fas fa-flag'))->textInput(['maxlength' => true, 'placeholder' =>'']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'excess_desc_id')->dropDownList($excessDesc??[],['class' => 'form-control select2', 'id' => 'excess_desc_id', 'prompt' => Yii::t('app', '--choose one--')]); ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'excess_desc_str', Template::template('fas fa-flag'))->textInput(['maxlength' => true, 'placeholder' =>'']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'marker_area_id')->dropDownList($markerArea??[],['class' => 'form-control select2', 'id' => 'marker_area_id', 'prompt' => Yii::t('app', '--choose one--')]); ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'marker_area_str', Template::template('fas fa-flag'))->textInput(['maxlength' => true, 'placeholder' =>'']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'wind_direction_id')->dropDownList($windDirection??[],['class' => 'form-control select2', 'id' => 'wind_direction_id', 'prompt' => Yii::t('app', '--choose one--')]); ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'marker_area_str', Template::template('fas fa-flag'))->textInput(['maxlength' => true, 'placeholder' =>'']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'excess_unit_code_id')->dropDownList($excessNitCode??[],['class' => 'form-control select2', 'id' => 'excess_unit_code_id', 'prompt' => Yii::t('app', '--choose one--')]); ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'excess_unit_code_str', Template::template('fas fa-flag'))->textInput(['maxlength' => true, 'placeholder' =>'']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'latitude', Template::template('fas fa-flag'))->textInput(['maxlength' => true, 'placeholder' =>'']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'longitude', Template::template('fas fa-flag'))->textInput(['maxlength' => true, 'placeholder' =>'']) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fas fa-save"></i> '.Yii::t('app', 'Save'), ['class' => 'btn btn-sm btn-primary m-1 float-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
$homeUrl = Yii::$app->homeUrl;
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
                    $('#modal').modal('hide');
                    $.pjax.reload({container: '#p0', timeout: false});
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

    $('#dimension_id').select2({
        ajax: {
            url: '$homeUrl'+'civil/plot-of-lands/get-dimensions',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('#excess_desc_id').select2({
        ajax: {
            url: '$homeUrl'+'civil/plot-of-lands/excess-desc',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('#marker_area_id').select2({
        ajax: {
            url: '$homeUrl'+'civil/plot-of-lands/markers',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('#wind_direction_id').select2({
        ajax: {
            url: '$homeUrl'+'civil/plot-of-lands/m-wind-directions',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('#excess_unit_code_id').select2({
        ajax: {
            url: '$homeUrl'+'civil/plot-of-lands/m-unit-codes',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

};
init();
JS;
$this->registerJs($js);
?>