<?php
error_reporting(E_ALL);

$num = $_GET['numInLog'];
include '../data/tplHandler.php';

include_once('../lib/tbs/tbs_class.php');
include_once('../lib/tbs/tbs_plugin_opentbs.php');

if (isset($request)) {
    $TBS = new clsTinyButStrong;
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

    $template = 'tpl'.$request->tpl->number.'.docx';
    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).
    //$TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true);

    // $data = array(
    //  array('date' => '2013-10-13', 'thin' => 156, 'heavy' => 128, 'total' => 284),
    //  array('date' => '2013-10-14', 'thin' => 233, 'heavy' =>  25, 'total' => 284),
    //  array('date' => '2013-10-15', 'thin' => 110, 'heavy' => 412, 'total' => 130),
    //  array('date' => '2013-10-16', 'thin' => 258, 'heavy' => 522, 'total' => 258),
    // );
    // $TBS->MergeBlock('c', $data);

     $logOutDate = $request->reply->date;
     $logOutNum = $request->reply->num;
     $logInNum = $request->num;
     $logInDate = $request->date;
     $senderNum = ($request->senderNum != '') ? $request->senderNum : $logInNum;
     $senderDate = ($request->senderDate != '') ? $request->senderDate : $logInDate;
     $name = ($request->declarant->type == 'FL') ? explode(' ', $request->declarant->name)[0].' '.substr(explode(' ', $request->declarant->name)[1],0,2) . '. ' . substr(explode(' ', $request->declarant->name)[2],0,2) . '. ' : $request->declarant->name; //тут надо дательный падеж
     $realEstate = $request->realEstate;
     $objInfo = ($request->objInfo) ? ", ".$request->objInfo : "";
     $answer = $request->tpl->answerText;
     $text = $request->reply->text;
     $attach = $request->tpl->attach;
     $addressArr = explode(', ', $request->declarant->address);
     $address = (count($addressArr) < 5) ? ($request->declarant->address) ?? '' : getAddress($addressArr);
     $email = ($request->declarant->email) ? $request->declarant->email : '';
     $performer = $request->performer->name;
     $performer2 = $request->performer->shortName;
     $title = $request->performer->title;
     $subject = $request->tpl->subject;
     $smev = (isset($request->smevNum) && $request->smevNum != "-") ? $request->smevNum."-" : "";
     $img = $request->performer->pathIMG;;


    // Define the name of the output file
    $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
    $output_file_name = $smev.explode('/', $logInNum)[1].'.docx';
    if ($save_as==='') {
        // Output the result as a downloadable file (only streaming, no data saved in the server)
        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
        // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
        exit();
    } else {
        // Output the result as a file on the server.
        $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
        // The script can continue.
        exit("File [$output_file_name] has been created.");
    }    
}

function getAddress($arr)
{
    $pre = [];
    switch (count($arr)) {
        case 1:
        case 2:
        case 3:
        case 4:
            $newAddress = implode(', ', $arr);
            break;
        case 5:
        case 6:
        case 7:
        case 8:
        case 9:
        case 10:
        case 11:
            $post = ", ".$arr[2].", ".$arr[1].", ".$arr[0];
            foreach($arr as $key=>$value) {
                if ($key > 2) {
                    array_push($pre, $value);
                }
            }
            break;
    }        
    return implode(', ', $pre).$post;
}

?>