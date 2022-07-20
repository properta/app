<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "Form Kusioner";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="update">
    <?= $this->render('_form', [
        'model' => $model,
        'campuses' => $campuses,
    ]) ?>
</div>
<?php Pjax::end(); ?>