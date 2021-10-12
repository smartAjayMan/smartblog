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
    <style>  #topicsEdit{  display: none;  } </style>
    <body class="bc-aquamarine">
    <!-- header start -->   
    <?php include(ROOT_PATH.'/blog/include/header.php') ?> 
    <!-- Gbody start -->
     <div class="main-container">
         <h1 class="t-c m-t">Topics List</h1>  
         <div class="message m-a" id="messageSuccess" style="width: 86%;">   
            <?php if (isset($_SESSION['message'])) { echo $_SESSION['message']; unset($_SESSION['message']); } ?>             
         </div>   
        <?php if (isset($_SESSION['logining']) && $_SESSION['logining'] === true): ?>
          <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['id'] ?>">
          <div class="form-control" id="topicsEdit">
          <form id="myformTopics" class="flexible coloums bc-white form-c" autocomplete="off">
              <div class="flexible">
              <h2 class="t-c m-a">Edit-Topic</h2> 
                <p class="close-topic bc-red t-c" style="width:4%; font: size 1.4rem;"> X </p>
              </div>
              <div class="message" id="formErrors">
              </div>
              <label for="topic" class="form-lable">Topic Name</label>
              <input class="form-input" name="topic_id" type="hidden" id="topic_id">
              <input class="form-input" name="topic" type="text" id="topic">
              <label for="body" class="form-lable m-t">Description</label>
              <textarea class="form-input form-body" name="body" id="body" cols="30"  rows="0"></textarea>
              <button type="submit" name="edit_topics" id="edit_topics" class="signup-btn form-lable">Save</button>              
          </form>           
          </div>
          <div class="dash-container">
              <table class="dash-control t-c m-t m-b" id="topics_shows">                                      
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
        //  fetch data
          let id = $('#id').val();
          $.ajax({
              url : "../../controller/topics.php",
              method : 'POST',
              data : {topicFetch:id},
              success : function (data) {
                $('#topics_shows').html(data);
              }
          });
          // topics page close
          $(document).on('click', '.close-topic', function (e) {
            e.preventDefault();
            $('#topicsEdit').hide();
            $('#topics_shows').show();    
          });
          // edit data fetch
          $(document).on('click', '.topics_edit', function (e) {
            e.preventDefault();
            $('#topicsEdit').show();
            $('#topics_shows').hide();            
            let topic_id = $(this).data('topic_id');
              $.ajax({
                url : "../../controller/topics.php",
                method : 'POST',
                data : {topicEdit:topic_id},
                success : function (data) {
                  res = JSON.parse(data);
                  $('#topic').attr('value', res.topics);
                  $('#topic_id').attr('value', res.topic_id);
                  $('#body').html(res.desc);
                }
             });
          });
          // edited send data
          $(document).on('click', '#edit_topics', function (e) {
            e.preventDefault();
            let btn = $(this).attr('name');
            let topic_id = $('#topic_id').val();
            let topic_name = $('#topic').val();
            let desc = $('#body').val();
            $.ajax({
                url : "../../controller/topics.php",
                method : 'POST',
                data : {
                  edit_topics :btn,
                  t_id : topic_id,
                  t_name :topic_name,
                  desc : desc
                },
                success : function (data) {
                  $('#formErrors').html(data);
                }
            });
          });
      });
    </script>
  </body>
 </html>