<?php

use yii\helpers\{
    Html, Url
};
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
                <?= $form->field($model, 'title', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true, 'placeholder' =>'Title of Article'])->label('Title') ?>

                <?= $form->field($model, 'skill_needed')
                    ->dropDownList($skill_needes??[], ['class'=>'form-control get-skill-needed select2', 'value'=>isset($skill_needes)?array_keys($skill_needes):[], 'prompt'=>'--choose one--'])->label("Job Type"); ?>

                <?= $form->field($model, 'requirements')->textArea(['maxlength' => true, 'placeholder' =>'', 'class' =>'summernote form-control'])->label('Requirements') ?>
                <?= $form->field($model, 'schools')
                    ->dropDownList($schools??[], ['class'=>'form-control get-schools select2', 'multiple'=>true, 'value'=>isset($schools)?array_keys($schools):[], 'prompt'=>'--choose one--'])->label("Schools"); ?>

            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="form">
                    <?= $form->field($model, 'submition_deadline', Template::template('fas fa-calendar'))->textInput(['maxlength' => true, 'class'=>'form-control datepicker', 'value'=>date('Y-m-d', $model->submition_deadline??time()), 'placeholder' =>date('Y-m-d')])->label('Submission Deadline') ?>

                    <?= $form->field($model, 'thumbnail', Template::image())->fileInput([
                            'class'=>'filepond',
                            'data-allow-reorder'=>true,
                            'data-max-file-size'=>'3MB',
                            'data-max-files'=>'1'
                        ])->label('Upload thumbnail');
                    ?>

                    <?= $form->field($model, 'company_str')
                    ->dropDownList($companies??[], ['class'=>'form-control get-companies select2', 'value'=>isset($companies)?array_keys($companies):[], 'prompt'=>'--choose one--'])->label("Company"); ?>

                    <?= $form->field($model, 'company_address_str')->textArea(['maxlength' => true, 'placeholder' =>'', 'class' =>'form-control'])->label('Company Address') ?>

                    <?= $form->field($model, 'salary_range', Template::template('fas fa-money-bill'))->textInput(['maxlength' => true, 'placeholder' =>'Rp. 3.000.000'])->label('Range of Salary') ?>

                    <?= $form->field($model, 'status')
                        ->dropDownList([2=>'draf', 1=>'publish'], ['class'=>'form-control'])->label("Status"); 
                    ?>

                </div>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fas fa-save"></i> Save', ['class' => 'btn-submit btn btn-sm btn-primary m-1 float-right']) ?>
                    <?= Html::a('<i class="fas fa-undo-alt"></i> Back', $model->isNewRecord?'index':Url::to(['view', 'code'=>Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-info m-1 float-right']);  ?>
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
        return false;
    });

    FilePond.registerPlugin(FilePondPluginFileValidateType);
    const inputElement = document.querySelector('.filepond');

    const pond = FilePond.create(inputElement);
    pond.setOptions({
        acceptedFileTypes: ['image/jpeg', 'image/gif', 'image/png'],
        server:'handle-file',
    });

    pond.on('processfile', (error, file) => {
        if (error) {
            $(".btn-submit").prop("disabled", true);
            pond2.setOptions({'disabled':true})
            return;
        }
        $(".btn-submit").prop("disabled", false);
        pond2.setOptions({'disabled':false})
    });

    pond.on('addfile', (error, file) => {
        $(".btn-submit").prop("disabled", true);
        pond2.setOptions({'disabled':true})
    });

    $('#jobvacancies-salary_range').keyup(function(e){
        let clean = e.target.value.replace(/,/g, '');
        let value = clean.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        $(this).val(value);
    })


    $('.get-schools').select2({
        ajax: {
            url: 'get-schools',
            dataType: 'JSON',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('.get-companies').select2({
        ajax: {
            url: 'get-companies',
            dataType: 'JSON',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('.get-companies').change(function () {
       $.ajax({
           url: 'get-company-address',
           dataType: 'JSON',
           data: {
               company_name: $(this).val(),
               _csrf: _csrf
            },
            success: function (data) {
                let {result} = data;
                $('#jobvacancies-company_address_str').val(result)
            }
       })
    })

    $('.get-skill-needed').select2({
        ajax: {
            url: 'get-skill-needed',
            dataType: 'JSON',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('.datepicker').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        singleDatePicker: true,
    });

    $('.summernote').summernote({
        height: 200
    });
}
init()
JS;
$this->registerJs($js);
?>