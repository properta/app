<?php

/**
 * @var $this
 * View
 */

?>

    <style>
        .form-control-sm {
            border: unset;
            border-radius: unset;
            border-bottom: 1px solid #f7f7f7;
        }

        p, ul:not(.list-unstyled), ol {
            line-height: unset !important;
        }
    </style>

    <div class="table-responsive">
        <table class="table" id="table-mother-fucker">
            <thead>
            <tr class="clone">
                <th class="text-nowrap">
                    Request Number
                </th>

                <th class="text-nowrap">
                    Join Number
                </th>

                <th class="">Add</th>
            </tr>
            </thead>
            <tbody>
            <tr class="clone" data-key="0">
                <td class="p-1 pl-4" style="width:100px;">
                    <input type="text" name="request_number[]" placeholder="Req Number"
                           class="form-control-sm form"/>
                </td>
                <td class="p-1" style="width: 100px;">
                    <input type="text" name="join_number[]" placeholder="Join Number"
                           class="form-control-sm form"/>
                </td>
                <td class="">
                    <button class="btn btn-sm btn-danger btn-tr-mother-fucker">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>

            <tr style="border-bottom: 1px dashed #cccccc" class="clone" data-key="0">
                <td colspan="3">
                    <table class="table table-form" id="t-0">
                        <thead>
                        <tr>
                            <th class="text-nowrap">
                                Line Number
                            </th>

                            <th class="text-nowrap">
                                Diameter
                            </th>

                            <th class="text-nowrap">
                                Thickness
                            </th>

                            <th class="text-nowrap">
                                Material
                            </th>

                            <th class="text-nowrap">
                                Welder
                            </th>

                            <th class="text-nowrap">
                                Welder Pcs
                            </th>

                            <th class="text-center text-nowrap">
                                <button data-key="0" class="btn btn-sm btn-outline-primary btn-add-item">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="p-1">
                                <input type="text" name="line_number[0][]" placeholder="Line Number"
                                       class="form-control-sm form-line_number form"/>
                            </td>

                            <td class="p-1 text-center">
                                <input type="text" name="diameter_str[0][]" placeholder="Diamater"
                                       class="form-control-sm form-diameter form"
                                       style="width: 80px !important;"/>
                            </td>

                            <td class="p-1 text-center">
                                <input type="text" name="thickness[0][]" placeholder="Thickness"
                                       class="form-control-sm form-thickness form"
                                       style="width: 80px !important;"/>
                            </td>

                            <td class="p-1">
                                <select name="material_str[0][]" multiple class="material form-material form">
                                    <?php foreach ($resources['materials'] ?? [] as $i => $item): ?>
                                        <option value="<?= $i ?>"> <?= $item ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>

                            <td class="p-1">
                                <select name="multiple_welder_id[0][]" multiple class="welder form-welder form">
                                    <?php foreach ($resources['materials'] ?? [] as $i => $item): ?>
                                        <option value="<?= $i ?>"> <?= $item ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>

                            <td class="p-1">
                                <select name="multiple_process_id[0][]" multiple
                                        class="welder_process form-welder_process form">
                                    <?php foreach ($resources['materials'] ?? [] as $i => $item): ?>
                                        <option value="<?= $i ?>"> <?= $item ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>

                            <td class="text-center text-nowrap">
                                <button class="btn btn-sm btn-danger btn-item-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>


            </tbody>
        </table>

        <button class="btn btn-primary btn-add"> Add Item</button>

        <button type="submit" class="btn btn-primary btn-submit"> Send</button>
    </div>


<?php

$js = <<< JS

$('.material').select2({
    tags: true,
    allowClear: true,
    placeholder: "Choose"
});

$('.welder').select2({
    tags: true,
    allowClear: true,
    placeholder: "Choose"
});

$('.welder_process').select2({
    tags: true,
    allowClear: true,
    placeholder: "Choose"
});


$('#table-form').on('click', '.btn-delete', (e) => {
    $(e.target).closest('tr').remove();
})

$('.select2-selection').css('border-radius','0px')
$('.select2-selection').css('border','unset').css('border-bottom', '1px solid #f7f7f7')

let i = 0;

$('.btn-add').click((e) => {
    e.preventDefault();
    i = i + 1;
    const row0 = $($('#table-mother-fucker > tbody > tr')[0]).clone();
    const tmp = $($($('#table-mother-fucker > tbody > tr')[1]).find('table > tbody > tr')[0]).clone();
    const row1 = $($('#table-mother-fucker > tbody > tr')[1]).clone();
    $(row1).find('table > tbody > tr').remove();
    $(row1).find('table > tbody ').append(tmp);
    
    $('#table-mother-fucker > tbody > tr:last').after(row0);
    $('#table-mother-fucker > tbody > tr:last').after(row1);
    
     $(row0).find('input:text').val('');
     $(row0).attr('data-key', i);
     $(row1).attr('data-key', i);
     $(row1).find('table').attr('id', 't-' + i);
     $(row1).find('input:text').val('');   
     $(row1).find('.form-line_number').attr('name', 'line_number['+(i)+'][]');
     $(row1).find('.form-diameter').attr('name', 'diameter_str['+(i)+'][]');
     $(row1).find('.form-thickness').attr('name', 'thickness['+(i)+'][]');
     $(row1).find('.form-material').attr('name', 'material_str['+(i)+'][]');
     $('.material-0-1').last().next().next().remove()
     $(row1).find('.form-welder').attr('name', 'multiple_welder_id['+(i)+'][]');
     $(row1).find('.form-welder_process').attr('name', 'multiple_process_id['+(i)+'][]');
     $(row1).find('.btn-add-item').attr('data-key', i.toString());
     
     after();
    
});

$('.btn-add-item').click((e) => {
    e.preventDefault();
    const index = $(e.currentTarget).data('key');
    const cln = $($('#t-'+index + ' > tbody > tr')[0]).clone();
    $('#t-'+index + ' > tbody > tr:last').after(cln);
});

$('#table-mother-fucker').on('click', '.btn-tr-mother-fucker', (e) => {
    e.preventDefault()
    $('*[data-key="' + ($(e.target).closest('tr').data('key')) +'"]').remove();
});

$('.table-form').on('click', '.btn-item-delete', (e) => {
     e.preventDefault()
    $(e.currentTarget).closest('tr').remove();
});

$('#table-mother-fucker').on('click', '.btn-add-item', (e) => {
    e.preventDefault();
    const index = $(e.currentTarget).data('key');
    const cln = $($('#t-'+index + ' > tbody > tr')[0]).clone();
    $('#t-'+index + ' > tbody > tr:last').after(cln);
    after();
});

$('.btn-submit').click((e) => {
    
    
})


const after = () => {
    $('.material').select2({
    tags: true,
    allowClear: true,
    placeholder: "Choose"
});

$('.welder').select2({
    tags: true,
    allowClear: true,
    placeholder: "Choose"
});

$('.welder_process').select2({
    tags: true,
    allowClear: true,
    placeholder: "Choose"
});
}

JS;

$this->registerJs($js);
