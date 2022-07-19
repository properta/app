<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
$this->title = "Form Info PPDB";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="update">
    <?= $this->render('_form', [
        'model' => $model,
        'campuses' => $campuses,
    ]) ?>
</div>
<?php Pjax::end(); ?>