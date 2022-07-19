<?php
use yii\helpers\{
    Html,
    Url,
    HtmlPurifier
};
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'List Loker';

?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/site/_message') ?>
<div class="index">
    <div class="row">
        <div class="col-12">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Lokers', ['create'], ['class' => 'btn btn-info m-1']) ?>
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
                                        'attribute' => 'schools',
                                        'label' => 'School',
                                        'format' => 'raw',
                                        'contentOptions' => ['style' => 'width:250px;'],    
                                        'value' => function($model){
                                            $isReturn = ""; 
                                            if($model->schools):
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
                                        'attribute' => 'title',
                                        'label' => 'Title',
                                        'format' => 'raw',
                                        'contentOptions' => ['style' => 'width:300px;'],    
                                        'value' => function($model){
                                            $skill = $model->skill_needed;
                                            return $model->title?"<p>{$model->title}</p><p class='-tw-mt-4 tw-bg-red-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-w-fit'>{$skill}</p>":"";

                                        }
                                    ],
                                    [
                                        'attribute' => 'company_str',
                                        'label' => 'Company',
                                        'format' => 'raw',
                                        'contentOptions' => ['style' => 'width:300px;'],    
                                        'value' => function($model){
                                            return $model->company_str?"<p><p class='-tw-mt-4 tw-bg-gray-400 tw-px-3 tw-py-1 tw-rounded-full tw-text-white tw-text-xs tw-w-fit'>{$model->company_str}</p>":"-";

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