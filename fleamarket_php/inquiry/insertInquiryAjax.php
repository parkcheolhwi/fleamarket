<?php 
$conn = mysqli_connect(
    'localhost',
    'root',
    '123456',
    'fleamarket'
    );

if(mysqli_connect_errno()){
    $errorMsg = "DB接続に失敗しました。";
    $path = "index";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}

$insertData = array(
    'userNo' => mysqli_real_escape_string($conn, $_POST['userNo']),
    'userId' => mysqli_real_escape_string($conn, $_POST['userId']),
    'userPhoneNumber' => mysqli_real_escape_string($conn, $_POST['userPhoneNumber']),
    'userEmail' => mysqli_real_escape_string($conn, $_POST['userEmail']),
    'inquiryTitle' => mysqli_real_escape_string($conn, $_POST['inquiryTitle']),
    'inquiryContent' => mysqli_real_escape_string($conn, $_POST['inquiryContent']),
);

$sql = "
    INSERT INTO
        inquiryinfo
        (
        inquiry_no,
        user_id,
        user_no,
        user_phone,
        user_email,
        inquiry_title,
        inquiry_content,
        inquiry_date
        )
        VALUES
        (
        NULL,
        '{$insertData['userId']}',
        {$insertData['userNo']},
        '{$insertData['userPhoneNumber']}',
        '{$insertData['userEmail']}',
        '{$insertData['inquiryTitle']}',
        '{$insertData['inquiryContent']}',
        NOW()
        )
    ";
        
        if(mysqli_query($conn, $sql)){
            echo true;
        }else{
            echo false;
        }

?>