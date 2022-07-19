<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
$this->title = "$title Form";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="create">
    <?= $this->render('_form', [
        'model' => $model,
        'scenario' => $scenario,
    ]) ?>
</div>
<?php Pjax::end(); ?>