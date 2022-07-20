<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "Welder Form";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="update">
    <?= $this->render('_form', [
        'model' => $model,
        'encryptor' => $encryptor,
        'roles' => $roles
    ]) ?>
</div>
<?php Pjax::end(); ?>