<?php
    include('../blog/connect/db.php');
     $id = "";
     $topic_id = "";
     $topic_name = "";
     $desc = "";
     $allTopics = "";
     $errors = array();
    //  insert topics codding
    if (isset($_POST['createTopics'])) {
        $id = $_POST['id'];
        $topic_name = $_POST['topic'];
        $desc = $_POST['body'];    
        if (empty($topic_name)) {
            echo $errors['topic'] = '<li class="alert-message bc-red-alert">Enter Topic Name</li>';
        }
        if (empty($desc)) {
            echo $errors['body'] = '<li class="alert-message bc-red-alert">Enter Description</li>';
        }
        $sql = "SELECT * FROM topics WHERE topics_name = ? OR description = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss',  $topic_name, $desc);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result)>0) {
            echo $errors['topic'] = '<li class="alert-message bc-red-alert">Already Data Exists.</li>'; 
        }
        if (count($errors) === 0) {
                $sql = "INSERT INTO topics SET users_id = ?, topics_name = ?, description = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('iss', $id, $topic_name, $desc);
                $result = $stmt->execute();
                if ($result === true) {
                    session_start();
                    $_SESSION['message'] = '<li class="alert-message bc-green-alert">Successfully Uploaded.</li>';
                    echo '<script>window.location.href = "http://localhost/smartblog//logged/topics/dashboard.php";</script>';
                }else {
                    echo $errors['topic'] = '<li class="alert-message bc-red-alert">Failed Data Uploaded.</li>';
                }
        }
    }
    // fetch topics codding
    if (isset($_POST['topicFetch'])) {
        $id = $_POST['topicFetch'];
        $sql = "SELECT * FROM topics WHERE users_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo ' <tr class="dash-tr">                    
            <th colspan="5">
                <div class="bc-gray user-con" style="display: flex; flex-direction: column;">
                    <a href="create.php">
                    <i class="fa fa-plus-circle" style="font-size:2rem;color: black;"></i>                              
                    </a>
                    <a href="../posts/dashboard.php">
                    Your Dashboard                            
                    </a>
                </div>
                </th>
            </tr>
        <tr class="dash-tr">
        <th>Sr No</th>
        <th>Topics Name</th>
        <th class="dash-title t-c">Description</th>
        <th>Date</th>
        <th>Action</th>
        </tr>';
        if (mysqli_num_rows($result)>0) {
            $num = 0;
            while ($topics = mysqli_fetch_assoc($result)) {
                $num = $num +1;
                echo '<tr class="dash-tr">
                        <td>'.$num.' )</td>
                        <td class="dash-views">
                            <b class="views-count">'.$topics['topics_name'].'</b>
                        </td>
                        <td class="dash-title">
                        '.$topics['description'].'                  
                        </td>                   
                        <td>'.date('j F Y', strtotime($topics['date'])).'</td>                                         
                        <td class="cr-green topics_edit" data-topic_id="'.$topics['topic_id'].'">Edit</td>                     
                    </tr>';
            }   
        }else {
             echo '<tr class="dash-tr">
                    <td colspan="5">NOT TOPICS.</td>                                
                 </tr>';
        }    
    }
    // Edit topics codding 
    if (isset($_POST['topicEdit'])) {      
       $topic_id = $_POST['topicEdit'];
       $sql = "SELECT * FROM topics WHERE topic_id = ?";
       $stmt = $conn->prepare($sql);
       $stmt->bind_param('i', $topic_id);
       $stmt->execute();
       $result = $stmt->get_result();
       while ($topics = mysqli_fetch_assoc($result)) {
            $data = [
                'topics' => $topics['topics_name'],
                'desc' => $topics['description'],
                'topic_id' => $topics['topic_id']
            ];
            echo json_encode($data);
       }        
    }    
    // edited data send codding for topics
    if (isset($_POST['edit_topics'])) {
        $id = $_POST['t_id'];
        $topic_name = $_POST['t_name'];
        $desc = $_POST['desc'];   
        if (empty($topic_name)) {
            echo $errors['t_name'] = '<li class="alert-message bc-red-alert">Enter Topic Name</li>';
        }
        if (empty($desc)) {
            echo $errors['desc'] = '<li class="alert-message bc-red-alert">Enter Description</li>';
        }
        $sql = "SELECT * FROM topics WHERE topics_name = ? OR description = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss',  $topic_name, $desc);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result)>0) {
            echo $errors['t_name'] = '<li class="alert-message bc-red-alert">Already Data Exists.</li>'; 
        }
        if (count($errors) === 0) {
                $sql = "UPDATE topics SET  topics_name = ?, description = ? WHERE topic_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssi', $topic_name, $desc, $id);
                $result = $stmt->execute();
                if ($result === true) {
                    session_start();
                    $_SESSION['message'] = '<li class="alert-message bc-green-alert"> Edited Successfully.</li>';
                    echo '<script>window.location.reload(true);</script>';
                }else {
                    echo $errors['t_name'] = '<li class="alert-message bc-red-alert">Failed Data Uploaded.</li>';
                }
         }        
    }    
    $conn->close();
    exit();
  
?>