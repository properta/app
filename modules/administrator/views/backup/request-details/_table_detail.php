<?php

use yii\helpers\Url;
use yii\web\View;

?>

<div class="table-responsive">
    <table id="htmlgrid" class="testgrid table table-md table-striped">
        <thead>
            <tr>
                <th class="text-nowrap">Request Number</th>
                <th class="text-nowrap">Join Number</th>
                <th class="text-nowrap">Drawing Number</th>
                <th class="text-nowrap">Line Number</th>
                <th>Diameter</th>
                <th>Thickness</th>
                <th>Material</th>
                <th>Method</th>
                <th class="text-nowrap">Line Class</th>
                <th>Shop</th>
                <th class="text-nowrap">Welder Process</th>
                <th>Welder</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

            <?php if (count($request_details) === 0) : ?>
            <tr>
                <td colspan="13" class="text-center">Detail Not Available</td>
            </tr>
            <?php endif; ?>


            <?php foreach ($request_details as $index => $item) : ?>

            <tr id="<?= $item->id ?>">
                <td><?= $item->request_number ?></td>
                <td><?= $item->joint_number ?></td>
                <td><?= $item->drawing_number ?></td>
                <td class="text-center"><?= $item->line_number ?></td>
                <td class="text-center"><?= $item->diameter_str ?></td>
                <td class="text-center"><?= $item->thickness ?></td>
                <td class="font-weight-bold text-nowrap">
                    <?= implode(", ", array_map(function ($x) {
                            return $x->value_;
                        }, json_decode($item->material_str))) ?>
                </td>
                <td><?= $item->method->value_ ?? "-" ?></td>
                <td><?= $item->lineClass->value_ ?? "-" ?></td>
                <td><?= $item->shop->value_ ?? "-" ?></td>
                <td class="font-weight-bold text-nowrap">
                    <?= implode(", ", array_map(function ($x) {
                            return $x->full_name ?? '';
                        }, json_decode($item->multiple_welder_id))) ?>
                </td>
                <td class="font-weight-bold text-nowrap">
                    <?= implode(", ", array_map(function ($x) {
                            return $x->value_ ?? '';
                        }, json_decode($item->multiple_process_id))) ?>
                </td>
                <td>
                    <button onclick="deleteDetails('<?= Yii::$app->encryptor->encodeUrl($item->id) ?>')"
                        class="btn btn-outline-danger btn-sm btn-icon btn-delete"><i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?php
$csrf = Yii::$app->request->getCsrfToken();
$this->registerJsVar('url',  Url::to('@web/administrator/request-details/delete', true));
$js = <<< JS
function deleteDetails(id){
    if(confirm("Delete Item Ini")){
         $.ajax({
            url: url ,
            type: 'post',
            data: {
                code: id,
                _csrf:_csrf
            },
            success:(resp) => {
                $.pjax.reload({container: '#p0'});
            }
        });
    }
}
JS;
$this->registerJs($js, View::POS_BEGIN);
?>