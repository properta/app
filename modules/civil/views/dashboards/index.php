<?php

use yii\helpers\{
    Html,
    Url,
    HtmlPurifier
};
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'List Artikel';

?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4> <?= $this->title ?></h4>
                </div>
                <div class="card-body">
                    SELAMAT DATANG DI APLIKASI SIPIL
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<< JS
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>