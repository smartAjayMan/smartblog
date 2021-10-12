<?php 
       include("../blog/connect/db.php");
      
       $id = "";
       $title = "";
       $topics = "";
       $body = "";
       $published = "";
       $images = "";
       $postsId = "";
       $errors = array();

      // posts creting code
      if (isset($_POST['postsCreate'])) {
          $id = $_POST['id'];
          $title = htmlentities($_POST['title']);
          $topics = $_POST['topics'];
          $published = isset($_POST['published']) ? 1 : 0;
          $body = $_POST['body'];
          $body = preg_replace("#\[sp\]#", "&nbsp", $body);
          $body = preg_replace("#\[nl\]#", "<br>\n", $body);
          $body = htmlentities($body);
          $images = $_FILES['images']['name'];
          $img_tmp = $_FILES['images']['tmp_name'];

          if (empty($title)) {
            echo $errors['title'] = '<li class="alert-message bc-red-alert"> Enter The Title.</li>';
          }
          if (empty($topics)) {
            echo $errors['topics'] = '<li class="alert-message bc-red-alert"> Choose the Topics.</li>';
          }
          
          if (empty($body)) {
            echo $errors['body'] = '<li class="alert-message bc-red-alert"> Enter The Body.</li>';
          }
          
          $sql = "SELECT * FROM posts WHERE  body = ? OR images = ? LIMIT 1";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('ss', $body, $images);
          $stmt->execute();
          $result = $stmt->get_result();
          if (mysqli_num_rows($result)>0) {
              echo $errors['topic'] = '<li class="alert-message bc-red-alert">Already Data Exists.</li>'; 
          }


          $allow_image = array('gif','png','PNG', 'jpg','jpeg', '');
          $filename_axention = pathinfo($images, PATHINFO_EXTENSION);
          if (in_array($filename_axention, $allow_image)) {
              if (!empty($images)) {
                $newimages = rand().'.'.$filename_axention;
                $path = "../images/".$newimages;

              }else {
                echo $errors['images'] = '<li class="alert-message bc-red-alert">Choose The Image</li> ';
                
              }
            }else {
              echo $errors['images'] = '<li class="alert-message bc-red-alert">Allowed PNG, JPG, GIF</li> ';
            }


          if (count($errors) === 0) {
              $sql = "INSERT INTO posts SET user_id =?, topic_id =?, images = ?, title =?, body =?, published =?";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param('iisssi', $id, $topics, $newimages, $title, $body, $published);
              $result = $stmt->execute();
              // Subscriber Notification Start...
              $post_id = $conn->insert_id;
              $sql = "SELECT * FROM subscribers WHERE from_user=?";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param('i', $id);
              $stmt->execute();
              $sub_result = $stmt->get_result();
              while ($subscriber = mysqli_fetch_assoc($sub_result)) {
                 $user_by = $subscriber['by_user'];
                 $sqlSub = "INSERT INTO notifications SET notify_p_id=$post_id, 	notify_u_id=$user_by";
                 mysqli_query($conn, $sqlSub);
              }
              // Subscriber Notification End...
    
              if ($result === true) {
                  move_uploaded_file($img_tmp, $path);
                  session_start();
                  $_SESSION['message'] = '<li class="alert-message bc-green-alert">Posts Uploaded Success.</li>';
                  echo '<script> window.location.href="http://localhost/smartblog//logged/posts/dashboard.php";</script>';
              }else {
                echo $errors['images'] = '<li class="alert-message bc-red-alert">Posts Uploaded Failed</li> ';
              }
              
              
          }
      }
     
      // fetch posts code
      if (isset($_POST['userId'])) {
        $id = $_POST['userId'];
        echo '<tr class="dash-tr">                    
              <th colspan="3">
                  <div class="bc-gray user-con" style="padding: 3px;">
                      <a href="../users/edit.php">
                      <p class="t-c ">Customise Channel</p>
                      </a>
                      <a href="../users/profile.php">
                      <p class="t-c m-t">Your Account</p>
                      </a>
                  </div>
              </th>
              <th colspan="7">
                  <div class="bc-gray user-con" style="display: flex; flex-direction: column;">
                      <a href="create.php">
                      <i class="fa fa-plus-circle" style="font-size:2rem;color: black;"></i>                              
                      </a>
                      <a href="../topics/dashboard.php">
                      Your topics                            
                      </a>
                  </div>
                  </th>
          </tr>
          <tr class="dash-tr">
              <th>Sr No</th>
              <th>Image</th>
              <th class="dash-title t-c">Title</th>
              <th>Viewers</th>
              <th class="dash-ratting" colspan="2">Ratting</th>
              <th>Date</th>
              <th colspan="3">Action</th>
          </tr>';
        $sql = "SELECT * FROM posts p INNER JOIN topics t ON p.topic_id = t.topic_id WHERE p.user_id= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result)>0) {
          $num = 0;
          while ($posts = mysqli_fetch_assoc($result)) {
            $num = $num + 1;
            $post_id = $posts['posts_id'];
            // Views count 
            $sql2 = "SELECT COUNT(*) FROM viewers WHERE posts_id= $post_id";
            $result2 = mysqli_query($conn, $sql2);
            $views = mysqli_fetch_array($result2);
            // Likes count
            $sql2 = "SELECT COUNT(*) FROM rattings WHERE post_id= $post_id AND rates='like'";
            $result2 = mysqli_query($conn, $sql2);
            $likes = mysqli_fetch_array($result2);
            // Dislikes count
            $sql2 = "SELECT COUNT(*) FROM rattings WHERE post_id= $post_id AND rates='dislike'";
            $result2 = mysqli_query($conn, $sql2);
            $dislikes = mysqli_fetch_array($result2);
            
            echo '<tr class="dash-tr">
                    <td>'.$num.' )</td>
                    <td>
                        <a href="../../single.php?post_id='.$posts['posts_id'].'"><img src="../../images/'.$posts['images'].'" class="dash-image"></a>
                    </td>
                    <td class="dash-title">
                        '.$posts['title'].'
                        <b class="cr-red">'.$posts['topics_name'].'</b>
                    </td>
                    <td class="dash-views">
                        <p class="views-count">'.$views[0].'</p>
                        <i class="fa fa-eye"></i>
                    </td>
                    <td class="">
                        <p class="like">'.$likes[0].'</p>
                        <i class="fa fa-thumbs-up"></i>
                    </td>
                    <td class="">
                        <p class="dislike">'.$dislikes[0].'</p>
                        <i class="fa fa-thumbs-down"></i>
                    </td>                     
                    <td>'.date('j F Y', strtotime($posts['dates'])).'</td>                     
                    <td>';
                    if ($posts['published'] === 1) {                      
                     echo '<a href="#" class="published" name="publish" data-published="'.$posts['posts_id'].'" style="text-decoration: none;">Publish</a>';
                    }else {
                      echo '<a href="#" class="published" name="private" data-published="'.$posts['posts_id'].'" style="text-decoration: none;">Private</a>';
                    }                     
                   echo'</td>  
                    <td class="cr-green editPosts" name="editPosts" data-edit="'.$posts['posts_id'].'">Edit</td>                     
                    <td class="cr-red delPosts" name="delPosts" data-del="'.$posts['posts_id'].'">Delete</td>                     
                </tr> ';
          }
        }else {
          echo '<tr class="dash-tr">
               <td colspan="9"><b>Not Posts Available.</b></td>
              </tr> ';
        }
      }

      // published, unpublished, delete , Editing
      if (isset($_POST['postsId'])) {
        $postsId = $_POST['postsId'];
        // published change code
        if ($_POST['published'] === 'publish') {
            $sql = "UPDATE posts SET published = 0 WHERE posts_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $postsId);
            $result = $stmt->execute();
            if ($result === true) {
              echo 'success';
            }
        }
        //  unpublished change
        if ($_POST['published'] === 'private') {
            $sql = "UPDATE posts SET published = 1 WHERE posts_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $postsId);
            $result = $stmt->execute();
            if ($result === true) {
              echo 'success';
            }
        }
        // delete posts code
        if($_POST['published'] === 'delPosts'){
           $sql = "SELECT images FROM posts WHERE posts_id=?";
           $stmt = $conn->prepare($sql);
           $stmt->bind_param('i', $postsId);
           $stmt->execute();
           $result = $stmt->get_result();
           $data = mysqli_fetch_assoc($result);
           unlink('../images/'.$data['images']);
           // posts delete for rattings deleting...
           $sql2 = "DELETE FROM rattings WHERE post_id=?";
           $stmt2 = $conn->prepare($sql2);
           $stmt2->bind_param('i', $postsId);
           $result = $stmt2->execute();
           // posts delete for notifications deleting...
           $sql2 = "DELETE FROM notifications WHERE notify_p_id=?";
           $stmt2 = $conn->prepare($sql2);
           $stmt2->bind_param('i', $postsId);
           $result = $stmt2->execute();
           // posts delete for comment deleting...
           $sql2 = "DELETE FROM comments WHERE post_id=?";
           $stmt2 = $conn->prepare($sql2);
           $stmt2->bind_param('i', $postsId);
           $result = $stmt2->execute();
           // posts delete for Views deleting...
           $sql2 = "DELETE FROM viewers WHERE posts_id=?";
           $stmt2 = $conn->prepare($sql2);
           $stmt2->bind_param('i', $postsId);
           $result = $stmt2->execute();
           // posts delete for posts deleting...
           $sql2 = "DELETE FROM posts WHERE posts_id=?";
           $stmt2 = $conn->prepare($sql2);
           $stmt2->bind_param('i', $postsId);
           $result = $stmt2->execute();
           if($result === true){
             echo 'success';
           }
        }

        // edit posts Fetch code
        if ($_POST['published'] === 'editPosts') {
            $sql = "SELECT * FROM posts WHERE posts_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $postsId);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($postsEdit = mysqli_fetch_assoc($result)) {
               $body = html_entity_decode($postsEdit['body']);
               $count = substr_count($body, "<br>");
               $count = $count + 2;
               $body = str_replace("<br>", "", $body);
               $body = str_replace("</a>", "", $body);
               preg_match_all("/<a href='(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]' target='_blank'>)/i", $body, $array);
               $body = str_replace($array[0], "", $body);
              echo '<form id="postsEdit" class="flexible coloums bc-white form-c" autocomplete="off">
                      <h2 class="t-c">Edit-Data</h2>
                      <div class="message" id="formErrors">                       
                      </div>
                      <label for="title" class="form-lable">Title</label>
                      <input name="postsId" value="'.$postsId.'" type="hidden" id="postsId">
                      <input class="form-input" name="title" value="'.$postsEdit['title'].'" type="text" id="title">
                      <label for="topics" class="form-lable">Topics</label>
                      <select name="topics" id="topics" class="m-b">';
                      $sql = "SELECT * FROM topics";
                      $stmt = $conn->prepare($sql);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      while ($topics = mysqli_fetch_assoc($result)) {
                         if (!empty($postsEdit['topic_id']) && $postsEdit['topic_id'] === $topics['topic_id']) {
                           echo '<option selected value="'.$topics['topic_id'].'">'.$topics['topics_name'].'</option>';
                         }else{

                          echo '<option value="'.$topics['topic_id'].'">'.$topics['topics_name'].'</option>';
                         }
                      }
                     echo'</select>
                      <label for="image" class="form-lable">Image</label>
                      <span class="image-preview m-t">
                          <img class="image-upload previewImage" id="showImage" src="../../images/'.$postsEdit['images'].'" >
                      </span>
                      <input class="d-none profileImage" name="images" type="file" id="images" >
                      <input name="old_images" type="hidden" id="old_images" value="'.$postsEdit['images'].'">
                      <label for="body" class="form-lable m-t">Body</label>
                      <textarea class="form-input form-body" id="body" cols="30" rows="'.$count.'">'.$body.'</textarea>
                      <div class="m-t">';
                        if ($postsEdit['published'] === 1) {
                          echo'<input checked type="checkbox" name="published" id="published"> Published';
                        }else {
                          echo '<input type="checkbox" name="published" id="published"> Published';
                        }
                     echo'</div>
                      <button type="submit" class="signup-btn form-lable">Save</button>              
                  </form>
                  <script src="../../blog/style/jQuery/All-content.js"></script>';
            }
        }
        // edit posts Send code for change
        if ($_POST['published'] === 'postsEditSend') {
              $title = htmlentities($_POST['title']);
              $topics = $_POST['topics'];
              $published = isset($_POST['published']) ? 1 : 0;
              $body = $_POST['body'];
              $body = preg_replace("#\[sp\]#", "&nbsp", $body);
              $body = preg_replace("#\[nl\]#", "<br>\n", $body);
              $body = htmlentities($body);
              $old_image  = $_POST['old_images'];
              $images = $_FILES['images']['name'];
              $img_tmp = $_FILES['images']['tmp_name'];

              if (empty($title)) {
                echo $errors['title'] = '<li class="alert-message bc-red-alert"> Enter The Title.</li>';
              }
              if (empty($topics)) {
                echo $errors['topics'] = '<li class="alert-message bc-red-alert"> Choose the Topics.</li>';
              }
              
              if (empty($body)) {
                echo $errors['body'] = '<li class="alert-message bc-red-alert"> Enter The Body.</li>';
              }
              
              $sql = "SELECT * FROM posts WHERE body = ? LIMIT 1";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param('s',  $body);
              $stmt->execute();
              $result = $stmt->get_result();
              if (mysqli_num_rows($result)>0) {
                  echo $errors['topic'] = '<li class="alert-message bc-red-alert">Already Data Exists.</li>'; 
              }

              $allow_image = array('gif','png','PNG', 'jpg','jpeg', '');
              $filename_axention = pathinfo($images, PATHINFO_EXTENSION);
              if (in_array($filename_axention, $allow_image)) {
                  if (!empty($images)) {
                    $newimages = rand().'.'.$filename_axention;
                    $path = "../images/".$newimages;
                  }else {                
                    $newimages = $old_image;
                }
            }else {
              echo $errors['images'] = '<li class="alert-message bc-red-alert">Allowed PNG, JPG, GIF</li> ';
            }

            if (count($errors) === 0) {
                $sql = "UPDATE posts SET  topic_id =?, images = ?, title =?, body =?, published =? WHERE posts_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('isssii', $topics, $newimages, $title, $body, $published, $postsId);
                $result = $stmt->execute();
                if ($result === true) {
                  if ($images !== '') {
                  if ($old_image !== '') {
                        move_uploaded_file($img_tmp, $path);
                        unlink("../images/". $old_image);                  
                      }else {
                        move_uploaded_file($img_tmp, $path);
                      }
                  }
                  session_start();
                  $_SESSION['message'] = '<li class="alert-message bc-green-alert">Posts Edited Success.</li>';
                  echo '<script> window.location.href="http://localhost/smartblog//logged/posts/dashboard.php";</script>';
                }else {
                  echo $errors['images'] = '<li class="alert-message bc-red-alert">Posts Update Failed</li> ';
                }             
                
            }
        }
      }



?>