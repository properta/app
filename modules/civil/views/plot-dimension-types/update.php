<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
$this->title = Yii::t('app', 'Change Plot Of Lands');
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="update">
    <?= $this->render('_form', [
        'model' => $model,
        'contractors' => $contractors,
    ]) ?>
</div>
<?php Pjax::end(); ?>