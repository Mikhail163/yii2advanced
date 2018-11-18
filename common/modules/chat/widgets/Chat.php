<?php
namespace common\modules\chat\widgets;

use common\modules\chat\assets\ChatAsset;
use Yii;

class Chat extends \yii\bootstrap\Widget
{
    public function run()
    {
        //$this->view->registerJsFile('/js/chat.js');
        ChatAsset::register($this->view);
        return $this->render('chat');
    }
}
