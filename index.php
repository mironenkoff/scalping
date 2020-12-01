<?php

require_once 'php/config.php';
//var_dump($dsn);
//var_dump($user);
//var_dump($password);

require_once 'php/model.php';
require_once 'php/controller.php';

$db = dbConnect( $dsn, $user, $password );
//var_dump( $db );

session_start();
//session_destroy();

if ( !$_SESSION[ 'cart' ] ) {
    $_SESSION[ 'cart' ] = [];
}

doFeedbackAction($db);