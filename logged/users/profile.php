<?php include('../../path.php'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>
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
                <form id="profileImg" class="flexible coloums bc-white form-c m-b">
                    <h2 class="t-c m-b">Profile</h2>     
                    <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['id']; ?>"> 
                    <div class="sign-u-img">
                      <?php if (!empty($_SESSION['images'])): ?>
                        <img class="image previewImage" src="../../images/<?php echo $_SESSION['images']; ?>">
                      <?php else: ?>
                         <img class="image previewImage" src="../../images/userIcon.png">
                      <?php endif; ?>
                    </div>                    
                    <input type="file" name="images" class="profileImage" id="cha-u-icon" style="display: none;">
                    <input type="hidden" name="old_image" class="profileImage" value="<?php echo $_SESSION['images']; ?>" id="old-u-icon" style="display: none;">
                    <div class="message m-t m-a" id="formErrors" style="width: 24%;">                       
                    </div>
                    <div class="flexible m-a m-b">
                        <input type="submit" name="image-i-edit" id="image-i-edit" value="Save" class="signup-btn contr form-lable m-r">  
                        <input type="submit" name="image-i-del" id="image-i-del" value="Remove" class="signup-btn contr form-lable bc-red">  
                    </div>
                    <label for="username" class="form-lable t-c">Username</label>
                    <p class="form-lable t-c" style="text-transform: capitalize;"><b> <?php echo $_SESSION['username']; ?> </b> </p>
                    <label for="email" class="form-lable m-t t-c">Email</label>
                    <p class="form-lable t-c"><b><?php echo $_SESSION['email']; ?></b></p>
                    <label for="password" class="form-lable m-t t-c">Password</label>
                    <p class="form-lable t-c"><b>...........</b></p>
                    <?php if (!empty($_SESSION['channel'])):?>
                    <label for="channel" class="form-lable m-t t-c">Channel Name</label>
                    <p class="form-lable t-c"> <b style="text-transform: capitalize;"> <?php echo $_SESSION['channel']; ?> </b></p>
                    <label for="desc" class="form-lable m-t t-c">Channel Description</label>
                    <p class="form-lable t-c"> <b class="profile-u-body"><?php echo $_SESSION['desc']; ?></b></p> 
                    <?php endif; ?>          
                    <a href="edit.php" class="form-lable t-c m-b m-t"><b class="profile-u-body cr-green"> Edit </b></a>           
                    <a href="../../blog/engine/logout.php" class="form-lable t-c m-b"> <b class="profile-u-body cr-red"> LogOut </b></a>           
                </form>
            <?php else: ?>
                <div  class="flexible coloums bc-white form-c m-b" style="margin-top: 20%;"> <h2 class="t-c m-b">Login Please...</h2>  </div>
            <?php endif; ?>
       </div>
    </div>         
    <script src="../../blog/style/jQuery/jquery-3.6.0.min.js"></script>
    <script src="../../blog/style/jQuery/All-content.js"></script>
    <script>
      $(document).ready(function () {
         $('.contr').click(function (e) {
             e.preventDefault();
            if (confirm('Are You Sure Changes.')) {
                let edit = $(this).attr('name');
                let form =  $('#profileImg')[0];
                let formdata = new FormData(form);
                formdata.append('action', edit);
                $.ajax({
                    url : "../../blog/engine/profileImgEdit.php",
                    method : 'POST',
                    data : formdata,
                    processData : false,
                    contentType : false,
                    success : function (data) {
                    $('#formErrors').html(data);
                    }
                });
            }
         });
      });
    </script>
  </body>
 </html>
               