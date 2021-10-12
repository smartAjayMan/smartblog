<?php include('../../path.php') ?>
<?php include(ROOT_PATH.'/blog/connect/db.php')?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Upload</title>
        <!-- header css -->
        <link rel="stylesheet" href="../../blog/style/GBody/header_style.css">
        <!-- Gbody css -->
        <link rel="stylesheet" href="../../blog/style/GBody/mainBody.css">
        <!-- footer css -->
        <link rel="stylesheet" href="../../blog/style/GBody/footer_style.css">
        <!-- multi color css -->
        <link rel="stylesheet" href="../../blog/style/GBody/multi-color.css">
    </head>
    <body class="bc-aquamarine">
    <!-- header start -->   
    <?php include(ROOT_PATH.'/blog/include/header.php') ?>
    <!-- Gbody start -->
     <div class="main-container">           
         <div class="form-control">  
         <?php  if (isset($_SESSION['logining']) && $_SESSION['logining'] === true): ?>            
            <form id="myCreatePosts" class="flexible coloums bc-white form-c m-b" autocomplete="off">
                <h2 class="t-c">Create-Post</h2>
                <div class="message" id="formErrors">                    
                </div>
                <label for="title" class="form-lable">Title</label>
                <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['id'] ?>">
                <input class="form-input" name="title" type="text" id="title">
                <label for="topics" class="form-lable">Topics</label>
                <select name="topics" id="topics" class="m-b">
                    <option value=""></option>
                <?php                  
                    $sql = "SELECT * FROM topics";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($topicData = mysqli_fetch_assoc($result)):
                ?>
                    <option value="<?php echo $topicData['topic_id'] ?>"><?php echo $topicData['topics_name'] ?></option>
                <?php endwhile; ?>
                </select>
                <label for="image" class="form-lable">Image</label>
                <span class="image-preview m-t">
                    <img class="image-upload previewImage" id="" src="../../images/download.png" >
                </span>
                <input class="d-none profileImage" name="images" id="images" type="file">
                <label for="body" class="form-lable m-t">Body</label>
                <textarea class="form-input form-body" id="body" cols="30" rows="0"></textarea>
                <div class="m-t">
                    <input type="checkbox" name="published" id="published"> Published
                </div>
                <button type="submit" id="createPosts" class="signup-btn form-lable">Submit</button>              
            </form>
         <?php else: ?>
            <div  class="flexible coloums bc-white form-c m-b" style="margin-top: 20%;">
                <h2 class="t-c m-b">Login Please...</h2>                                
            </div>
         <?php endif; ?>
       </div>
    </div>         
    <script src="../../blog/style/jQuery/jquery-3.6.0.min.js"></script>
    <script src="../../blog/style/jQuery/All-content.js"></script>
    <script>
       $(document).ready(function () {
           $('#myCreatePosts').submit(function (e) {
               e.preventDefault();
               let text = $('#body').val();
                   text = text.replace(/  /g, "[sp][sp]"); // space    
                   text = text.replace(/\n/g, "[nl]"); // new line                              
                   condition = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig; // a tag using
                   text = text.replace(condition, "<a href='$1' target='_blank'>$1</a>");
               let formdata = new FormData(this);
                   formdata.append('body', text);
                   formdata.append('postsCreate', 'key');
               $.ajax({
                     url : "../../controller/posts.php",
                     method : "POST",
                     processData : false,
                     contentType : false,
                     data : formdata,
                     success : function (data) {
                        $('#formErrors').html(data);
                     }
               });
           });           
       });
    </script>
  </body>
 </html>   