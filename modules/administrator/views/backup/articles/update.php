<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
$this->title = "Company Form";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="update">
    <?= $this->render('_form', [
        'model' => $model,
        'meta' => $meta,
        'categories' => $categories,
        'tags' => $tags
    ]) ?>
</div>
<?php Pjax::end(); ?>