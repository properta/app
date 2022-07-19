<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
$this->title = "Teams Form";

?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="create">
    <?= $this->render('_form', [
        'model' => $model,
        'role' => $role
    ]) ?>
</div>
<?php Pjax::end(); ?>