<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Change Unit Code');
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="update">
    <?= $this->render('_form_update', [
        'model' => $model
    ]) ?>
</div>
<?php Pjax::end(); ?>