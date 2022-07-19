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
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar" style="z-index:unset">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                    class="fas fa-search"></i></a></li>
                    </ul>
                    <div class="form-group col-6">
                        <select class="form-control select2 get-projects">
                            <?php if (Yii::$app->session->get('id')) : ?>
                            <option selected value="<?= Yii::$app->session->get('id') ?>">
                                <?= Yii::$app->session->get('text') ?>
                            </option>
                            <?php else : ?>
                            <option>--Choose Projects--</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image"
                                src="<?= Yii::$app->user->identity->image ?? Yii::$app->homeUrl . "theme/stisla/assets/img/avatar/avatar-1.png" ?>"
                                class="rounded-circle profile-widget-picture mt-n3" style="width:32px; height:32px">
                            <div class="d-sm-none d-lg-inline-block">Hi,
                                <?= Yii::$app->user->identity->full_name ?? "Annonym" ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?= \yii\helpers\Url::to('administrator/profiles/me', true) ?>"
                                class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <!--                            </a>-->
                            <div class="dropdown-divider"></div>
                            <a href="<?= \yii\helpers\Url::to('site/logout', true) ?>" data-method="post"
                                class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html">Administrator</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">ADM</a>
                    </div>
                    <?= $this->render('administrator-menu') ?>
                    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                        <a href="<?= Yii::$app->homeUrl; ?>" class="btn btn-primary btn-lg btn-block btn-icon-split">
                            <i class="fas fa-meteor"></i> Main Menu?
                        </a>
                    </div>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <!-- breadcrumb -->
                    <div class="section-header">
                        <h1><?= $this->context->title ? $this->context->title : ucfirst(Yii::$app->controller->id) ?>
                        </h1>
                        <div class='section-header-breadcrumb'>
                            <?= $breadcrumb ?>
                        </div>
                    </div>
                    <!-- endbteadcrumb -->
                    <!-- main content -->
                    <?= $content ?>
                    <!-- end main content -->
                </section>
            </div>


            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; <?= date('Y') ?> <div class="bullet"></div> Design By <a
                        href="https://nauval.in/">Muhamad
                        Nauval Azhar</a>
                </div>
                <div class="footer-right">
                    2.3.0
                </div>
            </footer>
        </div>
    </div>
    <?php $this->endBody() ?>
    <?php
    Modal::begin([
        'title' => '<span id="modalTitle">Modal</span>',
        'centerVertical' => true,
        'id' => 'modal',
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

$this->registerJs($js);
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
?>

</html>
<?php $this->endPage() ?>