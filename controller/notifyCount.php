<?php

include('../path.php');
include(ROOT_PATH.'/blog/connect/db.php');
if (isset($_POST['n_user_id']) && !empty($_POST['n_user_id'])) {
    $user_id = $_POST['n_user_id'];
    $SubNoty_sql = "SELECT COUNT(*) FROM notifications n
    INNER JOIN posts p ON p.posts_id = n.notify_p_id 
    INNER JOIN users u ON u.id = p.user_id
    WHERE p.published=1 AND n.notify_u_id=?";
    $stmt = $conn->prepare($SubNoty_sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $sub_result = $stmt->get_result();
    $sub = mysqli_fetch_array($sub_result);

    $comment_sql = "SELECT COUNT(*) FROM posts p
    INNER JOIN comments c ON p.posts_id = c.post_id 
    INNER JOIN users u ON u.id = c.user_id
    WHERE c.status=0 AND p.user_id=?";
    $stmt = $conn->prepare($comment_sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $comm_result = $stmt->get_result();
    $comm = mysqli_fetch_array($comm_result);
    $result = [
        'count' => $sub[0] + $comm[0]
    ];
    echo json_encode($result);
}else {
    $result = [
        'count' => '!'
    ];
    echo json_encode($result);
}