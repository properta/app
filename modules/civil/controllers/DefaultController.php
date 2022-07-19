<?php

namespace app\modules\civil\controllers;

use yii\web\Controller;

/**
 * Default controller for the `civil` module
 */
class DefaultController extends Controller
{
    public $layout = '@app/views/layouts/civil';
    public $title = "HELLO";
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}