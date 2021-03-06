<?php
    session_start();
    $_SESSION['auth'] = false;
    $_SESSION['isAdmin'] = false;
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

            $( document ).ready(function()
            {

                $("#pwd").keyup(function(event)
                {
                    if (event.keyCode === 13)
                    {
                        $("#submit").click();
                    }
                });
            });

            function testReset(username)
            {
                $.ajax(
                {
                    method: "POST",
                    url: "phpFunctions.php",
                    data:
                    {
                        user: username
                    }
                }).done(function(results)
                {
                    alertModal('alert', 'Success', 'A reset email has been sent to the application administrator');
                });
            }

            function validatePwd()
            {
                var password = $('#pwd').val();
                var username = $('#user').val();

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
                                    document.location.replace('m.inventory-transfer.php');
                                    }
                                    else {
                                    document.location.replace('inventory-transfer.php');
                                    }
                                }
                                else if(results == 'admin true')
                                {
                                    var isMobile = 
									{
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
                                    document.location.replace('m.inventoryScan.php');
                                    }
                                    else {
                                    document.location.replace('inventoryScan.php');
									}
                                }
                                else
                                {
                                    alertModal('error', 'Error', results + 'Incorrect password');
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
<<<<<<< HEAD
                else
                {
                    alertModal('error', 'Error', 'Please select a user.');
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
                    <div id="div_transfer" class="container-fluid" style="" method="post">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <select class="form-control" id="user" name="user">
                                        <option value="null" selected disabled>Please select user</option>
                                        <option value="admin">Administrator</option>
                                        <option value="tech">Technician</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="pwd" id="pwd" placeholder="Password" type="password">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button id="submit" class="btn btn-info btn-block" style="" onclick="validatePwd();">Submit</button>
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <a id="forgot_password" style="" data-target="#resetModal" data-toggle="modal">Forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="resetModal" class="modal fade" role="dialog" style="">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Password Reset</h4>
                    </div>
                    <div class="modal-body">
                        <h5><b>Select password to be reset:</b></h5>
                        <select class="form-control" id="resetUser" name="resetUser">
                            <option value="admin">Administrator</option>
                            <option value="tech">Technician</option>
                        </select>

                        <h5>Upon confirmation, a reset link will be emailed to the <b>application administrator</b></h5>

                        <br/>

                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="testReset($('#resetUser').val());">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="alertModal" class="modal fade" role="dialog" style="">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header alert-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="alert-modal-title"></h4>
                    </div>
                    <div class="modal-body" style="">
                        <p id="alert-modal-body"></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
