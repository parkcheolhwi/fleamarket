<?php 
class CartModel{
    private $goodsNo;           #商品番号
    private $cartNo;            #カート番号
    private $userNo;            #ユーザー番号
    private $cartCmd;
    
    private $cartList;          #カートリスト
    /**
     * コンストラクタ
     */
    public function __construct(){
        $this -> init();
    }
    
    private function init(){
        $this -> goodsNo = array();
        $this -> cartNo = '';
        $this -> userNo = '';
        $this -> cartCmd = '';
        $this -> cartList = array();
    }
    
    /**
     * Setter, Getter関数
     * @param $goodsNo
     */
    public function setGoodsNo($goodsNo){
        $this -> goodsNo = $goodsNo;
    }
    public function setCartNo($cartNo){
        $this -> cartNo = $cartNo;
    }
    public function setUserNo($userNo){
        $this -> userNo = $userNo;
    }
    public function setCartCmd($cartCmd){
        $this -> cartCmd = $cartCmd;
    }
    public function setCartList($cartList){
        $this -> cartList = $cartList;
    }
    
    public function getGoodsNo(){
        return $this -> goodsNo;
    }
    public function getCartNo(){
        return $this -> cartNo;
    }
    public function getUserNo(){
        return $this -> userNo;
    }
    public function getCartCmd(){
        return $this -> cartCmd;
    }
    public function getCartList(){
        return $this -> cartList;
    }
    
    /**
     * フォームからデータ取得
     */
    public function getForm(){
        if(isset($_POST['goodsNo'])) $this -> setGoodsNo($_POST['goodsNo']);
        if(isset($_POST['userNo'])) $this -> userNo = $_POST['userNo'];
        if(isset($_POST['cartNo'])) $this -> cartNo = $_POST['cartNo'];
        if(isset($_POST['cartCmd'])) $this -> cartCmd = $_POST['cartCmd'];
    }
    
    public function processing(){
        $this -> cartList();
    }
    
    private function cartList(){
        $sql = " SELECT cart.cart_no, cart.user_no, cart.cart_createdate, goods.*, goods_file.goods_filerealname FROM cart 
                    INNER JOIN goods ON cart.goods_no = goods.goods_no
                    LEFT JOIN goods_file ON goods.goods_no = goods_file.goods_no
                    WHERE cart.user_no = {$_SESSION['userInfo']['user_no']}
                    GROUP BY goods.goods_no ";
        $result = connection($sql);
        $list = array();
        if(mysqli_num_rows($result) > 0){
            while($data = mysqli_fetch_assoc($result)){
                $list[] = $data;
            }
        }
        
        $this -> setCartList($list);
    }
}
?>