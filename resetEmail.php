<?php
//Author: Zachary Mitchell
//Since the password email hardly requires any information (comapred to email.php for sure!), the email is generated here, then sent off.
function resetEmail($username,$link)
{
    $emailString = <<<EOD
Pellissippi Inventory, Account Reset:$username.
<body style="color: black;">
       <div style="background-color:#0066cc;border-bottom:3px solid #fcd955; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;"><img style="margin: 10px 0px 10px 1%;" src="https://i.imgur.com/mgdUQ1k.png"/></div>
<p>Hello,</p> <p style="margin-left: 2%;">You have requested to reset the password for the following user: $username</p>
<p style="margin-left: 2%;">Please <a href='$link'>Click here</a> to enter a new password.</p>
</body>
EOD;
file_put_contents("./emailClient/reset.html",$emailString);
exec('cd emailClient && cliEmail.exe -html reset.html');
unlink("emailClient/reset.html");
}
?>
