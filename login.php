<?php include('path.php') ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
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
                <form id="myformLogin" class="flexible coloums bc-white form-c" autocomplete="off">
                    <h2 class="t-c">Login</h2>
                    <div class="message" id="formErrors">
                      
                    </div>
                    <label for="email" class="form-lable">Email</label>
                    <input class="form-input" name="email" type="email" id="email" autocomplete="on">
                    <label for="password" class="form-lable">Password</label>
                    <input class="form-input" name="password" type="password" id="password" > 
                    <div class="m-t">
                        <input type="checkbox" id="show-pass"> Show Password
                    </div> 
                    <button type="submit" class="signup-btn form-lable">Submit</button>              
                </form>
       </div>
    </div>        
    <script src="blog/style/jQuery/jquery-3.6.0.min.js"></script>
    <script src="blog/style/jQuery/All-content.js"></script>
    <script>
      $(document).ready(function () {
         $('#myformLogin').on('submit',function (e) {
             e.preventDefault();
             let formdata = new FormData(this);
             $.ajax({
                  url : "blog/engine/login.php",
                  method : "POST",
                  data : formdata,
                  contentType : false,
                  processData : false,
                  success : function (data) {
                      $('#formErrors').html(data);
                  }
             });
         });
      });
    </script>
  </body>
 </html>   