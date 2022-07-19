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

                <?= $form->field($model, 'slug', Template::template('fas fa-link'))->textInput(['maxlength' => true, 'placeholder' =>'url-seo-friendly'])->label('Url SEO') ?>

                <?= $form->field($model, 'content')->textArea(['maxlength' => true, 'placeholder' =>'', 'class' =>'summernote form-control'])->label('Content') ?>

                <div class="-tw-w-auto tw-px-5 tw-bg-gray-100 -tw-mx-6">
                    <p>Optional Setting for Improve SEO</p>
                </div>

                <?= $form->field($model, 'seo_meta_data[title]', Template::template('fas fa-link'))->textInput(['maxlength' => true, 'value'=>!$model->isNewRecord?($meta->title??''):'', 'placeholder' =>'Seo Title'])->label('SEO Title') ?>

                <?= $form->field($model, 'seo_meta_data[desc]')->textArea(['maxlength' => true, 'value'=>!$model->isNewRecord?($meta->desc??''):'', 'placeholder' =>'', 'class'=>'form-control'])->label('SEO Meta Desc') ?>

            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="form">
                    <div class="">
                        <?= $form->field($model, 'category_id')
                        ->dropDownList($categories??[], ['class'=>'form-control get-categories select2', 'prompt'=>'--choose one--'])->label("Category"); ?>
                        <p class="-mt-5 float-right">
                            <?= Html::a('add category', ["@web/".Yii::$app->controller->module->id."/masters", 'type'=>'article-categories'], ['class' => 'profile-link']) ?>
                        </p>
                    </div>

                    <?= $form->field($model, 'status')
                        ->dropDownList([2=>'draf', 1=>'publish'], ['class'=>'form-control'])->label("Status"); 
                    ?>
                    <?= $form->field($model, 'tags')
                        ->dropDownList($tags??[], ['class'=>'form-control get-tags select2', 'multiple'=>true, 'value'=>isset($tags)?array_keys($tags):[]])->label("Tags"); ?>

                    <?= $form->field($model, 'thumbnail', Template::image())->fileInput([
                        'class'=>'filepond',
                        'data-allow-reorder'=>true,
                        'data-max-file-size'=>'3MB',
                        // 'required'=>$model->image?false:true,
                        'data-max-files'=>'1'
                    ])->label('Tumbnail') ?>

                </div>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fas fa-save"></i> Save', ['class' => 'btn-submit btn btn-sm btn-primary m-1 float-right']) ?>
                    <?= Html::a('<i class="fas fa-undo-alt"></i> Back', 'index', ['class' => 'btn btn-sm btn-info m-1 float-right']);  ?>
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
                    if((from=='create' || from=='update') && status){
                        $.pjax({url:'index', container:'#p0', timeout: false});
                        return;
                    }
                    $.pjax.reload({container: '#p0', timeout: false});
                },
                error  : function () {
                    window.location.reload();
                }
        });
        hasClick++;
        return false;
    });

    FilePond.registerPlugin(FilePondPluginFileValidateType);
    const inputElement = document.querySelector('input[type="file"]');
    const pond = FilePond.create(inputElement);
    pond.setOptions({
        acceptedFileTypes: ['image/jpeg', 'image/gif', 'image/png'],
        server:'handle-file',
    });

    pond.on('processfile', (error, file) => {
        if (error) {
            $(".btn-submit").prop("disabled", true);
            return;
        }
        $(".btn-submit").prop("disabled", false);
    });

    pond.on('addfile', (error, file) => {
        $(".btn-submit").prop("disabled", true);
    });

    $('.get-categories').select2({
        ajax: {
            url: 'get-categories',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            }
        }
    });

    $('.get-tags').select2({
        ajax: {
            url: 'get-tags',
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

    let titleHasChanged = false;
    $('input#articles-seo_meta_data-title').keyup((e)=>{
        titleHasChanged = true;
        if(e.target.value==$('input#articles-title').val()){
            titleHasChanged = false;
        }
    })

    let urlHasChanged = false;
    $('input#articles-slug').keyup((e)=>{
        urlHasChanged = true;
        if(e.target.value==convertStringToUrl($('input#articles-title').val())){
            urlHasChanged = false;
        }
        $('input#articles-slug').val(convertStringToUrl(e.target.value));
    })

    $('input#articles-title').keyup((e)=>{
        if(!urlHasChanged){
            let url = convertStringToUrl(e.target.value);
            $('input#articles-slug').val(url);   
        }
        if(!titleHasChanged){
            $('input#articles-seo_meta_data-title').val(e.target.value);
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