<?php
      include('../path.php');
      include(ROOT_PATH.'/blog/connect/db.php');
      $post_id = "";
      $comment = "";
      $errors = array();
   if (isset($_POST['posts_id'])) {
        // Single Posts Data Fetch RightSite
        $post_id = $_POST['posts_id'];
       if ($_POST['postShow'] === 'singlePost') {
          $sql = "SELECT p.posts_id, p.user_id, p.title, p.images, p.body, p.dates, t.topics_name,u.channel_name, u.username
                  FROM posts p INNER JOIN topics t ON p.topic_id = t.topic_id 
                  INNER JOIN users u ON p.user_id=u.id  WHERE p.published=1 AND p.posts_id=?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('i', $post_id);
          $stmt->execute();
          $result = $stmt->get_result();      
          if (mysqli_num_rows($result)>0) {
            while ($posts = mysqli_fetch_assoc($result)) {                   
                include(ROOT_PATH.'/controller/rateAndsub.php');
                $post_uid = $posts['user_id'];
                //   likes count function
                 function likeCount($post_id){
                     global $conn;
                     $sql = "SELECT COUNT(*) FROM  rattings WHERE post_id=? AND rates='like'";
                     $stmt = $conn->prepare($sql);
                     $stmt->bind_param('i', $post_id);
                     $stmt->execute();
                     $result = $stmt->get_result();
                     $likes = mysqli_fetch_array($result);
                     return $likes[0];
                 }
                //   Dislikes count function
                 function dislikeCount($post_id){
                     global $conn;
                     $sql = "SELECT COUNT(*) FROM  rattings WHERE post_id=? AND rates='dislike'";
                     $stmt = $conn->prepare($sql);
                     $stmt->bind_param('i', $post_id);
                     $stmt->execute();
                     $result = $stmt->get_result();
                     $dislikes = mysqli_fetch_array($result);
                     return $dislikes[0];
                 }
                //  Subscribe Count function
                 function SubscribeCount($post_uid){
                    global $conn;
                    $sql_sub = "SELECT COUNT(*) FROM  subscribers WHERE from_user=? AND joined='subscribe'";
                    $stmt = $conn->prepare($sql_sub);
                    $stmt->bind_param('i', $post_uid);
                    $stmt->execute();
                    $sub = $stmt->get_result();
                    $subCount = mysqli_fetch_array($sub);
                    return $subCount[0];                   
                 }
    
                //  Like And Dislike checking
                 if (isset($_POST['users_id']) AND $_POST['users_id'] !== ''){
                    $user_id = $_POST['users_id'];
                    // like Condition Checked
                    function likedIn($post_id)
                    {
                        global $conn;
                        global $user_id;
                        $sql = "SELECT * FROM rattings WHERE post_id=? AND user_id=? AND rates='like'";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('ii', $post_id, $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if (mysqli_num_rows($result)>0) {
                           return true;
                        }else{
                           return false;
                        }
                    }
                    // Dislike Condition Checked
                    function dislikedIn($post_id)
                    {
                        global $conn;
                        global $user_id;
                        $sql = "SELECT * FROM rattings WHERE post_id=? AND user_id=? AND rates='dislike'";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('ii', $post_id, $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if (mysqli_num_rows($result)>0) {
                           return true;
                        }else{
                           return false;
                        }
                    }

                    // Subscribe Condition Checked
                    function subscribeIn($user_id)
                    {
                        global $conn;
                        global $post_uid;
                        $subscribe = "SELECT * FROM  subscribers WHERE from_user=$post_uid AND by_user=$user_id AND joined='subscribe'";
                        $sub_query = mysqli_query($conn, $subscribe);
                        if (mysqli_num_rows($sub_query)>0) {
                            return true;
                        }else {
                            return false;
                        }
                    }
               
                 }
          echo '<h2 class="t-c single-title">
                    '.$posts['title'].'
                    <b class="cr-red">'.$posts['topics_name'].'</b>                    
                </h2>
                <div class="single-user flexible">
                  <a href="'.BASE_URL.'/channel/channel.php?user_id='.$posts['user_id'].'" class="cr-black" style="text-decoration:none;">
                    <p class="user-data m-l m-t" style="text-transform:capitalize">'; 
                    if (!empty($posts['channel_name'])) {
                        echo $posts['channel_name'];
                    }else {
                        echo $posts['username'];
                    } 
                echo'</p>
                 </a>
                        <p class="like-data flex-single m-l m-t">
                        <span id="like-count">'.likeCount($post_id).'</span>&nbsp;
                        <i ';
                        if (isset($_POST['users_id'])) {
                           if (likedIn($post_id)) {
                             echo'class="fa fa-thumbs-up like-icon"';
                           }else {
                             echo'class="fa fa-thumbs-o-up like-icon"';
                           }
                        }else {
                            echo'class="fa fa-thumbs-o-up like-icon"';
                        }                        
                       echo'></i>
                        &nbsp;&nbsp;&nbsp;                
                        <span id="dislike-count">'.dislikeCount($post_id).'</span>&nbsp;
                        <i ';

                        if (isset($_POST['users_id'])) {
                            if (dislikedIn($post_id)) {
                                echo'class="fa fa-thumbs-down dislike-icon"';
                            }else {
                                echo'class="fa fa-thumbs-o-down dislike-icon"';
                            }
                        }else {
                            echo'class="fa fa-thumbs-o-down dislike-icon"';
                        }                     
                        
                       echo'></i>
                    </p>
                    <p class="subscribe-data flex-single m-l m-t" id="posts_uid" data-posts_uid="'.$post_uid.'">                       
                        <span id="subscribe-count">'.SubscribeCount($post_uid).'</span> &nbsp; ';
                      if (isset($_POST['users_id'])) {
                          if ($_POST['users_id'] == $posts['user_id']) {
                             echo'<button class="subscribe-btn">Subscribe</button>';
                          }else {
                              if (subscribeIn($_POST['users_id'])) {                                 
                                  echo'<button class="subscribe-btn subscribe-join">Subscribe</button>';
                              }else {
                                echo'<button class="unsubscribe-btn subscribe-join">Subscribe</button>';
                              }
                          }
                      }else {
                           echo'<button class="unsubscribe-btn subscribe-join">Subscribe</button>';
                      }
                     
                   echo'</p>
                    <div class="views-data flex-single m-l m-t">
                        <span id="views-count"></span>&nbsp;
                        <p class="views-i-show">Views</p>
                    </div>
                    <p class="banner-date m-l m-t">'.date('j F Y', strtotime($posts['dates'])).'</p>
                </div>
                <div class="single-img" >
                    <img src="images/'.$posts['images'].'">
                </div>
                <div class="single-body single-title " style="font-size: 2rem;">
                    '.html_entity_decode($posts['body']).'
                </div>
                <div>';
                    session_start();
                if (isset($_SESSION['logining']) && $_SESSION['logining'] === true){
                   echo'<form id="postsComment" class="flexible coloums bc-white form-c" autocomplete="off">
                        <div class="message" id="formErrors">                    
                        </div>
                        <label for="comments" class="form-lable cr-green">Comment</label>
                        <textarea class="form-input form-body" name="comments" id="comments" cols="30" rows="0"></textarea>
                        <button type="submit" class="form-button form-lable">Send</button>
                    </form>';
                    }else {
                    echo '<form id="notLogin" class="flexible coloums bc-white form-c" autocomplete="off">
                        <label for="comments" class="form-lable cr-green">Comment</label>
                        <textarea class="form-input form-body" cols="30" rows="0"></textarea>
                        <a href="'.BASE_URL.'/login.php" type="submit" class="form-button form-lable">Send</a>
                     </form>';
                    }
            echo '</div>
                <div class="single-body Comment" id="commentshow">
                   
                </div>';
            }
          }else{
              echo '<h3 style="width:80%; margin:auto;"> No Posts Available</h3>';
          }
       }
       //  Single Page Randam Data LeftSite
       if ($_POST['postShow'] === 'singlePostRand') {          
            $sql = "SELECT p.posts_id,p.title, p.images, p.dates, t.topics_name,u.id, u.channel_name, u.username
            FROM posts p INNER JOIN topics t ON p.topic_id = t.topic_id 
            INNER JOIN users u ON P.user_id=u.id WHERE p.published = 1 ORDER BY RAND() LIMIT 2";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result =  $stmt->get_result();
            while ($posts = mysqli_fetch_assoc($result)){
               echo '<div class="multiple-show">
                        <div class="multiple-img single-img" >
                          <a href="single.php?post_id='.$posts['posts_id'].'">
                            <img src="images/'.$posts['images'].'">
                          </a>
                        </div>
                        <div class="data-flexing">
                         <a href="'.BASE_URL.'/channel/channel.php?user_id='.$posts['id'].'" class="cr-black" style="text-decoration:none;">
                            <p class="user-data">';
                            if (!empty($posts['channel_name'])) {
                                echo substr($posts['channel_name'], 0, 5);
                            }else {
                                echo substr($posts['username'], 0, 5);
                            } 
                            echo '
                            </p>
                         </a>
                            <p class="date-single">'.date('j F Y', strtotime($posts['dates'])).'</p>
                        </div>
                        <h4 class="t-c single-title">
                            '.$posts['title'].'
                            <b class="cr-red">'.$posts['topics_name'].'</b>
                        </h4>
                    </div> ';
            }
       }
       // Comment Insert In Posts
       if ($_POST['postShow'] === 'singleComment') {  
           $user_id = $_POST['users_id'];     
           $comment = htmlentities($_POST['comments']);              
         if (!empty($user_id)) {             
            if (empty($comment)) {
                echo $errors['comments'] = '<li class="alert-message bc-red-alert"> Enter The Comment.</li>';
              }
              if (count($errors) === 0) {           
                $sql = "INSERT INTO comments SET user_id=?, post_id=?, comments=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('iis', $user_id, $post_id, $comment);
                $result = $stmt->execute();
                if ($result === true) {
                    echo 'success';
                }else {
                    echo $errors['comments'] = '<li class="alert-message bc-red-alert"> Failed Send Comment.</li>';
                }
             }
         }
       }
       //  comment Show In Posts
       if($_POST['postShow'] === 'commentShow'){          
          $sql = "SELECT * FROM comments c INNER JOIN users u ON c.user_id=u.id WHERE c.post_id = ? ORDER BY c.com_date DESC";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('i', $post_id);
          $stmt->execute();
          $result = $stmt->get_result();
          if (mysqli_num_rows($result)> 0) {
            while ($comments = mysqli_fetch_assoc($result)) {
                echo ' <div class="logo-icon bc-gy-alert comment-show" style="padding-left: 2%;">
                        <div class="user-message-send">
                            <b>
                                '.$comments['comments'].'                               
                            </b>
                            <p class="date-time-show">
                             '.date('j F Y', strtotime($comments['com_date'])).'
                            </p>
                        </div>
                        <div class="user-icon-set" style="text-transform: capitalize;">
                            <a href="#">';
                               if (!empty($comments['images'])) {
                                  echo '<img class="icon-log-user" src="'.BASE_URL.'/images/'.$comments['images'].'">'; 
                               }else {
                                   if (!empty($comments['channel_name'])) {
                                     echo '<div class="user-log-user">'.substr($comments['channel_name'], 0, 1).'</div>';
                                   }else {
                                     echo '<div class="user-log-user">'.substr($comments['username'], 0, 1).'</div> ';
                                   }
                               }                              
                           echo'</a>
                        </div>
                    </div>';
              }
          }else {
              echo '<div class="bc-red-alert" style="padding-left: 2%;">
                       <b> No Comment </b>
                       <p> In Posts Comment Zero...</p>
                   </div>';
          }

       }
       //  Views Insert And show For Posts
       if ($_POST['postShow'] === 'insertShowViews') {
           if (isset($_POST['users_id'])) {
                $user_id = $_POST['users_id'];
                $sql = "SELECT * FROM viewers WHERE posts_id =? AND user_id=? LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ii', $post_id, $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if (mysqli_num_rows($result) === 0) {
                    $sql = "INSERT INTO viewers SET posts_id =?, user_id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ii', $post_id, $user_id);
                    $stmt->execute();
                }
          }
          $sql = "SELECT * FROM viewers WHERE posts_id=?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('i', $post_id);
          $stmt->execute();
          $result = $stmt->get_result();
          echo  mysqli_num_rows($result);
       }  
   }



?>