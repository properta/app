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
                        <a href="index.html">Civil</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">ADM</a>
                    </div>
                    <?= $this->render('civil-menu') ?>
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
                    Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad
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

<?= $this->render('js'); ?>

</html>
<?php $this->endPage() ?>