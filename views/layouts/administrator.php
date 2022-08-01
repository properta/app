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
            <?= $this->render('navigation') ?>
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

<?= $this->render('js'); ?>

</html>
<?php $this->endPage() ?>