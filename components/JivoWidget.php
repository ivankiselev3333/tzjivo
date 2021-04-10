<?php

namespace app\components;

use app\models\UsersIntegrationsJivositeApi;
use Yii;
use yii\app;
use yii\base\Widget;

class JivoWidget extends Widget
{
    public $user_id;
    public $email;
    public $code;

    public function init()
    {
        parent::init();

        $this->code = '<script src="//code.jivosite.com/widget/dyQzo0d4Ss" async></script>';

    }

    public function run()
    {




        $UsersIntegrationsJivositeApi = UsersIntegrationsJivositeApi::findByUserId($this->user_id);

        return $UsersIntegrationsJivositeApi['js'];
    }
}