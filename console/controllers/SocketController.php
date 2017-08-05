<?php
namespace console\controllers;

use Yii;
use yii\console\Exception;
use yii\console\Controller;
use alkurn\websocket\WebSocket;

/*php yii socket/start*/
class SocketController extends Controller
{
    public function actionStart()
    {
        $webSocket = new WebSocket();
        $webSocket->createSocket();
    }
}
