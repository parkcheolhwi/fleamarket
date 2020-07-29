<?php 
class UserModel{
    private $userNo;                    #ユーザー番号
    private $userId;                    #ユーザーID
    private $userEmail;                 #ユーザーE-メール
    private $userPassword;              #ユーザーパスワード
    private $userName;                  #ユーザー名前
    private $userBirth;                 #ユーザー誕生日
    private $userPhoneNumber;           #ユーザー電話番号
    private $userCreateDate;            #ユーザー登録日
    private $userUpdateDate;            #ユーザー更新日
    private $userZipcode;               #ユーザー郵便番号
    private $userAddress1;              #ユーザー住所
    private $userAddress2;              #ユーザー住所２
    private $userList;                  #ユーザーリスト
    
    private $oldPassword;
    
    private $num;                       #会員登録認証番号
    private $goodsCount;
    private $certificationNumber;       #パスワード探しのユーザー認証番号
    private $userCmd;
    
    public function __construct(){
        $this -> init();
    }
    
    private function init(){
        $this -> userNo = '';
        $this -> userId = '';
        $this -> userEmail = '';
        $this -> userPassword = '';
        $this -> userName = '';
        $this -> userBirth = '';
        $this -> userPhoneNumber = '';
        $this -> userCreateDate = '';
        $this -> userUpdateDate = '';
        $this -> userZipcode = '';
        $this -> userAddress1 = '';
        $this -> userAddress2 = '';
        $this -> userList = array();
        
        $this -> oldPassword = '';
        
        $this -> num = '';
        $this -> goodsCount = '';
        $this -> certificationNumber = '';
        $this -> userCmd = '';
    }
    
    /**
     * @return string
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param string $oldPassword
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
    }

    /**
     * @return multitype:
     */
    public function getUserList()
    {
        return $this->userList;
    }

    /**
     * @param multitype: $userList
     */
    public function setUserList($userList)
    {
        $this->userList[] = $userList;
    }

    /**
     * @return string
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * @param string $num
     */
    public function setNum($num)
    {
        $this->num = $num;
    }

    /**
     * @return string
     */
    public function getGoodsCount()
    {
        return $this->goodsCount;
    }

