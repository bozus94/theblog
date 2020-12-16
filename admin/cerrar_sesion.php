<?php
session_start();
var_dump($_SESSION);
session_destroy();
$_SESSION = [];
header('Location: ../index.php');
