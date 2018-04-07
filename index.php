<?php
    session_start();
    $_SESSION['auth'] = false;
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
            a
            {
            cursor: pointer;
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
            form
            {
            margin-top: 20px;
            }
            .col-centered
            {
            margin: 0 auto;
            float: none;
            }
            #login-panel
            {
            margin: 0 auto;
            text-align: center;
            background-color: #0066cc;
            padding: 10px 60px 20px 60px;
            border-radius: 30px;
            border: 2px solid #fcd955;
            width: 50%;
            }
            @media screen and (max-width: 768px) {
            /*[class*="col-"] {
            width: 75%;
            }*/
            body {
            text-align: center;
            }
            #login-panel
            {
            margin: 0 auto;
            text-align: center;
            background-color: #0066cc;
            padding: 10px 30px 20px 30px;
            border-radius: 20px 20px 20px 20px;
            border: 2px solid #fcd955;
            width: 90%;
            height: 75%;
            display: block;
            float: none;
            }
            h2 {
            font-size: 20px;
            }
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row vertical-center">
                <div class="col-sm-8 col-centered" id="login-panel">
                    <img src="img_assets/pelli_full.svg"/>
                    <h1>Transfer Application</h1>
                    <hr/>
                    <?php
                        if (isset($_POST["submit"]))
                        {
                          //Due to the password being passed as an excutable argument, it needs to be checked for spaces so nothing can go haywire on the other side:
                          $passHasSpaces = false;
                          for($i=0;$i<strlen($_POST['pwd']);$i++){
                            if($_POST['pwd'][$i] == ' '){
                              $passHasSpaces = true;
                              break;
                            }
                          }
                            if($_POST["pwd"] == '')
                            {
                                $_SESSION['auth'] = false;
                                echo "<script>alert('Password cannot be blank.');</script>";
                            }
                            else if ($passHasSpaces){
                              $_SESSION['auth'] = false;
                              echo "<script>alert('Password cannot contain spaces.');</script>";
                            }
                            else if(exec('cd verification && scramblerVerify.exe '.$_POST["pwd"].' -f nothingInteresting.txt') == 'True')
                            {
                                $_SESSION['auth'] = true;
                            }
                            else
                            {
                                $_SESSION['auth'] = false;
                                echo "<script>alert('Password incorrect.');</script>";
                            }
                        }
                        ?>
                    <form class="form container-fluid" style="margin: 0; padding: 0;" method="post">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group" style="text-align: left; width: 100%;">
                                    <!--<h4>User Account</h4>-->
                                    <select class="form-control" style="width: 100%;" id="user" name="user">
                                        <option value="null" selected disabled>Please select user</option>
                                        <option value="admin">Administrator</option>
                                        <option value="tech">Technician</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group" style="text-align:left; width: 100%;">
                                    <!--<h4>Password</h4>-->
                                    <div class="input-group" style="width: 100%;">
                                        <input class="form-control" style="width: 100%" name="pwd" id="pwd" placeholder="Password" type="password">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12"><button type="submit" name="submit" class="btn btn-info btn-block" style="margin-top: 15px;">Submit</button></div>
                        </div>
                        <br/>
                        <br/>
                        <a style="color: white; margin-top: 10px;" data-target="#resetModal" data-toggle="modal">Forgot your password?</a>
                    </form>
                </div>
            </div>
        </div>
        <div id="resetModal" class="modal fade" role="dialog" style="color: black;">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Password Reset</h4>
                    </div>
                    <div class="modal-body" style="text-align: center">
                        <h5>Upon confirmation, a reset link will be sent to <b>[insert email here].</b></h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
if($_SESSION['auth'] == true)
{
  $script = <<<EOT
  <script>
  var isMobile = {
  Android: function() {
    return navigator.userAgent.match(/Android/i);
  },
  BlackBerry: function() {
    return navigator.userAgent.match(/BlackBerry/i);
  },
  iOS: function() {
    return navigator.userAgent.match(/iPhone|iPad|iPod/i);
  },
  Opera: function() {
    return navigator.userAgent.match(/Opera Mini/i);
  },
  Windows: function() {
    return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
  },
  any: function() {
    return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
  }
  };
  if (isMobile.any()) {
    document.location.replace('mobile.php');
  }
  else {
    document.location.replace('desktop.php');
  }
  </script>
  </body>
  </html>
EOT;
    echo $script;
}
            ?>
    </body>
</html>