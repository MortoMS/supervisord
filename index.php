<?php

require_once 'vendor/autoload.php';

use AbismoStudios\Supervisord\Client;
use AbismoStudios\Supervisord\HTTPConnection;

try {
    $connection = new HTTPConnection('localhost', 'admin', 'secret');
    $client     = new Client($connection);
    $result     = $client->startProcess();
    
    var_dump($result);
} catch (Exception $e) {
    var_dump($e->faultString);
}
