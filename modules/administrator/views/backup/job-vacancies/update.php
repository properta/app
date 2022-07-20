<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "Form Lowongan Kerja";
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="update">
    <?= $this->render('_form', [
        'model' => $model,
        'schools' => $schools,
        'skill_needes' => $skill_needes,
        'companies' => $companies,
    ]) ?>
</div>
<?php Pjax::end(); ?>