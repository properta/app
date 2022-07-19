<div class="col-3">
    <?= $form->field($model, 'request_number')->textInput(['maxlength' => true, 'placeholder' => 'Req']) ?>
</div>
<div class="col-3">
    <?= $form->field($model, 'joint_number')->textInput(['maxlength' => true, 'placeholder' => 'Joint']) ?>
</div>

<div class="col-3">
    <?= $form->field($model, 'line_number')->textInput([]) ?>
</div>
<div class="col-3">
    <?= $form->field($model, 'diameter_str')->textInput([]) ?>
</div>
<div class="col-3">
    <?= $form->field($model, 'thickness')->textInput([]) ?>
</div>
<div class="col-6">
    <?= $form->field($model, 'material_str[]')->dropDownList($resources['materials'] ?? [], ['class' => 'select2', 'prompt' => 'Choose Material', 'multiple' => '']) ?>
</div>
<div class="col-3">
    <?= $form->field($model, 'method_id')->dropDownList($resources['inspection_methods'] ?? [], ['class' => 'select2', 'prompt' => 'Choose Method']) ?>
</div>
<div class="col-3">
    <?= $form->field($model, 'line_class_id')->dropDownList($resources['line_classes'] ?? [], ['class' => 'select2', 'prompt' => 'Choose Line Class']) ?>
</div>
<div class="col-3">
    <?= $form->field($model, 'shop_id')->dropDownList($resources['shoops'] ?? [], ['class' => 'select2', 'prompt' => 'Choose Material']) ?>
</div>


<div class="col-12">
    <hr>
</div>

<div class="col-4">
    <div class="form-group">
        <button class="btn btn-primary btn-block">
            Save Change
        </button>
    </div>
</div>
