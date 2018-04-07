<?php
session_start();

if(exec('cd verification && scramblerVerify.exe '.$_POST["pwd"].' -f nothingInteresting.txt') == 'True')
{
    $_SESSION['auth'] = true;
    echo 'true';
}
else
{
    $_SESSION['auth'] = false;
    echo 'false';
}