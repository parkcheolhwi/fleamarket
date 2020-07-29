<?php 
class BuyModel{
    private $goodsNo;               #商品番号
    private $nonUserName;           #非会員名前
    private $nonUserPassword;       #非会員パスワード
    private $nonUserEmail;          #非会員メール
    private $nonUserAddress;        #非会員住所
    private $buyCmd;
    
    private $buyList;               #購入リスト
    
    /**
     * コンストラクタ
     */
    public function __construct(){
        $this -> init();
    }
    
    private function init(){
        $this -> goodsNo = array();
        $this -> nonUserName = '';
        $this -> nonUserPassword = '';
        $this -> nonUserEmail = '';
        $this -> nonUserAddress = '';
        $this -> buyCmd = '';
        $this -> buyList = array();
    }
    
    /**
     * Setter, Getterメソッド
     * @param $goodsNo
     */
    public function setGoodsNo($goodsNo){
        $this -> goodsNo = $goodsNo;
    }
    public function setNonUserName($nonUserName){
        $this -> nonUserName = $nonUserName;
    }
    public function setNonUserPassword($nonUserPassword){
        $this -> nonUserPassword = $nonUserPassword;
    }
    public function setNonUserEmail($nonUserEmail){
        $this -> nonUserEmail = $nonUserEmail;
    }
    public function setNonUserAddress($nonUserAddress){
        $this -> nonUserAddress = $nonUserAddress;
    }
    public function setBuyCmd($buyCmd){
        $this -> buyCmd = $buyCmd;
    }
    public function setBuyList($buyList){
        $this -> buyList = $buyList;
    }
    
    public function getGoodsNo(){
        return $this -> goodsNo;
    }
    public function getNonUserName(){
        return $this -> nonUserName;
    }
    public function getNonUserPassword(){
        return $this -> nonUserPassword;
    }
    public function getNonUserEmail(){
        return $this -> nonUserEmail;
    }
    public function getNonUserAddress(){
        return $this -> nonUserAddress;
    }
    public function getBuyCmd(){
        return $this -> buyCmd;
    }
    public function getBuyList(){
        return $this -> buyList;
    }
    
    /**
     * フォームからデータ取得
     */
    public function getForm(){
        if(isset($_POST['goodsNo'])) $this -> setGoodsNo($_POST['goodsNo']);
        if(isset($_POST['nonUserName'])) $this -> nonUserName = $_POST['nonUserName'];
        if(isset($_POST['nonUserPassword'])) $this -> nonUserPassword = $_POST['nonUserPassword'];
        if(isset($_POST['nonUserEmail'])) $this -> nonUserEmail = $_POST['nonUserEmail'];
        if(isset($_POST['nonUserAddress'])) $this -> nonUserAddress = $_POST['nonUserAddress'];
        if(isset($_POST['buyCmd'])) $this -> buyCmd = $_POST['buyCmd'];
    }
    
    public function processing(){
        if(!isset($_SESSION['userInfo'])){
            $errorMsg = "ログインしてください。";
            $path = "login";
            header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
            exit;
        }
        
        $this -> buyList();
    }
    
    private function buyList(){
        $sql = "
        SELECT
            buy.buy_no,
            buy.user_no,
            buy.goods_no,
            buy.buy_createdate,
            goods.goods_no,
            goods.goods_title,
            goods.goods_price,
            goods.goods_content,
            goods_file.goods_filerealname
            FROM
                buy
                INNER JOIN
                    goods
                ON
                    buy.goods_no = goods.goods_no
                LEFT JOIN
                    goods_file
                    ON
                        goods.goods_no = goods_file.goods_no
            WHERE buy.user_no = {$_SESSION['userInfo']['user_no']}
            GROUP BY
                goods.goods_no
        ";
        
        $result = connection($sql);
        $list = array();
        if(mysqli_num_rows($result)>0){
            while($data = mysqli_fetch_assoc($result)){
                $list[] = $data;
            }
        }
        $this -> setBuyList($list);
        
    }
}
?>