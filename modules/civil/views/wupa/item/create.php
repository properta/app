<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Add Work Unit Price Analysis');
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="create">
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>
<?php Pjax::end(); ?>