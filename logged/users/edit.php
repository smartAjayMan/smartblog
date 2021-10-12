<?php include('../../path.php') ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editing</title>
        <!-- header css -->
        <link rel="stylesheet" href="../../blog/style/GBody/header_style.css">
        <!-- Gbody css -->
        <link rel="stylesheet" href="../../blog/style/GBody/mainBody.css">
        <!-- footer css -->
        <link rel="stylesheet" href="../../blog/style/GBody/footer_style.css">
        <!-- multi color css -->
        <link rel="stylesheet" href="../../blog/style/GBody/multi-color.css">
    </head>  
    <body class="bc-aquamarine">
    <!-- header start -->   
    <?php include(ROOT_PATH.'/blog/include/header.php') ?>
    <!-- Gbody start -->
     <div class="main-container">
        <div class="form-control"> 
           <?php  if (isset($_SESSION['logining']) && $_SESSION['logining'] === true): ?>                        
                <form id="profileEdit" class="flexible coloums bc-white form-c" autocomplete="off">
                    <h2 class="t-c m-b">Editor</h2>
                    <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['id']; ?>">
                    <div class="sign-u-img ">
                      <?php if (!empty($_SESSION['images'])): ?>
                         <img class="image previewImage" src="<?php echo (BASE_URL.'/images/'.$_SESSION['images']); ?>" >
                      <?php else: ?>
                        <img class="image previewImage" src="<?php echo (BASE_URL.'/images/userIcon.png'); ?>" >
                      <?php endif; ?>
                    </div>
                    <input type="file" name="images" class="profileImage" id="cha-u-icon" style="display: none;">
                    <input type="hidden" name="old_image" class="profileImage" value="<?php echo $_SESSION['images']; ?>" id="old-u-icon" style="display: none;">
                    <div class="message m-t" id="formErrors">                       
                    </div>
                    <?php if (isset($_SESSION['channel'])): ?>
                        <label for="channel" class="form-lable m-t">Channel Name</label>
                        <input class="form-input" type="text" name="channel" value="<?php echo $_SESSION['channel'] ?>" id="channel">
                        <label for="desc" class="form-lable">Channel Description</label>
                        <textarea class="form-input form-body" name="desc" id="desc" cols="30" rows="0"><?php echo $_SESSION['desc']; ?></textarea>
                    <?php else: ?>
                        <label for="channel" class="form-lable m-t m-a">Channel create</label>
                        <label for="channel" class="form-lable m-t">Channel Name</label>
                        <input class="form-input" type="text" name="channel"  id="channel">
                        <label for="desc" class="form-lable">Channel Description</label>
                        <textarea class="form-input form-body" name="desc" id="desc" cols="30" rows="0"></textarea>
                    <?php endif; ?>
                    <button type="submit" class="signup-btn form-lable">Save</button>              
                </form>
           <?php else: ?>
                <div  class="flexible coloums bc-white form-c m-b" style="margin-top: 20%;">
                    <h2 class="t-c m-b">Login Please...</h2>                                
                </div>
           <?php endif; ?>
       </div>
    </div>         
    <script src="../../blog/style/jQuery/jquery-3.6.0.min.js"></script>
    <script src="../../blog/style/jQuery/All-content.js"></script>
    <script>
       $(document).ready(function () {
          $('#profileEdit').on('submit', function (e) {
              e.preventDefault();
              let formdata = new FormData(this);
              $.ajax({
                  url : "../../blog/engine/profileEdit.php",
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