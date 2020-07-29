<?php 
class GoodsCommentModel{
    private $goodsNo;               #商品番号
    private $commentNo;             #コメント番号
    private $commentContent;        #コメント内容            
    private $userNo;                #ユーザー番号
    private $commentCmd;
    /**
     * コンストラクタ
     */
    public function __construct(){
        $this -> init();
    }
    
    private function init(){
        $this -> goodsNo = '';
        $this -> commentNo = '';
        $this -> commentContent = '';
        $this -> userNo = '';
        $this -> commentCmd = '';
    }
    
    /**
     * Setter, Getter関数
     * @param $goodsNo
     */
    public function setGoodsNo($goodsNo){
        $this -> goodsNo = $goodsNo;
    }
    public function setCommentNo($commentNo){
        $this -> commentNo = $commentNo;
    }
    public function setCommentContent($commentContent){
        $this -> commentContent = $commentContent;
    }
    public function setUserNo($userNo){
        $this -> userNo = $userNo;
    }
    public function setCommentCmd($commendCmd){
        $this -> commentCmd = $commendCmd;
    }
    public function getGoodsNo(){
        return $this -> goodsNo;
    }
    public function getCommentNo(){
        return $this -> commentNo;
    }
    public function getCommentContent(){
        return $this -> commentContent;
    }
    public function getUserNo(){
        return $this -> userNo;
    }
    public function getCommentCmd(){
        return $this -> commentCmd;
    }
    
    /**
     * フォームからデータ取得
     */
    public function getForm(){
        if(isset($_POST['goodsNo'])) $this -> goodsNo = $_POST['goodsNo'];
        if(isset($_POST['goodsCommentContent'])) $this -> commentContent = $_POST['goodsCommentContent'];
        if(isset($_POST['commentNo'])) $this -> commentNo = $_POST['commentNo'];
        if(isset($_POST['userNo'])) $this -> userNo = $_POST['userNo'];
        if(isset($_POST['commentCmd'])) $this -> commentCmd = $_POST['commentCmd'];
    }
    
}
?>  