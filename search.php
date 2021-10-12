<?php include('path.php') ?>
<?php include(ROOT_PATH . '/blog/connect/db.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
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
    <?php include(ROOT_PATH . "/blog/include/header.php") ?>
    <?php include(ROOT_PATH . "/blog/connect/db.php") ?>
    <!-- Gbody start -->
    <div class="main-container anote">
        <h2 class="m-t">Result : "<?php if (isset($_GET['query'])) { echo $_GET['query']; } ?>"</h2>
        <ul>
         <?php 
             if (isset($_GET['query'])):
                 $search = '%'.$_GET['query'].'%';
              $sql = "SELECT p.posts_id, p.images, p.title, p.published, p.body, p.dates, u.id, u.channel_name, u.username, t.topics_name FROM posts p
                      INNER JOIN users u ON p.user_id= u.id
                      INNER JOIN topics t ON t.topic_id = p.topic_id
                      WHERE p.title LIKE ? OR p.body LIKE ? OR p.dates LIKE ? 
                      OR u.username LIKE ? OR u.channel_name  LIKE ? OR t.topics_name LIKE ? ORDER BY p.dates DESC";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param('ssssss', $search, $search, $search, $search, $search, $search);
              $stmt->execute();
              $result = $stmt->get_result();
              if (mysqli_num_rows($result)>0):
              while ($searchOut = mysqli_fetch_assoc($result)):
                if ($searchOut['published'] == 1):             
         ?>
            <li class="list-item-message">
                <div class="logo-icon">
                    <div class="notification-img">
                        <img src="<?php echo BASE_URL. '/images/'.$searchOut['images'] ?>" alt="">
                    </div>
                    <div class="user-message-send">
                        <a href="<?php echo BASE_URL.'/single.php?post_id='.$searchOut['posts_id'] ?>">
                            <?php echo $searchOut['title'] ?> 
                           <b class="cr-red">
                            <?php echo $searchOut['topics_name'] ?>
                           </b>
                           <p class="cr-black">
                               <?php 
                                    $body = html_entity_decode($searchOut['body']);
                                    $body = str_replace("<br>", "", $body);
                                    $body = str_replace("</a>", "", $body);
                                    preg_match_all("/<a href='(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]' target='_blank'>)/i", $body, $array);
                                    $body = str_replace($array[0], "", $body);
                                    echo substr($body, 0, 100).'<b>...</b>';                                  
                               ?>
                           </p>
                        </a>                        
                        <p class="date-time-show"><?php echo date('j F Y', strtotime($searchOut['dates']))  ?></p>
                    </div>
                    <div class="user-icon-set">
                        <a href="<?php echo BASE_URL.'/channel/channel.php?user_id='.$searchOut['id'] ?>">
                            <div class="user-log-user" style="text-transform: capitalize;">
                             <?php 

                                if (!empty($searchOut['channel_name'])) {
                                    echo substr($searchOut['channel_name'], 0 , 1);
                                }else {
                                    echo substr($searchOut['username'], 0 , 1);
                                }

                             ?>
                          </div>
                        </a>
                    </div>
                </div>
            </li>
            <?php
                endif;
               endwhile;
              else:
            ?>
              <li class="list-item-message">
                 <b>No Found.</b>
                 <p>Search for another data.</p>
              </li>
            <?php
             endif;
            endif;
            ?>           
        </ul>
    </div>
    <script src="blog/style/jQuery/jquery-3.6.0.min.js"></script>
    <script src="blog/style/jQuery/All-content.js"></script>
</body>
</html>