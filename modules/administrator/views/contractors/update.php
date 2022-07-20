<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Change Contractor');
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="update">
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>
<?php Pjax::end(); ?>