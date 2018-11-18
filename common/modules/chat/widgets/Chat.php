<?php
namespace common\modules\chat\widgets;

use common\modules\chat\assets\ChatAsset;
use Yii;

class Chat extends \yii\bootstrap\Widget
{
    public $port = 8080;
    public $host = 'www.server.lan';
    
    public function run()
    {
        $this->view->registerJsVar('wsChatPort', $this->port);
        $this->view->registerJsVar('wsChatHost', $this->host);
        ChatAsset::register($this->view);
        return $this->render('chat');
    }
}
