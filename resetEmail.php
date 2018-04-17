<?php
//Author: Zachary Mitchell
//Since the password email hardly requires any information (comapred to email.php for sure!), the email is generated here, then sent off.
function resetEmail($username,$link){
    $emailString = <<<EOD
Pellissippi Inventory, Account Reset:$username.
<body style="color:navy">
       <div style="background-color:navy;border-bottom:3px solid gold;"><img src="https://i.imgur.com/mgdUQ1k.png"/></div>
<p>Hello,<br>you have requested to reset the password for the following user: $username</p>
<p>Please <a href='$link'>Click here</a> to enter a new password.</p>
</body>
EOD;
file_put_contents("./emailClient/reset.html",$emailString);
exec('cd emailClient && cliEmail.exe -html reset.html');
unlink("emailClient/reset.html");
}
?>