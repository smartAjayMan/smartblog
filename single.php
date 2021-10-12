<?php include('path.php') ?>
<?php include(ROOT_PATH.'/controller/rateAndsub.php') ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>single</title>
        <!-- header css -->
        <link rel="stylesheet" href="blog/style/GBody/header_style.css">
        <!-- Gbody css -->
        <link rel="stylesheet" href="blog/style/GBody/mainBody.css">
        <!-- footer css -->
        <link rel="stylesheet" href="blog/style/GBody/footer_style.css">
        <!-- multi color css -->
        <link rel="stylesheet" href="blog/style/GBody/multi-color.css">
        <!-- single css -->
        <link rel="stylesheet" href="blog/style/GBody/single.css">
        <!-- font awesome link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>  
    <body class="bc-aquamarine">
    <!-- header start -->   
    <?php include(ROOT_PATH."/blog/include/header.php") ?>
    <!-- Gbody start -->
    <div class="main-container">
      <?php
        if (isset($_SESSION['logining']) && $_SESSION['logining'] === true){
            echo '<div id="users_id" data-users_id="'.$_SESSION['id'].'" ></div>';
        }
      ?>
       <div class="many-container flexible" id="posts_id" data-posts_id="<?php echo $_GET['post_id'] ?>">
            <div class="right-container bc-white" id="rightSingle">             
            </div>
            <!-- different content -->
            <div class="left-container" id="singlePostRand">                               
            </div>
       </div>
    </div>
    <!-- Footer start -->
    <?php include(ROOT_PATH."/blog/include/footer.php") ?>         
    <script src="blog/style/jQuery/jquery-3.6.0.min.js"></script>
    <script src="blog/style/jQuery/All-content.js"></script>
    <script>
       $(document).ready(function () {
          let posts_id = $('#posts_id').data('posts_id');
          let users_id = $('#users_id').data('users_id');
          let postShow = "singlePost";
          // single data fetching 
          $.ajax({
              url : "controller/single.php",
              method : "POST",
              data : {posts_id:posts_id, postShow:postShow, users_id:users_id},
              success : function (data) {
                  $('#rightSingle').html(data);
              }
          });
              postShow = "singlePostRand";
          $.ajax({
              url : "controller/single.php",
              method : "POST",
              data : {posts_id:posts_id, postShow:postShow},
              success : function (data) {
                  $('#singlePostRand').html(data);
              }
          });          
          // Views Insert And Fetch
              postShow = "insertShowViews";
          $.ajax({
            url : "controller/single.php",
            method : "POST",
            data : {
                    posts_id:posts_id,
                    users_id:users_id,
                    postShow:postShow
                    },
            success : function (data) {
                $('#views-count').text(data);
            }
          });
          // Comment Show In Posts 
              postShow = "commentShow";
          function loadPage() {
            $.ajax({
              url : "controller/single.php",
              method : "POST",
              data : {posts_id:posts_id, postShow:postShow},
              success : function (data) {
                 $('#commentshow').html(data);
              }
           });
          }
          loadPage();
          // Comment Sending In Posts
          $(document).on('submit', '#postsComment', function (e) {
              e.preventDefault();
              let formdata = new FormData(this);
                formdata.append('posts_id', posts_id);
                formdata.append('users_id', users_id);
                formdata.append('postShow', 'singleComment');
                $.ajax({
                    url : "controller/single.php",
                    method : "POST",
                    data : formdata,
                    processData : false,
                    contentType : false,
                    success : function (data) {
                      $('#formErrors').html(data);
                      if (data === 'success') {
                          $('#postsComment').trigger('reset');
                          $('#formErrors').html('<li class="alert-message bc-green-alert"> Send Comment.</li>');
                          loadPage();
                      }
                    }
                });
          });                
          // Like  In Posts
          $(document).on('click', '.like-icon', function(){
               click_btn = $(this);
               if(click_btn.hasClass('fa-thumbs-o-up')){
                   action = "like";
               }else if (click_btn.hasClass('fa-thumbs-up')){
                   action = "unlike";
               }
               if (users_id !== undefined) {
                $.ajax({
                        url : "single.php",
                        method : "POST",
                        data : {
                            action : action,
                            posts_id : posts_id,
                            users_id :users_id
                        },
                        success : function (data){
                            rate = JSON.parse(data);
                            if (action == "like") {
                                click_btn.removeClass('fa-thumbs-o-up');
                                click_btn.addClass('fa-thumbs-up');                               
                            }else if (action == "unlike") {
                                click_btn.removeClass('fa-thumbs-up');
                                click_btn.addClass('fa-thumbs-o-up'); 
                            }
                            click_btn.siblings('span#like-count').text(rate.likes);
                            click_btn.siblings('span#dislike-count').text(rate.dislikes);

                            click_btn.siblings('i.fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
                        }
                });
               }else{
                   window.location.href="http://localhost/smartblog//login.php";
               }               
          });
          // Dislike  In Posts
          $(document).on('click', '.dislike-icon', function(){
               click_btn = $(this);
               if(click_btn.hasClass('fa-thumbs-o-down')){
                   action = "dislike";
               }else if (click_btn.hasClass('fa-thumbs-down')){
                   action = "undislike";
               }
               if (users_id !== undefined) {
                $.ajax({
                        url : "single.php",
                        method : "POST",
                        data : {
                            action : action,
                            posts_id : posts_id,
                            users_id :users_id
                        },
                        success : function (data){
                            rate = JSON.parse(data);
                            if (action == "dislike") {
                                click_btn.removeClass('fa-thumbs-o-down');
                                click_btn.addClass('fa-thumbs-down');                               
                            }else if (action == "undislike") {
                                click_btn.removeClass('fa-thumbs-down');
                                click_btn.addClass('fa-thumbs-o-down'); 
                            }
                            click_btn.siblings('span#like-count').text(rate.likes);
                            click_btn.siblings('span#dislike-count').text(rate.dislikes);

                            click_btn.siblings('i.fa-thumbs-up').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up')
                        }
                });
               }else{
                  window.location.href="http://localhost/smartblog//login.php";
               }               
          });          
          // Subscribe In Posts
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
                        url : "single.php",
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