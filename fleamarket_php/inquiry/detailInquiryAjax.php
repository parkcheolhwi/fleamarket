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

$inquiryNo = mysqli_real_escape_string($conn, $_POST['inquiryNo']);
$sql = "
    SELECT
        *
        FROM
            inquiryinfo
        WHERE
            inquiry_no = {$inquiryNo}
    ";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
header('Content-Type: application/json; charset=utf8');
$jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

echo $jsonData;
?>