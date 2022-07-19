<?php

namespace app\modules\administrator;

use Yii;

/**
 * Administrator module definition class
 */
class Administrator extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\administrator\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if(!Yii::$app->session->get('id')):
            Yii::$app->session->setFlash('no_school', 'Pilih Basis Sekolah Dulu!');
        else:
            Yii::$app->session->getFlash('no_school');
        endif;


        // custom initialization code goes here
    }
}