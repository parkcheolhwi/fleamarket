<?php 

require_once '../db/connection.php';
require_once './inquiry.inc';

$model = new InquiryModel();

$model -> getForm();

switch($model->getInquiryCmd()){
    case 'insert':
        insert();
        break;
    case 'detail':
        detail();
        break;
    case 'reply':
        reply();
        break;
}


/**
 * お問い合わせ登録
 */
function insert(){
    global $model;
    $sql = " INSERT INTO inquiryinfo(inquiry_no, user_id, user_no, user_phone, user_email, inquiry_title, inquiry_content, inquiry_date)
                            VALUES(NULL, '{$model->getUserId()}', {$model->getUserNo()}, '{$model->getUserPhoneNumber()}', '{$model->getUserEmail()}', '{$model->getInquiryTitle()}', '{$model->getInquiryContent()}', NOW())";
    connection($sql) ? print true : print false;
}

/**
 *　お問い合わせ番号のデータをリターンする
 */
function detail(){
    global $model;
    
    $sql = " SELECT * FROM inquiryinfo WHERE inquiry_no = {$model->getInquiryNo()} ";
    
    $result = connection($sql);
    $data = mysqli_fetch_assoc($result);
    header('Content-Type: application/json; charset=utf8');
    $jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    
    echo $jsonData;
}

/**
 * 該当するお問い合わせ番号に返信する
 */
function reply(){
    global $model;
    
    $sql = " UPDATE inquiryinfo SET inquiry_replycheck = '1', inquiry_replycontent = '{$model->getReplyContent()}', inquiry_replydate = NOW() 
                            WHERE inquiry_no = {$model->getInquiryNo()} ";
    connection($sql) ? print true : print false;
}
?>