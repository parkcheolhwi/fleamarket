<?php 
class InquiryModel{
    
    private $userNo;                #ユーザー番号
    private $userId;                #ユーザーID
    private $userPhoneNumber;       #ユーザー電話番号
    private $userEmail;             #ユーザーEメール
    private $inquiryNo;             #お問い合わせ番号
    private $inquiryTitle;          #お問い合わせタイトル
    private $inquiryContent;        #お問い合わせ内容
    private $replyContent;          #返信内容
    private $inquiryCmd;            #タイプ
    
    private $inquiryList;           #お問い合わせリスト
    
    /**
     * コンストラクタ
     */
    public function __construct(){
        $this -> init();
    }
    
    private function init(){
        $this -> userNo = '';
        $this -> userId = '';
        $this -> userPhoneNumber = '';
        $this -> userEmail = '';
        $this -> inquiryNo = '';
        $this -> inquiryTitle = '';
        $this -> inquiryContent = '';
        $this -> replyContent = '';
        $this -> inquiryCmd = '';
        $this -> inquiryList = array();
    }
    
    /**
     * Setter, Getter関数
     * @param $userNo
     */
    public function setUserNo($userNo){
        $this -> userNo = $userNo;
    }
    public function setUserId($userId){
        $this -> userId = $userId;
    }
    public function setUserPhoneNumber($userPhoneNumber){
        $this -> userPhoneNumber = $userPhoneNumber;
    }
    public function setUserEmail($userEmail){
        $this -> userEmail = $userEmail;
    }
    public function setInquiryNo($inquiryNo){
        $this -> inquiryNo = $inquiryNo;
    }
    public function setInquiryTitle($inquiryTitle){
        $this -> inquiryTitle = $inquiryTitle;
    }
    public function setInquiryContent($inquiryContent){
        $this -> inquiryContent = $inquiryContent;
    }
    public function setReplyContent($replyContent){
        $this -> replyContent = $replyContent;
    }
    public function setInquiryCmd($inquiryCmd){
        $this -> inquiryCmd = $inquiryCmd;
    }
    public function setInquiryList($inquiryList){
        $this -> inquiryList[] = $inquiryList;
    }
    
   
    public function getUserNo(){
        return $this -> userNo;
    }
    public function getUserId(){
        return $this -> userId;
    }
    public function getUserPhoneNumber(){
        return $this -> userPhoneNumber;
    }
    public function getUserEmail(){
        return $this -> userEmail;
    }
    public function getInquiryNo(){
        return $this -> inquiryNo;
    }
    public function getInquiryTitle(){
        return $this -> inquiryTitle;
    }
    public function getInquiryContent(){
        return $this -> inquiryContent;
    }
    public function getReplyContent(){
        return $this -> replyContent;
    }
    public function getInquiryCmd(){
        return $this -> inquiryCmd;
    }
    public function getInquiryList(){
        return $this -> inquiryList;
    }
    
    /**
     * フォームからデータ取得
     */
    public function getForm(){
        if(isset($_POST['userNo'])) $this -> userNo = $_POST['userNo'];
        if(isset($_POST['userId'])) $this -> userId = $_POST['userId'];
        if(isset($_POST['userPhoneNumber'])) $this -> userPhoneNumber = $_POST['userPhoneNumber'];
        if(isset($_POST['userEmail'])) $this -> userEmail = $_POST['userEmail'];
        if(isset($_POST['inquiryNo'])) $this -> inquiryNo = $_POST['inquiryNo'];
        if(isset($_POST['inquiryTitle'])) $this -> inquiryTitle = $_POST['inquiryTitle'];
        if(isset($_POST['inquiryContent'])) $this -> inquiryContent = $_POST['inquiryContent'];
        if(isset($_POST['replyContent'])) $this -> replyContent = $_POST['replyContent'];
        if(isset($_POST['inquiryCmd'])) $this -> inquiryCmd = $_POST['inquiryCmd'];
    }
    
    
    public function processing(){
        
        if(!isset($_SESSION['userInfo'])){
            $error = "ログインしてください。";
            header("Location: ../index.php?errorMsg={$error}");
            exit;
        }
        
        $this -> inquiryList();
    }
    

    private function inquiryList(){
        
        $sql = " SELECT * FROM inquiryinfo ";
        if(isset($_SESSION['userInfo']) && $_SESSION['userInfo']['user_authority'] != '9'){
            $sql .= " WHERE user_no = {$_SESSION['userInfo']['user_no']} ";
        }
        $sql .= " ORDER BY inquiry_no DESC ";
        
        $result = connection($sql);
       
        if(mysqli_num_rows($result) > 0){
            while($data = mysqli_fetch_assoc($result)){
                $this -> setInquiryList($data);
            }
        }
       
    }
}
?>