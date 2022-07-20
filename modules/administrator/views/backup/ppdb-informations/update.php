<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "Form Info PPDB";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="update">
    <?= $this->render('_form', [
        'model' => $model,
        'schools' => $schools,
    ]) ?>
</div>
<?php Pjax::end(); ?>