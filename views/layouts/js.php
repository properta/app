<?php
$homeUrl = Yii::$app->homeUrl;
$mod = Yii::$app->controller->module->id;
$con = Yii::$app->controller->id;
$csrf = Yii::$app->request->getCsrfToken();

$this->registerJsVar('baseUrl', Yii::$app->homeUrl);
$this->registerJsVar('module', Yii::$app->controller->module->id);
$this->registerJsVar('controller', Yii::$app->controller->id);
$this->registerJsVar('_csrf', Yii::$app->request->csrfToken);

$this->registerJsVar('messageConfirm', Yii::t('app', 'Kamu Yakin?'));
$this->registerJsVar('textConfirm', Yii::t('app', "Tindakan ini tidak bisa dibatalkan"));
$this->registerJsVar('textYes', Yii::t('app', 'iya'));
$this->registerJsVar('textNo', Yii::t('app', 'batal'));
$this->registerJsVar('messageSuccess', Yii::t('app', 'Sukses'));
$this->registerJsVar('messageFailed', Yii::t('app', 'Gagal'));
$this->registerJsVar('messageAnauthorized', Yii::t('app', 'Tidak diizinkan'));
$this->registerJsVar('messageCanceled', Yii::t('app', 'Dibatalkan'));
$this->registerJsVar('textSuccess', Yii::t('app', 'Tindakan ini telah selesai'));
$this->registerJsVar('textFailed', Yii::t('app', 'Gagal, silahkan coba lagi'));
$this->registerJsVar('textAnauthorized', Yii::t('app', "Tindakan ini tidak diizinkan"));
$this->registerJsVar('textCanceled', Yii::t('app', "Tidak ada tindakan lanjutan"));
$this->registerJsVar('projectSelected', Yii::t('app', "Berhasil memilih proyek"));
$this->registerJsVar('projectSelectFailed', Yii::t('app', "Gagal memilih proyek"));

$jsHead = <<< JS
function enterSubmit(selector='.btn-submit'){
    $("body").bind('keypress', function(e) {
        if(e.which === 13) {
            $(selector).click();
        }
    });
}
JS;
$this->registerJs($jsHead, \yii\web\View::POS_HEAD);

$js = <<< JS
var showNotif = 0;
$('a').click((e)=>{
    if(!window.navigator.onLine){
        e.preventDefault();
        return false;
    }
    return true;
})
$('button').click((e)=>{
    if(!window.navigator.onLine){
        e.preventDefault();
        return false;
    }
    return true;
})
setInterval(function(){
    if(!window.navigator.onLine){
        if(showNotif==0){
            swal({
                html:'<div>'+
                '<img src="'+baseUrl+'icons/no-network.svg" />'+
                '<p style="margin-bottom:0px;">Your Connection is Down!</p>'+
                '<small>If you are in a form, please wait till connection back for safe the data!</small>'+
                '</div>',
                showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: 'Understood!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showCancelButton: false
            }).then(function (){
                if(!window.navigator.onLine){
                    $.notify("Oups, your connection still down!", 'error')
                }
                else{
                    $.notify("Yey, your connection is back!", 'success')
                }
                showNotif = 0;
            })
            $('.swal2-close').hide();
            showNotif = 1;
        }
    }
    else{
        if(showNotif==1){
            $('.swal2-confirm').trigger('click');
        }
    }
}, 1000);

let start = '';
let isInterval = '';
$(document).on('pjax:beforeSend', function(){
    start = Date.now();
});
$(document).on('pjax:send', function(){
    isInterval = setInterval(function(){
        let now = Date.now();
        if((now - start) >=1500){
            $.notify('Still working...', { 
                className: 'info',
                autoHide: false,
                clickToHide: false
            });
            clearInterval(isInterval)
        }
    },50)
});
$(document).on('pjax:success', function(){
    $('.notifyjs-wrapper').trigger('notify-hide');
    clearInterval(isInterval)

});
$(document).on('pjax:error', function(){
    $('.notifyjs-wrapper').trigger('notify-hide');
    clearInterval(isInterval)
});
$(document).on('pjax:popstate', function(){
    document.referrer;
});

$('.get-projects').select2({
    ajax: {
        url: '$homeUrl'+'site/get-projects',
        dataType: 'json',
        data: function (params) {
            var query = {
                search: params.term
            }
            return query;
        }
    }
});

$('.get-projects').on('select2:select', function (e) {
    let id = $('.get-projects').val();
    let text = $('.get-projects').select2('data')[0]['text'];
    $.ajax({
        url: baseUrl+'site/set-projects',
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            text: text,
            _csrf: _csrf
        },
        success:function(res){
            if(res){
                Swal.fire(
                    'Success',
                    projectSelected,
                    'success'
                ).then((e)=>{
                    location.reload();
                });
            }else{
                Swal.fire(
                    'Error',
                    projectSelectFailed,
                    'error'
                );
            }
        }
    })
});
JS;
$this->registerJs($js);