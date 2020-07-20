<?php 
$conn = mysqli_connect(
    'localhost',
    'root',
    '123456',
    'fleamarket'
    );

/**
 * DB接続チェックする
 */
if(mysqli_connect_errno()){
    $errorMsg = "DB接続に失敗しました。";
    $path = "index";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}
$chatData = array(
    'fromID' => mysqli_real_escape_string($conn, $_POST['fromID']),
    'toID' => mysqli_real_escape_string($conn, $_POST['toID']),
    'chatContent' => mysqli_real_escape_string($conn, $_POST['chatContent'])
);


$sql = "
        SELECT * FROM chat
        ";
$result = mysqli_query($conn, $sql);
$chat_room=0;
$numdata = array();
if(mysqli_num_rows($result) > 0){
    
    $roomcheck = true;
    while($row = mysqli_fetch_assoc($result)){
        $numdata[] = $row['chat_room'];
        if(($row['fromID'] == $chatData['fromID'] && $row['toID'] == $chatData['toID']) || ($row['fromID'] == $chatData['toID'] && $row['toID'] == $chatData['fromID'])){
            
            $chat_room = $row['chat_room'];
            $roomcheck = false;
            break;
        }
        
    }
    
    $chat_room = max($numdata);
    if($roomcheck){
       $chat_room++;     
    }
}

$sql = "
        INSERT INTO
            chat
                (
                chatID,
                fromID,
                toID,
                chatContent,
                chatTime,
                chat_room        
                )
            VALUES
                (
                NULL,
                '{$chatData['fromID']}',
                '{$chatData['toID']}',
                '{$chatData['chatContent']}',
                NOW(),
                {$chat_room}
                )
        ";

mysqli_query($conn, $sql);

$chatId = mysqli_insert_id($conn);
$sql = "
    SELECT
        *
        FROM
            chat
        WHERE
            chatID = {$chatId}
";


$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
   $row = mysqli_fetch_assoc($result);
}
mysqli_free_result($result);
mysqli_close($conn);

header('Content-Type: application/json; charset=utf8');
$jsonData = json_encode(array("result"=>$row), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
echo $jsonData;


?>