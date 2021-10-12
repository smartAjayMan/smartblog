<?php include('../path.php') ?>
<?php include(ROOT_PATH.'/controller/rateAndsub.php') ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Channel</title>
        <!-- header css -->
        <link rel="stylesheet" href="../blog/style/GBody/header_style.css">
        <!-- Gbody css -->
        <link rel="stylesheet" href="../blog/style/GBody/mainBody.css">
        <!-- footer css -->
        <link rel="stylesheet" href="../blog/style/GBody/footer_style.css">
        <!-- multi color css -->
        <link rel="stylesheet" href="../blog/style/GBody/multi-color.css">
        <!-- single css -->
        <link rel="stylesheet" href="../blog/style/GBody/single.css">
        <!-- font awesome link -->
        <link rel="stylesheet" href="../https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" 
        integrity="sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni" crossorigin="anonymous">
    </head>  
    <body class="bc-aquamarine">
    <!-- header start -->   
    <?php include(ROOT_PATH."/blog/include/header.php") ?>
    <?php include(ROOT_PATH."/blog/connect/db.php") ?>
    <!-- Gbody start -->
    <div class="main-container">
       <div class="many-container flexible">    
       <?php
            // Login User Condition Checking...
            if (isset($_SESSION['logining']) && $_SESSION['logining'] === true){
                echo '<div id="users_id" data-users_id="'.$_SESSION['id'].'" ></div>';
            }              
              // Users Channel Id Show
               $sql = "SELECT id, images, username, channel_name, description FROM users WHERE id=?";
               $stmt= $conn->prepare($sql);
               $stmt->bind_param('i', $_GET['user_id']);
               $stmt->execute();
               $result = $stmt->get_result();
               if (mysqli_num_rows($result)>0):
              while($userInfo = mysqli_fetch_assoc($result)):
           ?>
             <p id="posts_uid" data-posts_uid="<?php echo $userInfo['id'] ?>"></p>
            <div class="right-channel bc-green-alert">        
              <div class="pointMenu bc-gray">
                <?php if (!empty($userInfo['images'])):?>
                <div class="channel-image" >
                    <img src="<?php echo BASE_URL.'/images/'.$userInfo['images'] ?>">
                </div>
                <?php endif; ?>
                <h2 class="t-c m-t" style="text-transform: capitalize;">
                <?php 
                    if (!empty($userInfo['channel_name'])) {
                        echo $userInfo['channel_name'];
                    }else {
                        echo $userInfo['username'];
                    }                               
                ?>                
                </h2>  
                <h2 class="m-a m-t flex-single subscribe-channel">
                   
                   <?php 
                   
                    //  Subscribe Count function
                    function SubscribeCount($id){
                        global $conn;
                        $sql_sub = "SELECT COUNT(*) FROM  subscribers WHERE from_user=? AND joined='subscribe'";
                        $stmt = $conn->prepare($sql_sub);
                        $stmt->bind_param('i', $id);
                        $stmt->execute();
                        $sub = $stmt->get_result();
                        $subCount = mysqli_fetch_array($sub);
                        return $subCount[0];                   
                    }

                 if (isset($_SESSION['id']) AND $_SESSION['id'] !== ''){
                      $post_uid = $userInfo['id'];
                     
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
                 ?>
                  <span class="t-c m-a" id="subscribe-count">
                      <?php echo SubscribeCount($userInfo['id']) ?>
                  </span>&nbsp; 
                 
                 <?php
                   if (isset($_SESSION['id'])) {
                          if ($_SESSION['id'] == $userInfo['id']) {
                             echo'<button class="subscribe-btn m-a">Subscribe</button>';
                          }else {
                              if (subscribeIn($_SESSION['id'])) {                                 
                                  echo'<button class="subscribe-btn subscribe-join m-a">Subscribe</button>';
                              }else {
                                echo'<button class="unsubscribe-btn subscribe-join m-a">Subscribe</button>';
                              }
                          }
                      }else {
                           echo'<button class="unsubscribe-btn subscribe-join m-a">Subscribe</button>';
                      }       
                    ?>       
                </h2>  
                <div  class="flexible coloums cr-white form-c">
                    <p for="comments" class="form-lable t-c ">Description</p>
                    <div class="m-t t-c">
                        <?php if (!empty($userInfo['description'])): ?>
                           <?php echo html_entity_decode($userInfo['description']) ?>
                        <?php else: ?>
                           <b><?php echo $_GET['user_id'] ?></b> In Id For Not Channel Created...
                        <?php endif; ?>
                    </div>
                </div>
               
              </div>           
            </div>

            <?php 
              endwhile;
            else:
            ?>
                <div class="right-channel bc-green-alert">        
              <div class="pointMenu bc-gray">
                <div class="channel-image" >
                    <img src="../images/userIcon.png">
                </div>
                <h2 class="t-c m-t" style="text-transform: capitalize;">
                  Unkown User               
                </h2>  
                <h2 class="m-a m-t flex-single subscribe-channel">
                   <p class="subscribe-uncount t-c">99999</p>&nbsp;
                   <button class="unsubscribe-btn bc-red cr-white t-c">Subscribe</button>
                </h2>  
                <div  class="flexible coloums cr-white form-c">
                    <p for="comments" class="form-lable t-c ">Description</p>
                    <div class="m-t t-c">
                       Sorry <b><?php echo $_GET['user_id'] ?></b> In Id Channel Not Available...
                    </div>
                </div>
               
              </div>           
            </div>
            <?php
            endif;
            ?>
            <!-- different content -->
            <div class="left-channel bc-white">
                <h2 class="t-c">Channel-List</h2>
               <div class="tp-ur cha-card">
                <?php 
                  // User Channel Related Posts Show 
                  $sql ="SELECT u.username, u.channel_name, p.posts_id, p.title, p.images, p.dates, t.topics_name
                          FROM users u INNER JOIN posts p ON u.id=p.user_id
                          INNER JOIN topics t ON p.topic_id=t.topic_id
                          WHERE p.published=1 AND u.id=?";
                  $stmt= $conn->prepare($sql);
                  $stmt->bind_param('i', $_GET['user_id']);
                  $stmt->execute();
                  $result = $stmt->get_result();
                 if (mysqli_num_rows($result)>0):
                   while($userPosts = mysqli_fetch_assoc($result)):
                
                ?>
                    <div class="multiple-show">
                        <div class="multi-cha-img" >
                            <a href="<?php echo BASE_URL.'/single.php?post_id='.$userPosts['posts_id'] ?>">
                              <img src="<?php echo BASE_URL.'/images/'.$userPosts['images'] ?>">
                            </a>
                        </div>
                        <div class="multi-single-user single-user flex-single">
                            <p class="user-data">
                            <?php 
                                  if (!empty($userPosts['channel_name'])) {
                                       echo substr($userPosts['channel_name'], 0, 5);
                                  }else {
                                       echo substr($userPosts['username'], 0, 5);
                                  }                               
                               ?>
                            </p>
                            <p class="banner-date"><?php echo date('j F Y', strtotime($userPosts['dates'])) ?></p>
                        </div>
                        <h4 class="t-c single-title">
                             <?php echo substr($userPosts['title'], 0, 100) ?>
                            <b class="cr-red"><?php echo $userPosts['topics_name'] ?></b>
                        </h4>
                    </div>                         
                <?php
                   
                   endwhile;
                else:
                   echo "Channel Related Not Posts Available...";
                endif;
                ?>  
               </div>                     
            </div>
       </div>
    </div>
    <!-- Footer start -->
    <?php include(ROOT_PATH."/blog/include/footer.php") ?>         
    <script src="../blog/style/jQuery/jquery-3.6.0.min.js"></script>
    <script src="../blog/style/jQuery/All-content.js"></script>
    <script>
        $(document).ready( function(){
            // Subscribe In Channel....
            let users_id = $('#users_id').data('users_id');
            $(document).on('click', '.subscribe-join', function(){
             let posts_uid = $('#posts_uid').data('posts_uid');
               click_btn = $(this);
               if(click_btn.hasClass('unsubscribe-btn')){
                   subAction = "subscribe";
               }else if (click_btn.hasClass('subscribe-btn')){
                   subAction = "unsubscribe";
               }
               if (users_id !== undefined) {
                $.ajax({
                        url : "channel.php",
                        method : "POST",
                        data : {
                            subAction : subAction,
                            posts_uid : posts_uid,
                            users_id :users_id
                        },
                        success : function (data){
                            subRate = JSON.parse(data);
                            if (subAction == "subscribe") {
                                click_btn.removeClass('unsubscribe-btn');
                                click_btn.addClass('subscribe-btn');                               
                            }else if (subAction == "unsubscribe") {
                                click_btn.removeClass('subscribe-btn');
                                click_btn.addClass('unsubscribe-btn'); 
                            }
                            click_btn.siblings('span#subscribe-count').text(subRate.subscribes);
                        }
                });
               }else{
                  window.location.href="http://localhost/smartblog//login.php";
               }
               
          });
        });
    </script>
  </body>
 </html>                      