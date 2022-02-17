<?php
class Declarant 
{
	public $name = "";
	public $address = "";
	public $email = "";
	public $type = "";
}

class Performer 
{
	public $name = "";
	public $shortName = "";
	public $title = "";
	public $pathIMG = "";
}

class Request
{
    public $logInNum = "";
    public $logOutNum = "";
    public $logOutDate = "";
    public $logInDate = "";
    public $smevNum = "";
    public $senderNum = "";
    public $senderDate = "";
    public $declarant;
    public $svc = "";
    public $realEstate = "";
    public $status = "";
    public $answer = "";
    public $subject = "";
    public $intro = "";
    public $answerText = "";
    public $attach = "";
    public $reason = "";
    public $dateDue = "";
    public $datePay = "";
    public $performer;

    function __construct(Declarant $declarant, Performer $performer) 
    {
    	$this->declarant = $declarant;
    	$this->performer = $performer;
    }
}

?>
