<?php 
session_start();
require_once '../db/connection.php';
require_once './cart.inc';

$model = new CartModel();

$model -> getForm();

switch($model->getCartCmd()){
    case 'insert':
        insert();
        break;
    case 'delete':
        delete();
        break;
    case 'buyCheck':
        buyCheck();
        break;
}

/**
 * カートに登録
 */
function insert(){
    global $model;
    # ログインチェック
    if(!isset($_SESSION['userInfo'])){
        echo "8";
        return;
    }
    
    #売り切れの商品チェック
    $sql = " SELECT * FROM goods WHERE goods_onsale = '1' AND goods_no = {$model->getGoodsNo()} ";
    $result = connection($sql);
    if(mysqli_num_rows($result) > 0){
        echo "11";
        return;
    }
    
    # カートにデータがあるとリターンする
    $sql = " SELECT  * FROM  cart WHERE  goods_no = {$model->getGoodsNo()} AND user_no = {$_SESSION['userInfo']['user_no']} ";
    if($result = connection($sql)){
        if(mysqli_num_rows($result) > 0) {
            echo "22";
            return;
        }
    }
    
    # 商品情報を持って来て登録する
    $sql = "  SELECT  *  FROM goods WHERE goods_no = {$model->getGoodsNo()} ";
    if($result = connection($sql)){
        $sql = " INSERT INTO cart(cart_no, user_no, goods_no, cart_createdate)
                            VALUES(NULL, {$_SESSION['userInfo']['user_no']}, {$model->getGoodsNo()}, NOW())";
        connection($sql) ? print "1" : print "9";
    }else{
        echo "9";
    }
}

/**
 * カートリストから削除する
 */
function delete(){
    global $model;
    #カートにデータがあるかチェックする
    $sql = " SELECT  * FROM cart WHERE cart_no = {$model->getCartNo()} ";
    if($result = connection($sql)){
        if(mysqli_num_rows($result) > 0) {
            $sql = " DELETE FROM cart WHERE cart_no = {$model->getCartNo()} ";
            connection($sql) ? print "1" : print "9";
        } else{
            echo "9";
        }
    }
}

/**
 * 購入ボタンを押すとリストチェック
 */
function buyCheck(){
    global $model;
    
    $sql = " SELECT goods.*, goods_file.goods_filerealname FROM goods
                LEFT JOIN goods_file ON goods.goods_no = goods_file.goods_no
                WHERE ";
    for($i = 0; $i < count($model->getGoodsNo()); $i++){
        $sql .= " goods.goods_no = ".$model->getGoodsNo()[$i];
        if($i != count($model->getGoodsNo())-1) $sql .= " OR ";
    }
    $sql .= "  GROUP BY goods.goods_no ";
    
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