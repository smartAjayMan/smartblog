<?php include('../../path.php') ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Dashboard</title>
        <!-- header css -->
        <link rel="stylesheet" href="../../blog/style/GBody/header_style.css">
        <!-- Gbody css -->
        <link rel="stylesheet" href="../../blog/style/GBody/mainBody.css">
        <!-- footer css -->
        <link rel="stylesheet" href="../../blog/style/GBody/footer_style.css">
        <!-- multi color css -->
        <link rel="stylesheet" href="../../blog/style/GBody/multi-color.css">
    </head>
    <style>  #formshowHide{   display: none;     }  </style>
    <body class="bc-aquamarine">
    <!-- header start -->   
  <?php include(ROOT_PATH.'/blog/include/header.php') ?> 
    <!-- Gbody start -->
     <div class="main-container">
         <h1 class="t-c m-t">Dashboard</h1>   
         <div class="message m-a" id="messageSuccess" style="width: 86%;">   
            <?php if (isset($_SESSION['message'])) { echo $_SESSION['message']; unset($_SESSION['message']); } ?>             
         </div>  
         <?php if (isset($_SESSION['logining']) && $_SESSION['logining'] === true): ?>
           <p id="userId" data-userid="<?php echo $_SESSION['id'] ?>" style="display:none"></p> 
            <div class="form-control m-b" id="formshowHide">           
                
            </div>
            <div class="dash-container m-b" id="datashowhide">
                <table class="dash-control t-c m-t" id="DashboardData">                   
                </table>
            </div>
         <?php else: ?>
            <div  class="flexible coloums bc-white form-c m-b m-a" style="margin-top: 4%; width:20%">
                    <h2 class="t-c m-b">Login Please...</h2>                                
            </div>
        <?php endif; ?>
    </div>         
    <script src="../../blog/style/jQuery/jquery-3.6.0.min.js"></script>
    <script src="../../blog/style/jQuery/All-content.js"></script>
    <script>
      $(document).ready(function () {
        let userid = $('#userId').data('userid');
        // User Dashboard Fetch posts list 
        function loadPage(){
          $.ajax({
            url : "../../controller/posts.php",
            method : "POST",
            data : {userId: userid},
            success : function (data) {
                $('#DashboardData').html(data);
            }
          });
        }  
        loadPage(); 
        // published And unpublished   
        $(document).on('click', '.published', function (e) {
          e.preventDefault();
          if (confirm(`Are You Sure Change Published`)) {
             let published = $(this).attr('name');
             let postsId = $(this).data('published');
            $.ajax({
                url : "../../controller/posts.php", 
                method : "POST",
                data : {postsId:postsId, published:published}, 
                success : function (data) {
                  if (data === 'success') {
                    loadPage();
                    $('#messageSuccess').html(`<li class="alert-message bc-green-alert" style="text-transform: capitalize;">Posts <b>${published}</b> In Changed.</li>`);
                  }
                }
             });
            }
         });
        // Posts Delete function   
        $(document).on('click', '.delPosts', function (e) {
          e.preventDefault();
           if (confirm('Are You Sure Delete Post')) {
            let published = $(this).attr('name');
            let postsId = $(this).data('del');
            $.ajax({
                url : "../../controller/posts.php", 
                method : "POST",
                data : {postsId:postsId, published:published}, 
                success : function (data) {
                  if (data === 'success') {
                     loadPage();
                     $('#messageSuccess').html('<li class="alert-message bc-green-alert">Posts Deleted Success.</li>');
                  }
                }
             });
            }
        });
        // Posts Edit function        
        $(document).on('click', '.editPosts', function (e) {
          e.preventDefault();
            $('#formshowHide').show();
            $('#datashowhide').hide();
            let published = $(this).attr('name');
            let postsId = $(this).data('edit');
            $.ajax({
                url : "../../controller/posts.php", 
                method : "POST",
                data : {postsId:postsId, published:published}, 
                success : function (data) {
                  $('#formshowHide').html(data);
                }
           });
        });
        // posts edit data send function code
        $(document).on('submit', '#postsEdit', function (e) {
          e.preventDefault();
          let text = $('#body').val();
              text = text.replace(/  /g, "[sp][sp]"); // space    
              text = text.replace(/\n/g, "[nl]"); // new line                              
              condition = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig; // a tag using
              text = text.replace(condition, "<a href='$1' target='_blank'>$1</a>");
          let formdata = new FormData(this);
              formdata.append('body', text);
              formdata.append('published', 'postsEditSend');
           $.ajax({
                url : "../../controller/posts.php", 
                method : "POST",
                data : formdata,
                contentType : false,
                processData : false,
                success : function (data) {
                  $('#formErrors').html(data);
                }
           });
        });
      });
    </script>
  </body>
 </html>