<?php

require_once 'vendor/autoload.php';

use AbismoStudios\Supervisord\Client;
use AbismoStudios\Supervisord\HTTPConnection;

use AbismoStudios\Supervisord\Exceptions\InvalidArgumentException;
use AbismoStudios\Supervisord\Exceptions\ConnectionException;

try {
    $connection = new HTTPConnection('localhost', 'admin', 'secret');
    $client     = new Client($connection);
    $result     = $client->listMethods();
    
    var_dump($result);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
} catch (ConnectionException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
