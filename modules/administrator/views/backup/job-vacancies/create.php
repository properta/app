<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
$this->title = "Form Lowongan Kerja";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
<?php Pjax::end(); ?>