<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
$this->title = "Requests Form";

?>
<?php Pjax::begin(['id'=>'p1']); ?>
<div class="create">
    <?= $this->render('_form_create', [
        'model' => $model
    ]) ?>
</div>
<?php Pjax::end(); ?>