<?php 
class GoodsModel{
    
    private $goodsNo;               #商品番号
    private $goodsTitle;            #商品タイトル
    private $goodsContent;          #商品内容
    private $goodsArea;             #商品地域
    private $goodsPrice;            #商品価格
    private $goodsCprice;           #商品手数料
    private $searchGoods;           #商品検索
    private $goodsCreatedate;
    private $goodsUpdatedate;
    private $goodsList;
    
    private $userId;                #ユーザーID
    private $userNo;                #ユーザー番号
    private $userPassword;          #ユーザーパスワード
    
    private $goodsCmd;
    /**
     * コンストラクタ
     */
    public function __construct(){
        $this -> init();
    }
    private function init(){
        $this -> goodsNo = '';
        $this -> goodsTitle = '';
        $this -> goodsContent = '';
        $this -> goodsArea = '';
        $this -> goodsPrice = '';
        $this -> goodsCprice = '';
        $this -> searchGoods = '';
        $this -> goodsCreatedate = '';
        $this -> goodsUpdatedate = '';
        $this -> goodsList = array();
        
        $this -> userId = '';
        $this -> userNo = '';
        $this -> userPassword = '';
        $this -> goodsCmd = '';
    }
    
    
    /**
     * @return multitype:
     */
    public function getGoodsList()
    {
        return $this->goodsList;
    }

    /**
     * @param multitype: $goodsList
     */
    public function setGoodsList($goodsList)
    {
        $this->goodsList[] = $goodsList;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getGoodsCreatedate()
    {
        return $this->goodsCreatedate;
    }

    /**
     * @return string
     */
    public function getGoodsUpdatedate()
    {
        return $this->goodsUpdatedate;
    }

    /**
     * @param string $goodsCreatedate
     */
    public function setGoodsCreatedate($goodsCreatedate)
    {
        $this->goodsCreatedate = $goodsCreatedate;
    }

    /**
     * @param string $goodsUpdatedate
     */
    public function setGoodsUpdatedate($goodsUpdatedate)
    {
        $this->goodsUpdatedate = $goodsUpdatedate;
    }

    /**
     * @return string
     */
    public function getGoodsCmd()
    {
        return $this->goodsCmd;
    }

    /**
     * @param string $goodsCmd
     */
    public function setGoodsCmd($goodsCmd)
    {
        $this->goodsCmd = $goodsCmd;
    }

    /**
     * Setter, Getter関数
     */
    /**
     * @return string
     */
    public function getGoodsNo()
    {
        return $this->goodsNo;
    }

    /**
     * @return string
     */
    public function getGoodsTitle()
    {
        return $this->goodsTitle;
    }

    /**
     * @return string
     */
    public function getGoodsContent()
    {
        return $this->goodsContent;
    }

    /**
     * @return string
     */
    public function getGoodsArea()
    {
        return $this->goodsArea;
    }

    /**
     * @return string
     */
    public function getGoodsPrice()
    {
        return $this->goodsPrice;
    }

    /**
     * @return string
     */
    public function getGoodsCprice()
    {
        return $this->goodsCprice;
    }

    /**
     * @return string
     */
    public function getSearchGoods()
    {
        return $this->searchGoods;
    }

    /**
     * @return string
     */
    public function getUserNo()
    {
        return $this->userNo;
    }

    /**
     * @return string
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * @param string $goodsNo
     */
    public function setGoodsNo($goodsNo)
    {
        $this->goodsNo = $goodsNo;
    }

    /**
     * @param string $goodsTitle
     */
    public function setGoodsTitle($goodsTitle)
    {
        $this->goodsTitle = $goodsTitle;
    }

    /**
     * @param string $goodsContent
     */
    public function setGoodsContent($goodsContent)
    {
        $this->goodsContent = $goodsContent;
    }

    /**
     * @param string $goodsArea
     */
    public function setGoodsArea($goodsArea)
    {
        $this->goodsArea = $goodsArea;
    }

    /**
     * @param string $goodsPrice
     */
    public function setGoodsPrice($goodsPrice)
    {
        $this->goodsPrice = $goodsPrice;
    }

    /**
     * @param string $goodsCprice
     */
    public function setGoodsCprice($goodsCprice)
    {
        $this->goodsCprice = $goodsCprice;
    }

    /**
     * @param string $searchGoods
     */
    public function setSearchGoods($searchGoods)
    {
        $this->searchGoods = $searchGoods;
    }

    /**
     * @param string $userNo
     */
    public function setUserNo($userNo)
    {
        $this->userNo = $userNo;
    }

    /**
     * @param string $userPassword
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;
    }

    /**
     * フォームからデータ取得
     */
    public function getForm(){
        if(isset($_POST['goodsNo'])) $this -> goodsNo = $_POST['goodsNo'];
        if(isset($_POST['goodsTitle'])) $this -> goodsTitle = $_POST['goodsTitle'];
        if(isset($_POST['goodsContent'])) $this -> goodsContent = $_POST['goodsContent'];
        if(isset($_POST['goodsArea'])) $this -> goodsArea = $_POST['goodsArea'];
        if(isset($_POST['goodsNo'])) $this -> goodsNo = $_POST['goodsNo'];
        if(isset($_POST['goodsPrice'])) {
            $this -> goodsPrice = $_POST['goodsPrice'];
            $this -> goodsCprice = $_POST['goodsPrice'] * 0.1;
        }
        if(isset($_POST['searchGoods'])) $this -> searchGoods = $_POST['searchGoods'];
        if(isset($_POST['userNo'])) $this -> userNo = $_POST['userNo'];
        if(isset($_POST['userPassword'])) $this -> userPassword = $_POST['userPassword'];
        if(isset($_POST['goodsCmd'])) $this -> goodsCmd = $_POST['goodsCmd'];
    }

    public function goodsList(){
        
    }
    public function indexGoodsList(){
        $sql = " SELECT  goods.*, goods_file.goods_filerealname FROM  goods
                    LEFT JOIN goods_file ON  goods.goods_no = goods_file.goods_no
                        WHERE goods.goods_onsale = '0' AND goods.goods_check = '0'
                        GROUP BY goods.goods_no
                        ORDER BY  goods.goods_updatedate DESC ";
        
        $result = connection($sql);
        if(mysqli_num_rows($result) > 0){
            while($data = mysqli_fetch_assoc($result)){
                $this -> setGoodsList($data);
            }
        }
    }
}
?>