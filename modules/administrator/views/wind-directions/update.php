<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
$this->title = Yii::t('app','Change Wind Direction')
;
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="update">
    <?= $this->render('_form_update', [
        'model' => $model
    ]) ?>
</div>
<?php Pjax::end(); ?>