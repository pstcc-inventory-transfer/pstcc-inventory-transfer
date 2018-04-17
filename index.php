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
    <link rel="stylesheet" href="style/index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>

    <div class="container-fluid">
    <div class="row">
      <div class="col-sm-8 col-centered" id="login-panel">

          <img src="img_assets/pelli_full.svg"/>
          <h1>Transfer Application</h1>

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

          <form method="post">
            <div class="form-group">
                <div class="input-group">
                    <input class="form-control" name="pwd" id="pwd" placeholder="Please enter technician password" type="password">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                </div>
            </div>
            <button id="button" type="submit" name="submit" class="btn btn-info btn-block">Submit</button>
          </form>

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
