<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
$this->title = "Project Form";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>

<div class="update">
    <?= $this->render('_form', [
        'model' => $model,
        'encryptor' => $encryptor,
        'companies' => $companies
    ]) ?>
</div>
<?php Pjax::end(); ?>