<?php
class Declarant 
{
	public $name = "";
    public $shortName = "";
    public $haveAgent = "";
	public $address = "";
	public $email = "";
    public $phone = "";
	public $type = "";
    public $birth = "";
    public $INN = "";
    public $OGRN = "";
    public $dulNum = "";
    public $dulDate = "";
    public $dulOrg = "";    
    public $agent;

    function __construct() 
    {
        $this->agent = new Agent();
    }    
}

class Agent 
{
    public $name = "";
    public $address = "";
    public $email = "";
    public $phone = "";
    public $dulNum = "";
    public $dulDate = "";
    public $dulOrg = "";
    public $agentDoc = "";
}


class Performer 
{
	public $name = "";
	public $shortName = "";
	public $title = "";
	public $pathIMG = "";
}

class Reply 
{
    public $num = "";
    public $date = "";
    public $status = "";
    public $reason = "";
    public $text = "";
}

class TPL 
{
    public $subject = "";
    public $attach = "";
    public $answerText = "";
    public $number = "";
}

class Request
{
    public $num = "";
    public $date = "";
    public $smevNum = "";
    public $senderNum = "";
    public $senderDate = "";
    public $svc = "";
    public $svcFull = "";
    public $realEstate = "";
    public $comment = "";
    public $delivery = "";
    public $attachList = "";
    public $fileList = "";
    public $status = "";
    public $dateDue = "";
    public $datePay = "";
    public $performer;
    public $declarant;
    public $reply;
    public $tpl;

    function __construct() 
    {
    	$this->declarant = new Declarant();
    	$this->performer = new Performer();
        $this->reply = new Reply();
        $this->tpl = new TPL();
    }
}

?>
