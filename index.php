<?php include('path.php') ?>
<?php include(ROOT_PATH.'/blog/connect/db.php') ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Blog-Ajay</title>
        <!-- header css -->
        <link rel="stylesheet" href="blog/style/GBody/header_style.css">
        <!-- Gbody css -->
        <link rel="stylesheet" href="blog/style/GBody/mainBody.css">
        <!-- footer css -->
        <link rel="stylesheet" href="blog/style/GBody/footer_style.css">
        <!-- multi color css -->
        <link rel="stylesheet" href="blog/style/GBody/multi-color.css">
    </head>
  
 <body class="bc-aquamarine">
    <!-- header start -->   
   <?php include(ROOT_PATH."/blog/include/header.php") ?>
    <!-- Gbody start -->
    <div class="main-container">
        <div class="cart-content">
            <div class="img-main" id="image">
                <span class="text-main cr-white" id="change-cr">
                    <h2 class="text-content t-c">Welcome To SmartAjay</h2>
                    <div class="t-c text-para">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                         Quis sunt illo obcaecati alias amet eaque ducimus, recusandae 
                         cupiditate quasi consectetur deleniti

                    </div>
                </span>
                <img src="https://source.unsplash.com/1600x900/?code">
                <span class="change-text">
                    <p id="show-text" class="form-lable cr-white"></p>
                </span>
            </div>
            <div class="flexible flex-coloum home-body">
            <?php  
                 $sql = "SELECT p.user_id, p.posts_id,p.title, p.images, p.dates, t.topics_name,u.channel_name, u.username
                         FROM posts p INNER JOIN topics t ON p.topic_id = t.topic_id 
                         INNER JOIN users u ON P.user_id=u.id WHERE p.published = 1 ORDER BY RAND() LIMIT 3";
                 $stmt = $conn->prepare($sql);
                 $stmt->execute();
                 $result =  $stmt->get_result();
                 while ($posts = mysqli_fetch_assoc($result)):             

            ?>
                <div class="content">
                    <a href="single.php?post_id=<?php echo $posts['posts_id'] ?>" style="text-decoration: none;">
                    <div class="content-img">
                        <img src="images/<?php echo $posts['images'] ?>">
                        <p class="title">
                            <b>
                              <?php echo $posts['title'] ?>
                            </b>
                            <span class="cr-red"><?php echo $posts['topics_name'] ?></span>
                        </p>
                        <div class="cart-user-content flexible">
                            <a href="<?php echo BASE_URL.'/channel/channel.php?user_id='.$posts['user_id'] ?>"
                             style="text-decoration: none;">
                              <b class="user-data cr-black">
                               <?php 
                                  if (!empty($posts['channel_name'])) {
                                       echo $posts['channel_name'];
                                  }else {
                                       echo $posts['username'];
                                  }                               
                               ?>
                              </b>
                            </a>
                            <p class="banner-date"><?php echo date('F j,Y', strtotime($posts['dates'])) ?></p>
                        </div>
                    </div>
                    </a>
                </div>
            <?php endwhile; ?>
            </div>           
      </div>
    </div>
    <!-- Footer start -->
  <?php include(ROOT_PATH."/blog/include/footer.php") ?>
         
    <script src="blog/style/jQuery/jquery-3.6.0.min.js"></script>
    <script src="blog/style/jQuery/All-content.js"></script>
  </body>
 </html>