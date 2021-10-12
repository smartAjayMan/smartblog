<?php
    include('../connect/db.php');
    $email = "";
    $password = "";
    $errors = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        echo $errors['email'] = '<li class="alert-message bc-red-alert">Enter The Email</li> ';
    }

    if (empty($password)) {
        echo $errors['password'] = '<li class="alert-message bc-red-alert">Enter The Password</li> ';
    }

    if (count($errors) === 0) {
        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result)>0) {
          $row = mysqli_fetch_assoc($result);
          if (password_verify($password, $row['password'])) {
             session_start();
             $_SESSION['logining'] = true;
             $_SESSION['id'] = $row['id'];
             $_SESSION['images'] = $row['images'];
             $_SESSION['username'] = $row['username'];
             $_SESSION['email'] = $row['email'];
             $_SESSION['channel'] = $row['channel_name'];
             $_SESSION['desc'] = $row['description'];
             echo '<script> window.location.href="http://localhost/smartblog/index.php";</script>';

            exit();
             
            
             
          }else {
            echo $errors = '<li class="alert-message bc-red-alert">Wrong Password</li>';
          }
          
        }else {
            echo $errors = '<li class="alert-message bc-red-alert">Wrong Email</li>';
        }

    }

}

?>