<?php

use yii\helpers\{
    Html,
    Url,
    HtmlPurifier
};
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'List Artikel';

?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4> <?= $this->title ?></h4>
                </div>
                <div class="card-body">
                    SELAMAT DATANG DI APLIKASI SIPIL
                    <input type="file" class="filepond" name="filepond" multiple data-allow-reorder="true"
                        data-max-file-size="3MB" data-max-files="3">
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<< JS
FilePond.registerPlugin(FilePondPluginFileValidateType);
    const inputElement = document.querySelector('input[type="file"]');
    const pond = FilePond.create(inputElement);
    pond.setOptions({
        acceptedFileTypes: ['image/jpeg', 'image/gif', 'image/png'],
        server:'handle-file',
    });

    pond.on('processfile', (error, file) => {
        if (error) {
            $(".btn-submit").prop("disabled", true);
            return;
        }
        $(".btn-submit").prop("disabled", false);
    });

    pond.on('addfile', (error, file) => {
        $(".btn-submit").prop("disabled", true);
    });
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>