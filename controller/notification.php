<?php
 include('../path.php');
 include(ROOT_PATH.'/blog/connect/db.php');
if (isset($_POST['n_user_id']) && !empty($_POST['n_user_id'])) {
    $user_id = $_POST['n_user_id'];
    $SubNoty_sql = "SELECT p.posts_id, p.images, p.title, p.dates, u.id, u.username, u.channel_name, n.notify_p_id, n.notify_u_id FROM notifications n
    INNER JOIN posts p ON p.posts_id = n.notify_p_id 
    INNER JOIN users u ON u.id = p.user_id
    WHERE p.published=1 AND n.notify_u_id=?";
    $stmt = $conn->prepare($SubNoty_sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $sub_result = $stmt->get_result();
    $comment_sql = "SELECT p.posts_id, p.images, u.id, u.username, u.channel_name, c.comment_id, c.comments, c.com_date FROM posts p
    INNER JOIN comments c ON p.posts_id = c.post_id 
    INNER JOIN users u ON u.id = c.user_id
    WHERE c.status=0 AND p.user_id=?";
    $stmt = $conn->prepare($comment_sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $comm_result = $stmt->get_result();
    if (mysqli_num_rows($sub_result) || mysqli_num_rows($comm_result)>0) {
        // posts fetching.... 
        while ($subscriber = mysqli_fetch_assoc($sub_result)) {
          echo '<li class="list-item-message">
                <p id="n_user_id" data-n_user_id="'.$subscriber['notify_u_id'].'"></p>
                <div class="logo-icon">
                    <div class="notification-img removing" data-status="'.$subscriber['notify_p_id'].'">
                        <img src="'.BASE_URL.'/images/'.$subscriber['images'].'" alt="">
                    </div>
                    <div class="user-message-send">
                        <a href="'.BASE_URL.'/single.php?post_id='.$subscriber['posts_id'].'">'.$subscriber['title'].'</a>
                        <p class="date-time-show">'.date('j F Y', strtotime($subscriber['dates'])).'</p>
                    </div>
                    <div class="user-icon-set">
                        <a href="'.BASE_URL.'/channel/channel.php?user_id='.$subscriber['id'].'">
                            <div class="user-log-user" style="text-transform: capitalize;">';
                            if (!empty($subscriber['channel_name'])) {
                               echo substr($subscriber['channel_name'], 0 , 1);
                            }else {
                               echo substr($subscriber['username'], 0 , 1);
                            }
                           echo'</div>
                        </a>
                    </div>
                </div>
            </li> ';
        }
        // comments fetching....
        while ($comments = mysqli_fetch_assoc($comm_result)) {
            echo '<li class="list-item-message">
                     <div class="logo-icon">
                         <div class="notification-img updating" data-status="'.$comments['comment_id'].'">
                             <img src="'.BASE_URL.'/images/'.$comments['images'].'" alt="">
                         </div>
                         <div class="user-message-send"><b>Comment </b>
                             <a href="'.BASE_URL.'/single.php?post_id='.$comments['posts_id'].'">'.$comments['comments'].'</a>
                             <p class="date-time-show">'.date('j F Y', strtotime($comments['com_date'])).'</p>
                         </div>
                         <div class="user-icon-set">
                             <a href="'.BASE_URL.'/channel/channel.php?user_id='.$comments['id'].'">
                                 <div class="user-log-user" style="text-transform: capitalize;">';
                                 if (!empty($comments['channel_name'])) {
                                    echo substr($comments['channel_name'], 0 , 1);
                                 }else {
                                    echo substr($comments['username'], 0 , 1);
                                 }
                                echo'</div>
                             </a>
                         </div>
                     </div>
                 </li> ';
        }
    }else {
        echo "<b>Information </b> Notification Is Zero...";
    }
}

   if (isset($_POST['action'])) {
       $multi_id = $_POST['multi_id'];
       $user_id = $_POST['user_id'];
      if ($_POST['action'] === 'remove') {
          $sql = "DELETE FROM notifications WHERE notify_p_id=$multi_id AND notify_u_id=$user_id";
          $result = mysqli_query($conn, $sql);
          if ($result === true) {
              echo 1;
          }else {
              echo 0;
          }
      }

      if ($_POST['action'] === 'update') {
          $sql = "UPDATE comments SET status=1 WHERE comment_id=$multi_id";
          $result = mysqli_query($conn, $sql);
          if ($result === true) {
              echo 1;
          }else {
              echo 0;
          }
      }
   }