<?php
include '../data/tplHandler.php';

include_once('../lib/tbs/tbs_class.php');
include_once('../lib/tbs/tbs_plugin_opentbs.php');

if (isset($request)) {
    printRequest($request); 
    if ($request->tpl->needRef) {
        foreach ($request->tpl->needRef as $value) {
            printRequest($request, $value, "10");
        }
    }
}

function printRequest($request, $num = null, $tpl = null)
{
    global $logOutDate;
    global $logOutNum;
    global $logInNum;
    global $logInDate;
    global $senderNum;
    global $senderDate;
    global $name;
    global $subjectTitle;
    global $subject;
    global $text;
    global $attach;
    global $performer;
    global $address;
    global $email;
    global $title;
    global $img;
    global $performer2;
    global $x;

    if (!is_null($num)) 
        $request = singleServiceDataPrepare($request, $num);
    $TBS = new clsTinyButStrong;
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

    $template = $tpl ? "tpl$tpl.docx" : 'tpl'.$request->tpl->number.'.docx';
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
     //тут надо дательный падеж
    $name = ($request->declarant->type == 'FL') ? explode(' ', $request->declarant->name)[0].' '.substr(explode(' ', $request->declarant->name)[1],0,2) . '. ' . substr(explode(' ', $request->declarant->name)[2],0,2) . '. ' : $request->declarant->name; //тут надо дательный падеж
    $subjectTitle = $request->tpl->subjectTitle;
    $subject = $request->tpl->subject;
    $text = $request->tpl->text;
    $attach = $request->tpl->attach;
    $addressArr = explode(', ', $request->declarant->address);
    $address = (count($addressArr) < 5) ? ($request->declarant->address) ?? '' : getAddress($addressArr);
    $email = ($request->declarant->email) ? $request->declarant->email : '';
    $performer = $request->performer->name;
    $performer2 = $request->performer->shortName;
    $title = $request->performer->title;

    $text = $attach ? explode("\r", "$text\r\r$attach") : explode("\r", $text);
    $TBS->MergeBlock('text', $text);
     
    $smev = (isset($request->smevNum) && $request->smevNum != "-") ? $request->smevNum."-" : "";
    $img = $request->performer->pathIMG;

    // Define the name of the output file
    //$save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
    $output_file_name = $smev.explode('/', $logInNum)[1].'.docx';
    $output_file_name = $tpl ? "справка-".($num+1)." ".$output_file_name : $output_file_name;
    // if ($save_as==='') {
    //     // Output the result as a downloadable file (only streaming, no data saved in the server)
    //     $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
    //     // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
    //     exit();
    // } else {
    //     // Output the result as a file on the server.
    //     $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
    //     // The script can continue.
    //     exit("File [$output_file_name] has been created.");
    // }  

  // download
  $TBS->Show(OPENTBS_FILE, "../tmp/".$output_file_name);

  print "Скачать <a href=\"../tmp/$output_file_name\">$output_file_name</a><br><br>";

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