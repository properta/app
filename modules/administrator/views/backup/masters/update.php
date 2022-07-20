<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "$title Form";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="update">
    <?= $this->render('_form', [
        'model' => $model,
        'title' => $title,
    ]) ?>
</div>
<?php Pjax::end(); ?>