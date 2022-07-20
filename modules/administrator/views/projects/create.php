<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Add Project');
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="create">
    <?= $this->render('_form', [
        'model' => $model,
        'contractors' => $contractors,
    ]) ?>
</div>
<?php Pjax::end(); ?>