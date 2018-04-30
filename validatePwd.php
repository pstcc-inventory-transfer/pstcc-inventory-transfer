<?php
include 'db_connection.php';
session_start();
$query = "SELECT password FROM tblUsers WHERE userName = '".($_POST['user'] == 'admin'?'Administrator':'Technician')."'";
$result = queryDB(connectToDB(), $query);

//As of this writing, we only have two users; You can take down this conditional if it's the future and we have multiple users now :P
if($_POST['user'] == 'admin')
{
    $pwd = $_POST['pwd'];
    
    if(exec('.\verification\scramblerVerify.exe -d '.$pwd.' "'.trim($result[0]['password']).'"') == "True")
    {
        $_SESSION['auth'] = true;
        $_SESSION['isAdmin'] = true;
        echo "admin true";
    }
}
else if($_POST['user'] == 'tech')
{
    $pwd = $_POST['pwd'];
    
    if(exec('.\verification\scramblerVerify.exe -d '.$pwd.' "'.trim($result[0]['password']).'"') == "True")
    {
        $_SESSION['auth'] = true;
        echo "tech true";
    }
}