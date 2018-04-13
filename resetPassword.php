<?php
    include 'db_connection.php';
    date_default_timezone_set('UTC');
?>

<!doctype html>
<html>
    <head>
        <title>PSTCC Transfer</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <style>
            html {
            height: 100%;
            width: 100%;
            }
            body
            {
            background: radial-gradient(rgb(255, 210, 79), rgb(0, 75, 141));
            background-size: cover;
            color: white;
            display: flex;
            width: 100%;
            }

            .container-fluid {
            width: 100%;
            }
            .vertical-center {
            min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
            min-height: 100vh; /* These two lines are counted as one :-)       */
            display: flex;
            align-items: center;
            }
            .col-centered
            {
            margin: 0 auto;
            float: none;
            }
            
            .modal-header
            {
                padding:9px 15px;
                border-bottom:1px solid #eee;
                -webkit-border-top-left-radius: 5px;
                -webkit-border-top-right-radius: 5px;
                -moz-border-radius-topleft: 5px;
                -moz-border-radius-topright: 5px;
                 border-top-left-radius: 5px;
                 border-top-right-radius: 5px;
             }
            
            .alert-header
            {
                color: white;
                background-color: #ff4444;
            }
            
            #alertModal > *
            {
                width: 400px;
                margin: auto;
                margin-top: 30px;
            }
            
            #login-panel
            {
            margin: 0 auto;
            text-align: center;
            background-color: #0066cc;
            padding: 10px 60px 20px 60px;
            border-radius: 20px;
            border: 2px solid #fcd955;
            width: 50%;
            }
            @media screen and (max-width: 768px) {
                body {
                text-align: center;
                }
                #login-panel
                {
                    width: 90%;
                }
            }
        </style>
        
        <script>
            function alertModal(style, title, body)
            {
                $('#alert-modal-title').text(title);
                $('#alert-modal-body').text(body);
                
                if(style == "error")
                {
                    $('.alert-header').css('background-color', '#ff4444');
                }
                else if (style == "alert")
                {
                    $('.alert-header').css('background-color', '#33b5e5');
                }
                
                $('#alertModal').modal('show');
            }
            
            $( document ).ready(function() {
            
                $("#newPwd").keyup(function(event) {
                    if (event.keyCode === 13) 
                    {
                        $("#submit").click();
                    }
                });
            });
            
            function updatePwd(username, password)
            {
                if(password !== "")
                {
                    if(!password.includes(' '))
                    {
                        $.ajax(
                            {
                                method: "POST",
                                url: "phpFunctions.php",
                                data:
                                {
                                    user: username,
                                    newPwd: password
                                }
                            }).done(function(results)
                            {
                                if(results.trim() == "true")
                                {
                                    alertModal('alert', 'Success', 'Password successfully changed!');
                                    
                                    setTimeout(function(){window.location.replace('index.php');}, 2000);
                                }
                                else
                                {
                                    alertModal('error', 'Error', results);
                                }
                            });
                    }
                    else
                    {
                        alertModal('error', 'Error', 'Password cannot include spaces.');
                    }
                }
                else
                {
                    alertModal('error', 'Error', 'Password cannot be blank.');
                }
            }
        </script>
    </head>
    <body>
<?php

    if(isset($_GET['q1']) && isset($_GET['q2']))
    {
        $pwdDateHash = urldecode($_GET['q1']);
        $user = $_GET['q2'];
        
        $today = date('m-d');
        
        $query = "SELECT password FROM tblUsers WHERE userName = '".($user == 'admin'?'Administrator':'Technician')."'";
        $result = queryDB(connectToDB(), $query);
        $pwdDB = trim($result[0]['password']);

        if(exec('.\verification\scramblerVerify.exe -d "'.$pwdDB.$today.'" "'.$pwdDateHash.'"') == 'True')
        {
            ?>
                <div class="container-fluid">
                    <div class="row vertical-center">
                        <div class="col-sm-8 col-centered" id="login-panel">
                            <h1>Password Reset</h1>
                            <hr/>
                            <div class="container-fluid" style="margin: 0; padding: 0;" method="post">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group" style="text-align: left; width: 100%;">
                                            <h5><b>New Password:</b></h5>
                                            <input class="form-control" type="password" id="newPwd" name="newPwd">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <button id="submit" type="submit" class="btn btn-info btn-block" style="margin-top: 15px;" onclick="updatePwd( '<?php echo $user; ?>', $('#newPwd').val());">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
        }
        else
        {
            echo "It doesn't appear this link is valid. Please ensure you've receieved this email today.";
            //echo "<br>\"".exec('.\verification\scramblerVerify.exe -e "'.$pwdDB.$today.'"')."\"<br>\"".$pwdDateHash.'"<br>'.exec('.\verification\scramblerVerify.exe -d "'.$pwdDB.$today.'" "z?£DOgOb¿r¿`U9nc|aillk¢cSdueh`[r~b{"').'<br>'.$today;
            //exec('echo "'.$pwdDateHash.'" > .\verification\test.txt');
        }
    }
    else
    {
        header('Location: index.php');
    }
?>
        
        <div id="alertModal" class="modal fade" role="dialog" style="color: black; text-align: left;">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header alert-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="alert-modal-title"></h4>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                        <p id="alert-modal-body"></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>