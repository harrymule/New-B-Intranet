<?php session_start();
require_once 'config.ini';
require_once 'database.php';
require_once 'general.php';
require_once 'upload.php';
//require_once 'upload_public.php';
require_once 'communication.php';

function a($index,$value){	return isset($_REQUEST[$index]) && ($_REQUEST[$index] == $value) ? 'active' : NULL;}
function d($index){	return !isset($_REQUEST[$index]) ? 'active' : NULL;}
