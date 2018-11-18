<?php
namespace common\modules\chat\controllers;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

use common\modules\chat\components\Chat;
use yii\console\Controller;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                    )
                ),
            8080
            );
        
        echo 'start';
        $server->run();
        echo 'end';
    }
}
