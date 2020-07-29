<?php 
session_start();
require_once '../db/connection.php';
require_once './comment.inc';

$model = new GoodsCommentModel();

$model -> getForm();

switch ($model->getCommentCmd()) {
    case 'list':
        commentList();
        break;
    case 'delete':
        commentDelete();
        break;
    case 'insert':
        commentInsert();
        break;
    case 'update':
        commentUpdate();
        break;
}

function commentUpdate(){
    global $model;
    
    $sql = " UPDATE goods_comment SET goods_comment_content = '{$model->getCommentContent()}', goods_comment_updatedate = NOW() WHERE goods_comment_no = {$model->getCommentNo()}";
    connection($sql);
    
    $sql = " SELECT * FROM goods_comment WHERE goods_comment_no = {$model->getCommentNo()}";
    $result = connection($sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        
    }
    header('Content-Type: application/json; charset=utf8');
    $jsonData = json_encode(array("result"=>$row), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $jsonData;
}
/**
 * コメント登録
 */
function commentInsert(){
    global $model;

    $sql = " INSERT INTO goods_comment(goods_no, goods_comment_no, user_no, goods_comment_content, goods_comment_createdate)
                             VALUES({$model->getGoodsNo()}, NULL, {$model->getUserNo()}, '{$model->getCommentContent()}', NOW())";
    connection($sql) ? print true : print false;

}

/**
 * コメント削除
 */
function commentDelete(){
    global $model;
    $sql = "DELETE FROM goods_comment WHERE goods_comment_no = {$model->getCommentNo()}";
    
    connection($sql) ? print $_SESSION['userInfo']['user_no'] : print "";
}

/**
 * コメントリスト
 */
function commentList(){
    global $model;
    
    $sql = " SELECT a.*, userinfo.user_id FROM (
                    SELECT goods_comment.*  FROM goods INNER JOIN goods_comment ON goods.goods_no = goods_comment.goods_no
                    ) a INNER JOIN userinfo ON a.user_no = userinfo.user_no WHERE goods_no = {$model->getGoodsNo()} ORDER BY goods_comment_createdate DESC ";
    
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
?>