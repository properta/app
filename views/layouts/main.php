<?php

/* @var $this \yii\web\View */
/* @var $content string */
use app\assets\StislaAsset;
use yii\bootstrap4\Html;
use app\utils\breadcrumb\Breadcrumb as BC;
use yii\bootstrap4\Modal;

StislaAsset::register($this);
$router = $this->context->action->uniqueId;
$breadcrumb = BC::generateBreadcrumbs($router, "breadcrumb-item");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<!-- <body class="d-flex flex-column h-100"> -->

<body>
    <?php $this->beginBody() ?>
    <div id="main" class="tw-min-h-screen tw-bg-transparent">
        <!-- wrapper -->
        <div id="wrapper" class="tw-max-w-2xl tw-bg-transparent tw-mx-auto tw-min-h-screen tw-grid tw-content-center">
            <!-- logo -->
            <section id="logo" class="tw-w-full tw-bg-transparent tw-mt-16">
                <div class="tw-flex tw-justify-center">
                    <!-- <img src="image/logo.jpg" alt="brand-logo" /> -->
                    <span class="tw-text-4xl tw-text-bold">Sarez Property</span>
                </div>
            </section>
            <!-- logo end -->
            <section id="main-menu" class="tw-mt-10">
                <ul class="tw-grid tw-grid-cols-3 tw-grid-rows-3 tw-gap-6 tw-w-full tw-bg-transparent tw-px-0">
                    <li>
                        <a href="<?= Yii::$app->homeUrl."administrator/dashboards" ?>">
                            <div class="tw-w-full tw-h-28 tw-shadow-sm tw-bg-white tw-rounded-md tw-pt-1">
                                <div class="tw-mt-6 tw-grid tw-justify-center tw-content-center">
                                    <span class="tw-text-center"><i class="fas fa-cogs tw-text-3xl"></i></span>
                                    <p>Administrator</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Yii::$app->homeUrl."civil/dashboards" ?>">
                            <div class="tw-w-full tw-h-28 tw-shadow-sm tw-bg-white tw-rounded-md tw-pt-1">
                                <div class="tw-mt-6 tw-grid tw-justify-center tw-content-center">
                                    <span class="tw-text-center"><i class="fas fa-hard-hat tw-text-3xl"></i></span>
                                    <p>Aplikasi Sipil</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Yii::$app->homeUrl."budgeting/dashboards" ?>">
                            <div class="tw-w-full tw-h-28 tw-shadow-sm tw-bg-white tw-rounded-md tw-pt-1">
                                <div class="tw-mt-6 tw-grid tw-justify-center tw-content-center">
                                    <span class="tw-text-center"><i class="fas fa-money-bill tw-text-3xl"></i></span>
                                    <p>Rencana Anggran Biaya</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Yii::$app->homeUrl."budgeting/dashboard" ?>">
                            <div class="tw-w-full tw-h-28 tw-shadow-sm tw-bg-white tw-rounded-md tw-pt-1">
                                <div class="tw-mt-6 tw-grid tw-justify-center tw-content-center">
                                    <span class="tw-text-center"><i class="fas fa-cogs tw-text-3xl"></i></span>
                                    <p>Under Contruction</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Yii::$app->homeUrl."budgeting/dashboard" ?>">
                            <div class="tw-w-full tw-h-28 tw-shadow-sm tw-bg-white tw-rounded-md tw-pt-1">
                                <div class="tw-mt-6 tw-grid tw-justify-center tw-content-center">
                                    <span class="tw-text-center"><i class="fas fa-cogs tw-text-3xl"></i></span>
                                    <p>Under Contruction</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Yii::$app->homeUrl."budgeting/dashboard" ?>">
                            <div class="tw-w-full tw-h-28 tw-shadow-sm tw-bg-white tw-rounded-md tw-pt-1">
                                <div class="tw-mt-6 tw-grid tw-justify-center tw-content-center">
                                    <span class="tw-text-center"><i class="fas fa-cogs tw-text-3xl"></i></span>
                                    <p>Under Contruction</p>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </section>
        </div>
        <!-- wrapper end -->
    </div>
    <?php $this->endBody() ?>
    <?php
        Modal::begin([
            'title' => '<span id="modalTitle">Modal</span>',
            'centerVertical' => true,
            'id'=>'modal',
            'size' => 'modal-lg',
            'scrollable' => true,
        ]);

        echo '<div id="modalContent"></div>';

        Modal::end();
    ?>
</body>

<?php
$homeUrl = Yii::$app->homeUrl;
$mod = Yii::$app->controller->module->id;
$con = Yii::$app->controller->id;

$csrf = Yii::$app->request->getCsrfToken();
$js = <<< JS
$('document').ready(()=>{  
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
            data: {
                id: id,
                text: text,
                _csrf: _csrf
            },
            success:function(res){
                if(res){
                    swal(
                        'Success',
                        'Berhasil Memilih Sekolah!',
                        'success'
                    ).then((e)=>{
                        location.reload();
                    });
                }else{
                    swal(
                        'Error',
                        'Gagal Memilih Sekolah!',
                        'error'
                    );
                }
            }
        })
    });
});
JS;
$this->registerJs($js);
$this->registerJsVar('baseUrl', Yii::$app->homeUrl);
$this->registerJsVar('module', Yii::$app->controller->module->id);
$this->registerJsVar('controller', Yii::$app->controller->id);
$this->registerJsVar('_csrf', Yii::$app->request->csrfToken);
?>

</html>
<?php $this->endPage() ?>