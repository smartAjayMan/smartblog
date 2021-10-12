<?php
   include('../connect/db.php');
        $id = "";
        $old_img = "";
        $images = "";
        $errors = array();
 if (isset($_POST['action'])) {
      $id = $_POST['id'];
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
            $newimages = $images;
            $path = "../../images/".$newimages;
          }
       }else {
         echo $errors['images'] = '<li class="alert-message bc-red-alert">Images</li> ';
       }

      if (count($errors) === 0 ) {
        if ($_POST['action'] === 'image-i-edit') {
            $sql = "UPDATE users SET images = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $newimages, $id);
            $result = $stmt->execute();
            if ($result === true) {
               if ($images !== '') {
                   if ($old_img !== '') {
                     move_uploaded_file($img_tmp, $path);
                     unlink('../../images/'.$old_img);
                     echo '<script>window.location.reload(true);</script>';
                   }else {
                     move_uploaded_file($img_tmp, $path);
                     echo '<script>window.location.reload(true);</script>';
                   }
                  session_start();
                  $_SESSION['images'] = $newimages;
                }else {
                    echo $errors = '<li class="alert-message bc-red-alert">No Change</li> ';
                }
            }
   
         }
      }


     if ($_POST['action'] === 'image-i-del') {
            $empty = '';
            $sql = "UPDATE users SET images = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $empty, $id);
            $result = $stmt->execute();
            if ($result === true) {

                if ($old_img !== '') {
                    unlink('../../images/'.$old_img);
                    echo '<script>window.location.reload(true);</script>';
                }else {
                 echo '<li class="alert-message bc-red-alert">Not Image.</li>';
                }
                session_start();
                $_SESSION['images'] = '';
               
            }   
         }
   }

?>