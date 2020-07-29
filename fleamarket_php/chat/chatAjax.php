<?php 
session_start();
require_once '../db/connection.php';
require_once './chat.inc';

$model = new ChatModel();
$model -> getForm();

switch($model->getChatCmd()){
    case 'insert': #チャットルーム作る
        chatInsert();
        break;
    case 'list':
        chatList();
        break;
    case 'chatBox':
        chatBox();
        break;
    case 'contentInsert':
        contentInsert();
        break;
}

function contentInsert(){
    global $model;
    $sql = "
        SELECT * FROM chat
        ";
    $result = connection($sql);
    $chat_room=0;
    $numdata = array();
    if(mysqli_num_rows($result) > 0){
        $roomcheck = true;
        while($row = mysqli_fetch_assoc($result)){
            $numdata[] = $row['chat_room'];
            if(($row['fromID'] == $model->getFromId() && $row['toID'] == $model->getToId()) || ($row['fromID'] == $model->getToId() && $row['toID'] == $model->getFromId())){
                $chat_room = $row['chat_room'];
                $roomcheck = false;
                break;
            }
        }
        
        $chat_room = max($numdata);
        if($roomcheck) $chat_room++;
        
    }
    
    $sql = " INSERT INTO chat(chatID, fromID, toID, chatContent, chatTime, chat_room)
                        VALUES(NULL, '{$model->getFromId()}', '{$model->getToId()}', '{$model->getChatContent()}', NOW(), {$chat_room})";
    $chatId = getIdConnection($sql);
    
    $sql = " SELECT * FROM chat WHERE chatID = {$chatId} ";
     
    $result = connection($sql);
    if(mysqli_num_rows($result) > 0){$row = mysqli_fetch_assoc($result);}

    header('Content-Type: application/json; charset=utf8');
    $jsonData = json_encode(array("result"=>$row), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $jsonData;
                
}

function chatBox(){
    global $model;
    #一番最後送ったメッセージの番号を表示する
    $sql = " SELECT * FROM chat WHERE chatID
                IN (SELECT MAX(chatID) FROM chat WHERE toID='{$model->getFromId()}' OR fromID='{$model->getFromId()}' GROUP BY chat_room) ORDER BY chatTime DESC ";
    $result = connection($sql);
    $data = array();
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
    }    
    header('Content-Type: application/json; charset=utf8');
    $jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $jsonData;
}

function chatList(){
    global $model;
    #相手とチャットしたリスト表示
    $sql = " SELECT * FROM chat WHERE ((fromID = '{$model->getFromId()}' AND toID = '{$model->getToId()}') OR (fromID = '{$model->getToId()}' AND toID = '{$model->getFromId()}')) ORDER BY chatTime ";
    
    $result = connection($sql);
    $data = array();
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
    }

    header('Content-Type: application/json; charset=utf8');
    $jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $jsonData;
}

function chatInsert(){
    global $model;
    $sql = " SELECT * FROM chat ";
    
    $result = connection($sql);
    $chat_room=0;
    $numdata = array();
    if(mysqli_num_rows($result) > 0){
        
        $roomcheck = true;
        while($row = mysqli_fetch_assoc($result)){
            $numdata[] = $row['chat_room'];
            if(($row['fromID'] == $model->getFromId() && $row['toID'] == $model->getToId()) || ($row['fromID'] == $model->getToId() && $row['toID'] == $model->getFromId())){
                $chat_room = $row['chat_room'];
                $roomcheck = false;
                break;
            }
            
        }
        
        #チャットルームがないと１増やして登録する
        $chat_room = max($numdata);
        if($roomcheck){
            $chat_room++;
            $sql = " INSERT INTO chat(chatID, fromID, toID, chatTime, chat_room) VALUES(NULL, '{$model->getFromId()}', '{$model->getToId()}', NOW(), {$chat_room}) ";
            connection($sql);
        }
    }else{
        $sql = " INSERT INTO chat(chatID, fromID, toID, chatTime, chat_room) VALUES(NULL, '{$model->getFromId()}', '{$model->getToId()}', NOW(), {$chat_room}) ";
        connection($sql);
    }
    
    $sql = " SELECT * FROM chat WHERE ((fromID = '{$model->getFromId()}' AND toID = '{$model->getToId()}') OR (fromID = '{$model->getToId()}' AND toID = '{$model->getFromId()}')) ORDER BY chatTime ";
    
    $result = connection($sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
    }

    header('Content-Type: application/json; charset=utf8');
    $jsonData = json_encode(array("result"=>$row), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $jsonData;
}

?>