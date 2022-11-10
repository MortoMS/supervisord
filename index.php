<?php

require_once 'vendor/autoload.php';

use DBSeller\Supervisord\Client;
use DBSeller\Supervisord\HTTPConnection;

$connection = new HTTPConnection('localhost', 'ecidade', 'halegria');
$client     = new Client($connection);
