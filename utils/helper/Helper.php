<?php

namespace app\utils\helper;

use Yii;
use app\models\mains\{
    generals\Projects,
};

class Helper
{
    public $activeProject;

    function __construct()
    {
        $this->activeProject = $this->activeProject();
    }

    static function in_arrays($needles = [], $haystack = []): bool
    {
        if ($needles && $haystack) :
            $status = false;
            foreach ($needles as $key => $value) :
                if (in_array($value, $haystack)) :
                    $status = true;
                    break;
                endif;
            endforeach;
            return $status;
        endif;
        return false;
    }

    static function userLevel()
    {
        $levels = [];
        $class = [];
        $status = false;
        switch (Yii::$app->user->identity->role ?? ""):
            case "superuser";
                $levels[] = "superuser";
                $class[] = NULL;
                $status = true;
                break;
            case "":
                $levels[] = "mentor";
                $class[] = NULL;
                $status = true;
                break;
            default:
                $levels[] = NULL;
                $class[] = NULL;
                $status = false;
                break;
        endswitch;
        if ($status) :
            $session = Yii::$app->session;
            $session->set('user_grant', ['levels' => $levels, 'class' => $class]);
            return true;
        else :
            $urlNotAllowed = Yii::$app->homeUrl . 'not-allowed';
            header("location: $urlNotAllowed");
            die();
        endif;
    }

    static function isJson($str): bool
    {
        $json = json_decode((string)$str);
        return $json && $str != $json;
    }

    static function getMonthList($month = null)
    {
        $monthList = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
        if ($month) :
            return $monthList[$month];
        else :
            return $monthList;
        endif;
    }

    public function generateCode($length = 6, $model, $field)
    {
        $code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 10, $length);
        $model = $model::findOne([$field => $code]);
        if (!$model) :
            return $code;
        else :
            return $this->generateCode($length, $model, $field);
        endif;
    }

    public function setProject($id, $text)
    {
        try {
            $session = Yii::$app->session;
            $session->remove('id');
            $session->remove('text');
            $session->set('id', $id);
            $session->set('text', $text);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function activeProject($all = false)
    {
        if ($id = Yii::$app->session->get('id')) :
            $model = Projects::findOne($id);
            if ($model) :
                if ($all) :
                    return $model;
                endif;
                return $model->id;
            endif;
        endif;
        return false;
    }
}