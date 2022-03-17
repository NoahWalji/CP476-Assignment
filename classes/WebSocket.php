<?php
set_time_limit(0);
require dirname(__DIR__) . '/vendor/autoload.php';
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;


class Messages implements MessageComponentInterface {
    protected $clients;
    public function __construct()
        {
            $this->clients=new \SplObjectStorage;
        }

    public function onOpen(ConnectionInterface $conn)
        {
            $this->clients->attach($conn);
        }

    public function onClose(ConnectionInterface $conn)
        {
            $this->clients->detach($conn);
        }

    public function onMessage(ConnectionInterface $conn,$msg)
        {
            foreach($this->clients as $client){
                if($client !==$conn){
                    $client->send(json_encode($msg));
                }
            }
        }

    public function onError(ConnectionInterface $conn, \Exception $e)
        {
             $conn->close();
        }

}

$server = IoServer::factory(new HttpServer(new WsServer(new Messages()),8080));
$server->run();


?>