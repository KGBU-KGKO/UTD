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
}

class Service 
{
    public $id = "";
    public $num = "";
    public $type = "";
    public $name = "";
    public $shortName = "";
    public $forHuman = "";
    public $status = "";
    public $reason = "";
    public $answerText = "";
    public $pages = "";
    public $before2000 = "";
    public $limits = "";
    public $realEstate;
    public $human;   

    public function __construct(array $arguments = array()) {
        if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                $this->{$property} = $argument;
            }
        }
    }    
}

class RealEstate 
{
    public $address = "";
    public $fullAddress = "";
    public $postcode = "";
    public $region = "";
    public $district = "";
    public $city = "";
    public $street = "";
    public $house = "";
    public $flat = "";
    public $location = "";
    public $inum = "";
    public $knum = "";
    public $area = "";
    public $info = "";

    public function __construct(array $arguments = array()) {
        if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                $this->{$property} = $argument;
            }
        }
    }

}

class Human 
{
    public $name = "";
    public $fullName = "";
    public $firstName = "";
    public $middleName = "";
    public $lastName = "";
    public $bDate = "";
    public $dulNum = "";
    public $dulDate = "";
    public $dulOrg = "";

    public function __construct(array $arguments = array()) {
        if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                $this->{$property} = $argument;
            }
        }
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
}

class TPL 
{
    public $subject = "";
    public $attach = "";
    public $text = "";
    public $number = "";
    public $needRef = [];
}

class History 
{
    public $time = "";
    public $event = "";
    public $user = "";

    public function __construct(array $arguments = array()) {
        if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                $this->{$property} = $argument;
            }
        }
    }

}

class Request
{
    public $id = "";
    public $num = "";
    public $date = "";
    public $dateDue = "";
    public $datePay = "";
    public $dateIssue = "";
    public $status = "";
    public $comment = "";
    public $smevNum = "";
    public $senderNum = "";
    public $senderDate = "";
    public $delivery = "";
    public $attachList = "";
    public $fileList = "";
    public $performer;
    public $declarant;
    public $service = [];
    public $reply;
    public $history = [];
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
