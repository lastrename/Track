<?php

namespace app\modules\api;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\api\controllers';

    public function init()
    {
        parent::init();

        // Настройки модуля
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;

        // Регистрация компонентов модуля
        $this->registerComponents();
    }

    protected function registerComponents()
    {
        // Можно зарегистрировать специфичные для API компоненты
    }
}