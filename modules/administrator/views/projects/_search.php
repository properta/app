<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'id' => 'filter',
    'method' => 'get',
    'options' => [
        'data-pjax' => 1
    ],
]); ?>

<div class="input-group">
    <?= $form->field($model, 'query', ['options' => ['tag' => false], 'errorOptions' => ['tag' => false]])->textInput(['placeholder' => Yii::t('app', 'Search')])->label(false) ?>

    <div class="input-group-btn">
        <?= Html::submitButton('<i class="fas fa-search"></i>', ['class' => 'btn btn-primary']) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>
<?php
$js = <<< JS
$("body").on("beforeSubmit", "form#filter", function (e) {
    var form = $(this);
    if (form.find(".has-error").length) 
    {
        return false;
    }
    return true;
});
JS;
$this->registerJs($js);
?>