<?php

require_once 'vendor/autoload.php';

use DBSeller\Supervisord\Client;
use DBSeller\Supervisord\HTTPConnection;

$connection = new HTTPConnection('localhost', 'admin', 'secret');
$client     = new Client($connection);
$result     = $client->addProcessGroup();

var_dump($result);
