<?php 
session_start();
require_once '../db/connection.php';
require_once './buy.inc';


$model = new BuyModel();

$model -> getForm();

switch($model->getBuyCmd()){
    case 'insert': #会員購入
        insert();
        break;
    case 'nonUserBuy': # 非会員購入
        nonUserBuy();
        break;
    case 'nonUserBuyList': # 非会員購入リスト
        nonUserBuyList();
        break;
}

function insert(){
    global $model;
    
    #販売完了された商品のチェック
    $sql = " SELECT * FROM goods WHERE goods_onsale = '1' AND goods_no IN ( ";
    for($i = 0; $i < count($model->getGoodsNo()); $i++){
        $sql .= $model->getGoodsNo()[$i];
        if($i != count($model->getGoodsNo())-1) $sql .= " , ";
    }
    $sql .= " ) ";
    
    # 11販売完了された商品エラー
    $result = connection($sql);
    if(mysqli_num_rows($result) > 0){
        echo "11";
        return;
    }
    # ログインエラー
    if(!isset($_SESSION['userInfo'])){
        echo "8";
        return;
    }
    
    # 商品の購入
    $sql =" INSERT INTO buy(buy_no, user_no, goods_no, buy_createdate) VALUES ";    
    for($i = 0; $i < count($model->getGoodsNo()); $i++){
        $sql .= " (NULL, {$_SESSION['userInfo']['user_no']}, {$model->getGoodsNo()[$i]}, NOW()) ";
        
        if($i != count($model->getGoodsNo()) -1) $sql .=", ";
    }
    
    #売られた商品の販売完了する
    if(connection($sql)){
        $sql = " UPDATE goods SET goods_onsale = '1' WHERE goods_no in ( ";
        for($i = 0; $i < count($model->getGoodsNo()); $i++){
            $sql .= " {$model->getGoodsNo()[$i]} ";
            ($i != count($model->getGoodsNo()) -1) ? $sql .="," : $sql .=")";
        }
        connection($sql);
        
        # カートリストから削除する
        $sql = " DELETE FROM cart WHERE goods_no in ( ";
        for($i = 0; $i < count($model->getGoodsNo()); $i++){
            $sql .= " {$model->getGoodsNo()[$i]} ";
            ($i != count($model->getGoodsNo()) -1) ? $sql .="," : $sql .=")";
        }
        
        connection($sql) ? print "1" : print "9";
    }else{
        echo "9"; # 失敗
    }
}

function nonUserBuy(){
    global $model;
    
    #売り切れ確認
    $sql = " SELECT * FROM goods WHERE goods_onsale = '1' AND goods_no = {$model->getGoodsNo()} ";
    $result = connection($sql);
    if(mysqli_num_rows($result) > 0){
        echo "11";
        return;
    }
    
    
    #非会員登録
    $sql =" INSERT INTO nonuser(nonuser_no, nonuser_name, nonuser_password, nonuser_email, nonuser_address)
                        VALUES(NULL, '{$model->getNonUserName()}', '{$model->getNonUserPassword()}', '{$model->getNonUserEmail()}', '{$model->getNonUserAddress()}')";
    $nonuserNo = getIdConnection($sql);
    #非会員購入
    $sql =" INSERT INTO buy(buy_no, nonuser_no, goods_no, buy_createdate)
                        VALUES(NULL, {$nonuserNo}, {$model->getGoodsNo()}, NOW())";
                
    #商品を売り切れする
    if(connection($sql)){
        $sql = " UPDATE goods SET goods_onsale = '1' WHERE goods_no = {$model->getGoodsNo()} ";
        if(connection($sql))  "1";
    }
}



function nonUserBuyList(){
    global $model;
    
    $sql = " SELECT * FROM nonuser WHERE nonuser_email = '{$model->getNonUserEmail()}' AND nonuser_password = '{$model->getNonUserPassword()}' ";
    $result = connection($sql);
    #履歴があるとリストを表示する
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $id = $data['nonuser_no'];
        $sql = " SELECT goods.*, buy.buy_createdate, goods_file.goods_filerealname, nonuser.nonuser_name FROM buy
                    INNER JOIN goods ON buy.goods_no = goods.goods_no
                    INNER JOIN nonuser ON buy.nonuser_no = nonuser.nonuser_no
                    LEFT JOIN goods_file ON goods.goods_no = goods_file.goods_no
                    WHERE nonuser.nonuser_no = {$id}
                    GROUP BY goods.goods_no ";
        $result = connection($sql);
        if(mysqli_num_rows($result) > 0){
            $data = mysqli_fetch_assoc($result);
            header('Content-Type: application/json; charset=utf8');
            $jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
            echo $jsonData;
        }
    }else{
        echo "9";
    }
    
}
?>