    /**
     * @param string $goodsCount
     */
    public function setGoodsCount($goodsCount)
    {
        $this->goodsCount = $goodsCount;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getUserBirth()
    {
        return $this->userBirth;
    }

    /**
     * @return string
     */
    public function getUserPhoneNumber()
    {
        return $this->userPhoneNumber;
    }

    /**
     * @return string
     */
    public function getUserCreateDate()
    {
        return $this->userCreateDate;
    }

    /**
     * @return string
     */
    public function getUserUpdateDate()
    {
        return $this->userUpdateDate;
    }

    /**
     * @return string
     */
    public function getUserZipcode()
    {
        return $this->userZipcode;
    }

    /**
     * @return string
     */
    public function getUserAddress1()
    {
        return $this->userAddress1;
    }

    /**
     * @return string
     */
    public function getUserAddress2()
    {
        return $this->userAddress2;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @param string $userBirth
     */
    public function setUserBirth($userBirth)
    {
        $this->userBirth = $userBirth;
    }

    /**
     * @param string $userPhoneNumber
     */
    public function setUserPhoneNumber($userPhoneNumber)
    {
        $this->userPhoneNumber = $userPhoneNumber;
    }

    /**
     * @param string $userCreateDate
     */
    public function setUserCreateDate($userCreateDate)
    {
        $this->userCreateDate = $userCreateDate;
    }

    /**
     * @param string $userUpdateDate
     */
    public function setUserUpdateDate($userUpdateDate)
    {
        $this->userUpdateDate = $userUpdateDate;
    }

    /**
     * @param string $userZipcode
     */
    public function setUserZipcode($userZipcode)
    {
        $this->userZipcode = $userZipcode;
    }

    /**
     * @param string $userAddress1
     */
    public function setUserAddress1($userAddress1)
    {
        $this->userAddress1 = $userAddress1;
    }

    /**
     * @param string $userAddress2
     */
    public function setUserAddress2($userAddress2)
    {
        $this->userAddress2 = $userAddress2;
    }

    /**
     * @return string
     */
    public function getCertificationNumber()
    {
        return $this->certificationNumber;
    }

    /**
     * @param string $certificationNumber
     */
    public function setCertificationNumber($certificationNumber)
    {
        $this->certificationNumber = $certificationNumber;
    }

    /**
     * @return string
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * @param string $userPassword
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;
    }

    /**
     * @return  <string, unknown>
     */
    public function getUserNo()
    {
        return $this->userNo;
    }

    /**
     * @param Ambigous <string, unknown> $userNo
     */
    public function setUserNo($userNo)
    {
        $this->userNo = $userNo;
    }

    /**
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * @param string $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return  <string, unknown>
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return  <string, unknown>
     */
    public function getUserCmd()
    {
        return $this->userCmd;
    }

    /**
     * @param Ambigous <string, unknown> $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param Ambigous <string, unknown> $userCmd
     */
    public function setUserCmd($userCmd)
    {
        $this->userCmd = $userCmd;
    }

    public function getForm(){
        if(isset($_GET['num'])) $this -> num = $_GET['num'];
        if(isset($_GET['userId'])) $this -> userId = $_GET['userId'];
        
        if(isset($_POST['userNo'])) $this -> userNo = $_POST['userNo'];
        if(isset($_POST['userId'])) $this -> userId = $_POST['userId'];
        if(isset($_POST['userEmail'])) $this -> userEmail = $_POST['userEmail'];
        if(isset($_POST['userPassword'])) $this -> userPassword = $_POST['userPassword'];
        if(isset($_POST['userPhoneNumber'])) $this -> userPhoneNumber = $_POST['userPhoneNumber'];
        if(isset($_POST['userZipcode'])) $this -> userZipcode = $_POST['userZipcode'];
        if(isset($_POST['userAddress1'])) $this -> userAddress1 = $_POST['userAddress1'];
        if(isset($_POST['userAddress2'])) $this -> userAddress2 = $_POST['userAddress2'];
        if(isset($_POST['oldPassword'])) $this -> oldPassword = $_POST['oldPassword'];
        if(isset($_POST['userName'])) $this -> userName = $_POST['userName'];
        
        if(isset($_POST['year']) && isset($_POST['month']) && isset($_POST['day'])) $this -> userBirth = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
        
        if(isset($_POST['certificationNumber'])) $this -> certificationNumber = $_POST['certificationNumber'];
        if(isset($_POST['userCmd'])) $this -> userCmd = $_POST['userCmd'];
        if(isset($_GET['userCmd'])) $this -> userCmd = $_GET['userCmd'];
    }

    public function getDetailUser(){
        if(!isset($_SESSION['userInfo'])){
            $error = "ログインしてください。";
            header("Location: ../index.php?errorMsg={$error}");
            exit;
        }
        
        $sql = " SELECT userinfo.*, COUNT(goods.goods_no) AS goodsCount FROM userinfo
                        LEFT JOIN goods ON userinfo.user_no = goods.user_no
                            WHERE userinfo.user_no = {$_SESSION['userInfo']['user_no']}
                            GROUP BY userinfo.user_no ; ";
        
        /**
         * SQLを実行しデータを取得する
         * @var unknown $result
         */
        $result = connection($sql);
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            $this -> setUserNo($data['user_no']);
            $this -> setUserId($data['user_id']);
            $this -> setUserName($data['user_name']);
            $this -> setUserBirth($data['user_birth']);
            $this -> setUserPhoneNumber($data['user_phone']);
            $this -> setUserEmail($data['user_email']);
            $this -> setUserCreateDate($data['user_createdate']);
            $this -> setUserZipcode($data['user_zipcode']);
            $this -> setUserAddress1($data['user_address1']);
            $this -> setUserAddress2($data['user_address2']);
            $this -> setGoodsCount($data['goodsCount']);
        }

    }
    
    public function userList(){
        if(!isset($_SESSION['userInfo']) || $_SESSION['userInfo']['user_authority'] != 9){
            $error = "管理者だけアクセスできます。";
            header("Location: ../index.php?errorMsg={$error}");
            exit;
        }
        
        $sql = " SELECT a.*, count(b.user_likecount) AS user_likecount, count(b.user_hatecount) AS user_hatecount FROM
                    (SELECT userinfo.*, COUNT(goods.goods_no) AS goodsCount FROM userinfo
                            LEFT JOIN goods ON userinfo.user_no = goods.user_no
                                GROUP BY userinfo.user_no) a
			         LEFT JOIN like_hate_count b ON a.user_no = b.user_no
                        WHERE user_authority = '1'
			            GROUP BY a.user_no
                        ORDER BY user_no; ";
        
        $result = connection($sql);
        if(mysqli_num_rows($result) > 0){
            while($data = mysqli_fetch_assoc($result)){
                $this -> setUserList($data);
            }
        }
    }

}
?>