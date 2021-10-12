<?php include('path.php') ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signup</title>
        <!-- header css -->
        <link rel="stylesheet" href="blog/style/GBody/header_style.css">
        <!-- Gbody css -->
        <link rel="stylesheet" href="blog/style/GBody/mainBody.css">
        <!-- footer css -->
        <link rel="stylesheet" href="blog/style/GBody/footer_style.css">
        <!-- multi color css -->
        <link rel="stylesheet" href="blog/style/GBody/multi-color.css">
    </head>  
    <body class="bc-aquamarine">
    <!-- header start -->   
    <?php include(ROOT_PATH."/blog/include/header.php") ?>
    <!-- Gbody start -->
     <div class="main-container">
        <div class="form-control">             
                <form id="myformSignup" class="flexible coloums bc-white form-c m-b" autocomplete="off">
                    <h2 class="t-c m-b">Signup</h2>
                    <div class="sign-u-img ">
                        <img class="image previewImage" src="images/download.png" >
                    </div>
                    <input type="file" name="images" class="profileImage" id="cha-u-icon" style="display: none;">
                    <div class="message m-t" id="formError">                                          
                    </div>
                    <label for="username" class="form-lable">Username</label>
                    <input class="form-input" type="username" name="username" id="username">
                    <label for="email" class="form-lable">Email</label>
                    <input class="form-input" type="email" name="email" id="email" autocomplete="on">
                    <label for="password" class="form-lable">Password</label>
                    <input class="form-input" type="password" name="password" id="password">
                    <label for="cpassword" class="form-lable">Conform Password</label>
                    <input class="form-input" type="password" name="cpassword" id="cpassword">                   
                    <label for="create-channel" class="form-lable channel-info m-t m-a">
                        <input type="checkbox" name="create-channel" id="create-channel"> Create Channel
                    </label>
                    <label for="channel" class="form-lable m-t">Channel Name</label>
                    <input class="form-input" type="text" name="channel" id="channel">
                    <label for="desc" class="form-lable">Channel Description</label>
                    <textarea class="form-input form-body" name="desc" id="desc" cols="30" rows="0"></textarea>
                    <div class="m-t">
                        <input type="checkbox" id="show-pass"> Show Password
                    </div> 
                    <input type="submit" name="signup-btn" id="signup-btn" value="Submit" class="signup-btn form-lable">           
                </form>
       </div>
    </div>         
    <script src="blog/style/jQuery/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="blog/style/jQuery/All-content.js"></script>
    <script>
       $(document).ready(function () {
         $('#myformSignup').on('submit', function (e) {
             e.preventDefault();
             let formdata = new FormData(this);
             $.ajax({
                 url : "blog/engine/signup.php",
                 method : "POST",
                 data :formdata,
                 contentType :false,
                 processData :false,
                 success : function (data) {
                   $('#formError').html(data);
                 }
             });
           });
       });
    </script>     
  </body>
 </html>            