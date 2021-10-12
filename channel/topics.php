<?php include('../path.php')?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>topics</title>
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
            <div class="right-channel bc-green-alert">        
             <?php
              if (isset($_GET['topic_id'])):
                $topic_id = $_GET['topic_id'];
                $sql = "SELECT * FROM topics WHERE topic_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $topic_id);
                $stmt->execute();
                $result = $stmt->get_result();
              if (mysqli_num_rows($result)>0):
                 $topics = mysqli_fetch_assoc($result); 
             ?>
              <div class="pointMenu bc-gray m-t">              
                <h2 class="t-c m-t cr-white" style="text-transform: capitalize;">
                   <?php echo $topics['topics_name'] ?>           
                </h2>  
                <div  class="flexible coloums form-c">
                    <p for="comments" class="form-lable t-c ">Description</p>
                    <div class="m-t t-c cr-white">
                        <?php echo html_entity_decode($topics['description']) ?>
                    </div>
                </div>               
              </div>     
             <?php 
                else:
             ?>              
              <div class="pointMenu bc-gray m-t">              
                <h2 class="t-c m-t cr-white" style="text-transform: capitalize;">
                   Information          
                </h2>  
                <div  class="flexible coloums form-c">
                    <p for="comments" class="form-lable t-c ">Description</p>
                    <div class="m-t t-c cr-white">
                        Sorry <b><?php echo $_GET['topic_id'] ?></b> In Id Not Topics Available...
                    </div>
                </div>               
              </div>
            <?php
                endif;
              endif;             
             ?>
            </div>
            <!-- different content -->
            <div class="left-channel bc-white">
                <h2 class="t-c">Topics-List</h2>
                <div class="tp-ur cha-card">
                    <?php 
                    if (isset($_GET['topic_id'])):
                       $topic_id = $_GET['topic_id'];
                       $sql = "SELECT p.posts_id, p.title, p.images,p.dates, u.id, u.username, u.channel_name, t.topics_name FROM posts p 
                               INNER JOIN users u ON p.user_id=u.id
                               INNER JOIN topics t ON p.topic_id=t.topic_id
                               WHERE p.published=1 AND p.topic_id=?";
                       $stmt = $conn->prepare($sql);
                       $stmt->bind_param('i', $topic_id);
                       $stmt->execute();
                       $result = $stmt->get_result();
                     if (mysqli_num_rows($result)>0):
                        while ($topics = mysqli_fetch_assoc($result)):  
                     ?>
                    <div class="multiple-show">
                        <div class="multi-cha-img" > 
                            <a href="<?php echo BASE_URL.'/single.php?post_id='.$topics['posts_id'] ?>">
                              <img src="<?php echo BASE_URL.'/images/'.$topics['images'] ?>">
                            </a>
                        </div>
                        <div class="multi-single-user single-user flex-single">
                        <a href="<?php echo BASE_URL.'/channel/channel.php?user_id='.$topics['id'] ?> " class="cr-black" style="text-decoration:none;">
                            <p class="user-data">
                            <?php 
                               if (!empty($topics['channel_name'])) {
                                   echo substr($topics['channel_name'], 0, 5);
                               }else {
                                   echo substr($topics['username'], 0, 5);
                               }
                            ?>
                            </p>
                        </a>
                            <p class="banner-date">
                                <?php echo date('j F Y', strtotime($topics['dates'])) ?>
                            </p>
                        </div>
                        <h4 class="t-c single-title">
                            <?php echo substr($topics['title'], 0, 100);  ?>
                            <b class="cr-red"><?php echo $topics['topics_name'] ?></b>
                        </h4>
                   </div>   
                   <?php 
                        endwhile;
                       else:
                        echo "Sorry In Topics Posts Is Not Available.";
                       endif;
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
  </body>
 </html>