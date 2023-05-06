<?php

use App\Helpers\Session;

$session = new Session();
$session->delete('userId');
header("Location: /login");