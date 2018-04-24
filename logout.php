<?php

$_SESSION['auth'] = false;
$_SESSION['isAdmin']=false;

header('Location: index.php');
die();