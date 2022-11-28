<?php

require_once 'vendor/autoload.php';

use AbismoStudios\Supervisord\Client;
use AbismoStudios\Supervisord\HTTPConnection;

$connection = new HTTPConnection('localhost', 'admin', 'secret');
$client     = new Client($connection);
$result     = $client->addProcessGroup();

var_dump($result);
