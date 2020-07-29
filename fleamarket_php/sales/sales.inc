<?php 
class SalesModel{
    private $year;
    private $month;
    private $userNo;
    
    private $salesList;
    
    public function __construct(){
        $this -> init();
    }
    
    private function init(){
        $this -> year = '';
        $this -> month = '';
        $this -> userNo = '';
        $this -> salesList = array();
    }
    
    /**
     * @return multitype:
     */
    public function getSalesList()
    {
        return $this->salesList;
    }

    /**
     * @param multitype: $salesList
     */
    public function setSalesList($salesList)
    {
        $this->salesList[] = $salesList;
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return string
     */
    public function getUserNo()
    {
        return $this->userNo;
    }

    /**
     * @param string $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @param string $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @param string $userNo
     */
    public function setUserNo($userNo)
    {
        $this->userNo = $userNo;
    }

    
    public function getForm(){
        if(isset($_POST['year'])) $this -> year = $_POST['year'];
        if(isset($_POST['month'])) $this -> month = $_POST['month'];
        if(isset($_POST['userNo'])) $this -> userNo = $_POST['userNo'];
    }
    
    
}
?>