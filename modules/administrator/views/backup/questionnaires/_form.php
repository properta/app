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
                <?= $form->field($model, 'title', Template::template('fas fa-hashtag'))->textInput(['maxlength' => true, 'placeholder' =>'Judul Kuisioner'])->label('Judul') ?>

                <?= $form->field($model, 'desc')->textArea(['maxlength' => true, 'placeholder' =>'', 'class' =>'summernote form-control'])->label('Keterangan') ?>
                <div class="authPrivacy">
                    <?= $form->field($model, 'schools')
                    ->dropDownList($schools??[], ['class'=>'form-control get-schools select2', 'multiple'=>true, 'value'=>isset($schools)?array_keys($schools):[], 'prompt'=>'--choose one--'])->label("Untuk Sekolah")->hint('kosong berarti semua sekolah'); ?>
                </div>

            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="form">
                    <div class="authPrivacy">
                        <?= $form->field($model, 'year_of_graduates')
                        ->dropDownList($year_of_graduates??[], ['class'=>'form-control get-year-of-graduates select2', 'multiple'=>true, 'value'=>isset($year_of_graduates)?array_keys($year_of_graduates):[], 'prompt'=>'--choose one--'])->label("Untuk Angkatan")->hint('Kosong berarti untuk semua angkatan'); ?>
                    </div>
                    <?= $form->field($model, 'status')
                        ->dropDownList([2=>'draf', 1=>'publish'], ['class'=>'form-control'])->label("Status"); 
                    ?>

                    <?= $form->field($model, 'privacy')
                        ->dropDownList(['auth'=>'user in app', 'public'=>'public'], ['class'=>'form-control'])->label("Privacy"); 
                    ?>

                    <div id="publicPrivacy">

                        <?= $form->field($model, 'slug', Template::template('fas fa-link'))->textInput(['maxlength' => true, 'placeholder' =>'url-seo-friendly'])->label('Url SEO') ?>

                    </div>

                    <?= $form->field($model, 'is_obligation')->checkbox(['uncheck' => 0, 'value' => 1])->label(False); ?>
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
$this->registerJsVar('slug', $model->slug);

$js = <<< JS

function questionnairesPrivacy(){
    if($('select#questionnaires-privacy').val()=='auth'){
        $('#publicPrivacy').hide('slow');
        $('input[name="Questionnaires[slug]"]').val('fakeslug');
        $('.authPrivacy').show('slow');
        return;
    }
    $('#publicPrivacy').show('slow');
    $('input[name="Questionnaires[slug]"]').val(slug||'');
    $('.authPrivacy').hide('slow');
}
function init(){
    questionnairesPrivacy();
    $('select#questionnaires-privacy').change(function(){
        questionnairesPrivacy();
    })
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
        return false;
    });

    $('.get-year-of-graduates').select2({
        ajax: {
            url: 'get-year-of-graduates',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('.get-schools').select2({
        ajax: {
            url: 'get-schools',
            dataType: 'json',
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

    function convertStringToUrl(str){
        let url = str.split(" ").join("-").replace(/[^a-z^A-Z^0-9^/-]+/g, "").toLowerCase();
        return url;
    }

    let urlHasChanged = false;
    $('input#questionnaires-slug').keyup((e)=>{
        urlHasChanged = true;
        if(e.target.value==convertStringToUrl($('input#questionnaires-title').val())){
            urlHasChanged = false;
        }
        $('input#questionnaires-slug').val(convertStringToUrl(e.target.value));
    })

    $('input#questionnaires-title').keyup((e)=>{
        if(!urlHasChanged){
            let url = convertStringToUrl(e.target.value);
            slug = url;
            $('input#questionnaires-slug').val(url);   
        }
    })

    $('.summernote').summernote({
        height: 200
    });
}
init()
JS;
$this->registerJs($js);
?>