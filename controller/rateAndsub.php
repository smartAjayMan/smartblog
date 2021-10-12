<?php
  include(ROOT_PATH.'/blog/connect/db.php');
  //  like and dislike controller
if (isset($_POST['users_id'])) {
   $user_id = $_POST['users_id'];
   if (isset($_POST['action'])) {
     $action = $_POST['action'];
     $posts_id = $_POST['posts_id'];
          // ratting count in likes
          function rattings($id){
            global $conn;
            $sql_like = "SELECT COUNT(*) FROM rattings WHERE post_id=$id AND rates='like'";
            $query_like = mysqli_query($conn, $sql_like);
            $likes = mysqli_fetch_array($query_like);

            $sql_dislike = "SELECT COUNT(*) FROM rattings WHERE post_id=$id AND rates='dislike'";
            $query_dislike = mysqli_query($conn, $sql_dislike);
            $dislikes = mysqli_fetch_array($query_dislike);
            $rattings = [
                "likes" => $likes[0],
                "dislikes" => $dislikes[0]
            ];
            return json_encode($rattings);
          }

          switch ($action) {
            case 'like':
              $sql = "INSERT INTO rattings SET post_id=?, user_id=?,
                      rates='like' ON DUPLICATE KEY UPDATE 	rates='like'";
              break;
            case 'unlike':
              $sql = "DELETE FROM rattings WHERE post_id=? AND user_id=?";
              break;            
            case 'dislike':
              $sql = "INSERT INTO rattings SET post_id=?, user_id=?,
                      rates='dislike' ON DUPLICATE KEY UPDATE 	rates='dislike'";
              break;
            case 'undislike':
              $sql = "DELETE FROM rattings WHERE post_id=? AND user_id=?";
              break;            
            default:
              break;
          }
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('ii', $posts_id, $user_id);
          $stmt->execute();
          echo rattings($posts_id);   
          exit(0);
      }
}
//  Subscribe controller
if (isset($_POST['users_id'])) {
   $user_id = $_POST['users_id'];
   if (isset($_POST['subAction']) && $_POST['users_id'] !== $_POST['posts_uid']) {
     $action = $_POST['subAction'];
     $posts_uid = $_POST['posts_uid'];   
          // ratting count in likes
          function subRate($id){
            global $conn;
            $sql_sub = "SELECT COUNT(*) FROM  subscribers WHERE from_user=$id AND joined='subscribe'";
            $query_sub = mysqli_query($conn, $sql_sub);
            $subscribes = mysqli_fetch_array($query_sub);
            $subRate = [
                "subscribes" => $subscribes[0]
            ];
            return json_encode($subRate);
          }

          switch ($action) {
            case 'subscribe':
              $sql = "INSERT INTO subscribers SET from_user=?, by_user=?,
                      joined='subscribe' ON DUPLICATE KEY UPDATE 	joined='subscribe'";
              break;
            case 'unsubscribe':
              $sql = "DELETE FROM subscribers WHERE from_user=? AND by_user=?";
              break;                     
            default:
              break;
          }
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('ii', $posts_uid, $user_id);
          $stmt->execute();
          echo subRate($posts_uid);   
          exit(0);
      }
}

?>