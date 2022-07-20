<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "User Form";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="create">
    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles
    ]) ?>
</div>
<?php Pjax::end(); ?>