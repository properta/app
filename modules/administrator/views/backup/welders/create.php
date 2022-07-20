<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "Welder Form";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="create">
    <?= $this->render('_form', [
        'model' => $model,
        'identityType' => $identityType
    ]) ?>
</div>
<?php Pjax::end(); ?>