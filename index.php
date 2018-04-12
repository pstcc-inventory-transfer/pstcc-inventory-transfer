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
            
            .reset-header
            {
                color: white;
                background-color: #33b5e5;
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
            border-radius: 30px;
            border: 2px solid #fcd955;
            width: 50%;
            }
            @media screen and (max-width: 768px) {
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
        
        <script>
            function alertModal(title, body)
            {
                $('#alert-modal-title').text(title);
                $('#alert-modal-body').text(body);
                
                $('#alertModal').modal('show');
            }
            
            function validatePwd()
            {
                var password = $('#pwd').val();
                var username = $('#user').val();
                console.log(username);
                if(username != null)
                {
                    if(password !== '')
                    {
                        if(!password.includes(' '))
                        {
                            $.ajax(
                            {
                                method: "POST",
                                url: "validatePwd.php",
                                data:
                                {
                                    user: username,
                                    pwd: password
                                }
                            }).done(function(results)
                            {
                                if(results == 'tech true')
                                {
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
                                }
                                else if(results == 'admin true')
                                {
                                    window.location.href = 'inventoryScan.php';
                                }
                                else
                                {
                                    alertModal('Error', results + 'Incorrect password');
                                }
                            });
                        }
                        else
                        {
                            alertModal('Error', 'Password cannot include spaces.');
                        }
                    }
                    else
                    {
                        alertModal('Error', 'Password cannot be blank.');
                    }
                }
                else
                {
                    alertModal('Error', 'Please select a user.');
                }
            }
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row vertical-center">
                <div class="col-sm-8 col-centered" id="login-panel">
                    <img src="img_assets/pelli_full.svg"/>
                    <h1>Transfer Application</h1>
                    <hr/>
                    <div class="container-fluid" style="margin: 0; padding: 0;" method="post">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group" style="text-align: left; width: 100%;">
                                    <select class="form-control" style="width: 100%;" id="user" name="user">
                                        <option value="null" selected disabled>Please select user</option>
                                        <option value="admin">Administrator</option>
                                        <option value="tech">Technician</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group" style="text-align:left; width: 100%;">
                                    <div class="input-group" style="width: 100%;">
                                        <input class="form-control" style="width: 100%" name="pwd" id="pwd" placeholder="Password" type="password">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button name="submit" class="btn btn-info btn-block" style="margin-top: 15px;" onclick="validatePwd();">Submit</button>
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <a style="color: white; margin-top: 10px;" data-target="#resetModal" data-toggle="modal">Forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="resetModal" class="modal fade" role="dialog" style="color: black;">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header reset-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Password Reset</h4>
                    </div>
                    <div class="modal-body" style="text-align: right">
                        <h5 style="text-align: left;">Upon confirmation, a reset link will be sent to <b>[insert email here].</b></h5>
                        <br/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success"  data-dismiss="modal">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
        
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