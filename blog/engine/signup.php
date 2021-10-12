<?php
    include("../connect/db.php");
    $username = "";
    $email = "";
    $password = "";
    $cpassword = "";
    $channel = "";
    $desc = "";
    $errors = array();
 if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $channel = $_POST['channel'];
        $desc = $_POST['desc'];

        $images = $_FILES['images']['name'];
        $img_tmp = $_FILES['images']['tmp_name'];

        if (empty($username)) {
            echo $errors['username'] = '<li class="alert-message bc-red-alert">Enter The Username</li> ';
        }

        if (empty($email)) {
            echo $errors['email'] = '<li class="alert-message bc-red-alert">Enter The Email</li> ';
        }
        
        if (empty($password)) {
            echo $errors['password'] = '<li class="alert-message bc-red-alert">Enter The Password</li> ';
        }

        if ($password !== $cpassword) {
            echo $errors['password'] = '<li class="alert-message bc-red-alert">Two Password Not Match</li> ';
        }

        $allow_image = array('gif','png','PNG', 'jpg','jpeg', '');
        $filename_axention = pathinfo($images, PATHINFO_EXTENSION);
        if (in_array($filename_axention, $allow_image)) {
            if (!empty($images)) {
              $newimages = rand().'.'.$filename_axention;
              $path = "../../images/".$newimages;
            }else {
              $newimages = $images;
              $path = "../../images/".$newimages;
            }
         }else {
           echo $errors['images'] = '<li class="alert-message bc-red-alert">Allowed PNG, JPG, GIF</li> ';
         }


         $exists = "SELECT * FROM users WHERE email= ? LIMIT 1";
         $stmt = $conn->prepare($exists);
         $stmt->bind_param('s', $email);
         $stmt->execute();
         $result = $stmt->get_result();
         if (mysqli_num_rows($result)>0) {
          echo $errors['email'] = '<li class="alert-message bc-red-alert">Email Already Exists</li> ';
         }
    
        if (isset($_POST['create-channel'])) {
            if (empty($channel)) {
              echo $errors['channel'] = '<li class="alert-message bc-red-alert">Enter The Channel Name</li> ';
            }
            
            if (empty($desc)) {
              echo $errors['desc'] = '<li class="alert-message bc-red-alert">Enter The Description</li> ';
            }

            if (count($errors) === 0) {
               $pass = password_hash($password, PASSWORD_DEFAULT);
               $sql = "INSERT INTO users SET images=?,username=?, email=?, password=?, channel_name=?, description=?";
               $stmt = $conn->prepare($sql);
               $stmt->bind_param('ssssss', $newimages, $username, $email, $pass, $channel, $desc); //s= string value
               $result = $stmt->execute();
               if ($result === true) {
                  move_uploaded_file($img_tmp, $path);
                  session_start();
                  $id = $conn->insert_id;
                  $_SESSION['logining'] = true;
                  $_SESSION['id'] = $id;
                  $_SESSION['images'] = $newimages;
                  $_SESSION['username'] = $username;
                  $_SESSION['email'] = $email;
                  $_SESSION['channel'] = $channel;
                  $_SESSION['desc'] = $desc;
                  echo '<script> window.location.href="http://localhost/smartblog/index.php";</script>';
               }
            }
        }else {
          if (count($errors) === 0) {
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users SET images=?,username=?, email=?, password=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssss', $newimages, $username, $email, $pass); //s= string value
            $result = $stmt->execute();
            if ($result === true) {
               move_uploaded_file($img_tmp, $path);
               session_start();
               $id = $conn->insert_id;
               $_SESSION['logining'] = true;
               $_SESSION['id'] = $id;
               $_SESSION['images'] = $newimages;
               $_SESSION['username'] = $username;
               $_SESSION['email'] = $email;
               echo '<script> window.location.href="http://localhost/smartblog/index.php";</script>';
            }
         }
     }
 }

?>