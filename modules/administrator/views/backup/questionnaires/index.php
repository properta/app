<?php
use yii\helpers\{
    Html,
    Url,
    HtmlPurifier
};
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'List Kuisioner';

?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Kuisioner', ['create'], ['class' => 'btn btn-info m-1']) ?>
            </p>
            <div class="card">
                <div class="card-header">
                    <h4> <?=  $this->title ?></h4>
                    <div class="card-header-action">
                        <?= $this->render('_search', ['model' => $searchModel]) ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                // 'filterModel' => $searchModel,
                                'tableOptions' => ['class' => 'table table-striped'],
                                'summaryOptions' => ['class' => 'badge badge-light m-2'],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'contentOptions' => ['style' => 'width:10px;'],    
                                        'header' => 'No.'
                                    ],
                                    [
                                        'attribute' => 'title',
                                        'label' => 'Title',
                                        'format' => 'raw',
                                        'contentOptions' => ['style' => 'width:200px;'],    
                                        'value' => function($model){
                                            return $model->title??"";

                                        }
                                    ],
                                    [
                                        'attribute' => 'schools',
                                        'label' => 'School',
                                        'format' => 'raw',
                                        'contentOptions' => ['style' => 'width:210px;'],    
                                        'value' => function($model){
                                            $isReturn = ""; 
                                            if($model->schools && $model->privacy==="auth"):
                                                $school = json_decode($model->schools);
                                                foreach($school as $key => $val):
                                                    $isReturn.= "<p class='tw-mb-1 tw-bg-blue-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-w-fit'>{$val->text}</p>"; 
                                                endforeach;
                                            else:
                                                $isReturn = "<span class='tw-bg-blue-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs'>Semua Sekolah</span>";
                                            endif;
                                            return "<div>$isReturn</div>";
                                        }
                                    ],
                                    [
                                        'attribute' => 'year_of_graduates',
                                        'label' => 'Graduate Year',
                                        'format' => 'raw',
                                        'contentOptions' => ['style' => 'width:160px;'],    
                                        'value' => function($model){
                                            $isReturn = ""; 
                                            if($model->year_of_graduates && $model->privacy==="auth"):
                                                $year = json_decode($model->year_of_graduates);
                                                $max = 2;
                                                foreach($year as $key => $val):
                                                    if($key<= $max-1):
                                                        $isReturn.= "<p class='tw-mb-1 tw-bg-gray-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-w-fit'>{$val->text}</p>"; 
                                                    else:
                                                        $left = count($year) - $max;
                                                        $isReturn.= "<p class='tw-mb-1 tw-bg-blue-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-w-fit'>...{$left} others</p>"; 
                                                        break;
                                                    endif;
                                                    endforeach;
                                            else:
                                                $isReturn = "<span class='tw-bg-gray-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs'>Semua Angkatan</span>";
                                            endif;
                                            return "<div class='tw-flex tw-flex-wrap tw-gap-1'>$isReturn</div>";
                                        }
                                    ],
                                    [
                                        'label' => 'Pertanyaan',
                                        'format' => 'raw',
                                        'contentOptions' => ['style' => 'width:50px;'],    
                                        'value' => function($model){
                                            return "<span class='tw-bg-red-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs'>Belum ada</span>";
                                        }
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'label' => 'Status',
                                        'format' => 'raw',
                                        'contentOptions' => ['style' => 'width:50px;'],    
                                        'value' => function($model){
                                            return $model->status==1?"<span class='tw-bg-green-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs'>Publish</span>":"<span class='tw-bg-blue-400 tw-text-xs tw-px-3 tw-py-1 tw-rounded-full tw-text-white'>Draft</span>";
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'contentOptions' => ['style' => 'width:150px;'],    
                                        'header' => 'Action',
                                        'visibleButtons' => [
                                            'update' => false,
                                            'delete' => false,
                                            'view' => true,
                                        ],
                                        'template' => '{view}',
                                        'buttons' => array(
                                            'view' => function($url, $model, $key) {
                                                return Html::a('<i class="fas fa-eye"></i> Detail', Url::to(['view', 'code' => Yii::$app->encryptor->encodeUrl($model->id)]), ['class' => 'btn btn-sm btn-primary m-1']);
                                            }
                                        )
                                    ],
                                ],
                            ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<< JS
$(document).on('pjax:popstate', function(){
    $.pjax.reload({container: '#p0', timeout: false});
});
JS;
$this->registerJs($js);
?>
<?php Pjax::end(); ?>