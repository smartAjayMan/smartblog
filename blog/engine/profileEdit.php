<?php
     
     include('../connect/db.php');
     $id = "";
     $channel = "";
     $desc = "";
     $images = "";
     $old_img = "";
     $errors = array();
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id = $_POST['id'];
      $channel = $_POST['channel'];
      $desc = $_POST['desc'];
      $old_img = $_POST['old_image'];
      $images = $_FILES['images']['name'];
      $img_tmp = $_FILES['images']['tmp_name'];


      $allow_image = array('gif','png','PNG', 'jpg','jpeg', '');
      $filename_axention = pathinfo($images, PATHINFO_EXTENSION);
      if (in_array($filename_axention, $allow_image)) {
          if (!empty($images)) {
            $newimages = rand().'.'.$filename_axention;
            $path = "../../images/".$newimages;
          }else {
            $newimages = $old_img;
          }
       }else {
         echo $errors['images'] = '<li class="alert-message bc-red-alert">Allowed PNG, JPG, GIF</li> ';
       }


     if (empty($channel)) {
        echo $errors['channel'] = '<li class="alert-message bc-red-alert">Enter The Channel Name</li>';
      }
      
      if (empty($desc)) {
        echo $errors['desc'] = '<li class="alert-message bc-red-alert">Enter The Description</li>';
      }

      if (count($errors) === 0) {
         $sql = "UPDATE users SET images=?, channel_name=?, description=? WHERE id=?";
         $stmt = $conn->prepare($sql);
         $stmt->bind_param('sssi', $newimages, $channel, $desc, $id);
         $result = $stmt->execute();
         if ($result === true) {           
            if ($images !== '') {
                if ($old_img !== '') {
                  move_uploaded_file($img_tmp, $path);
                  unlink('../../images/'.$old_img); // old images delete function
                }else {
                  move_uploaded_file($img_tmp, $path);
                }
             }
        echo '<script> window.location.href="http://localhost/smartblog/blog/engine/logout.php";</script>';
         }
      }

  }

?>