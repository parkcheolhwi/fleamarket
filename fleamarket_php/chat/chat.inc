<?php 
class ChatModel{
    private $fromId;
    private $toId;
    private $chatContent;
    
    private $chatCmd;
    
    public function __construct(){
        $this -> init();
    }
    
    private function init(){
        $this -> fromId = '';
        $this -> toId = '';
        $this -> chatContent = '';
        $this -> chatCmd = '';
    }
    /**
     * @return string
     */
    public function getFromId()
    {
        return $this->fromId;
    }

    /**
     * @return string
     */
    public function getToId()
    {
        return $this->toId;
    }

    /**
     * @return string
     */
    public function getChatContent()
    {
        return $this->chatContent;
    }

    /**
     * @param string $fromId
     */
    public function setFromId($fromId)
    {
        $this->fromId = $fromId;
    }

    /**
     * @param string $toId
     */
    public function setToId($toId)
    {
        $this->toId = $toId;
    }

    /**
     * @param string $chatContent
     */
    public function setChatContent($chatContent)
    {
        $this->chatContent = $chatContent;
    }

    
    /**
     * @return string
     */
    public function getChatCmd()
    {
        return $this->chatCmd;
    }

    /**
     * @param string $chatCmd
     */
    public function setChatCmd($chatCmd)
    {
        $this->chatCmd = $chatCmd;
    }

    public function getForm(){
        if(isset($_POST['fromID'])) $this -> setFromId($_POST['fromID']);
        if(isset($_POST['toID'])) $this -> setToID($_POST['toID']);
        if(isset($_POST['chatContent'])) $this -> setChatContent($_POST['chatContent']);
        if(isset($_POST['chatCmd'])) $this -> setChatCmd($_POST['chatCmd']);
    }
}
?>