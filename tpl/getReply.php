<?php
error_reporting(E_ALL);

$numInLog = $_GET['numInLog'];
$numOutLog = $_GET['numOutLog'];
//$attach = "";
//проверка, есть ли шаблон под данную услугу
include '../data/classRequest.php';
include '../data/tplHandler.php';
//если нету, то выдавать заглушку, вот вам номер и дата
//если есть, то отдать шаблон


include_once('../lib/tbs/tbs_class.php');
include_once('../lib/tbs/tbs_plugin_opentbs.php');

if (isset($request)) {
    $TBS = new clsTinyButStrong;
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

    $template = 'tpl1.docx';
    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).


    // $yourname = 'qwe';

    // $data = array(
    //  array('date' => '2013-10-13', 'thin' => 156, 'heavy' => 128, 'total' => 284),
    //  array('date' => '2013-10-14', 'thin' => 233, 'heavy' =>  25, 'total' => 284),
    //  array('date' => '2013-10-15', 'thin' => 110, 'heavy' => 412, 'total' => 130),
    //  array('date' => '2013-10-16', 'thin' => 258, 'heavy' => 522, 'total' => 258),
    // );
    // $TBS->MergeBlock('c', $data);

     $logOutDate = date("d.m.Y", strtotime($request->logOutDate));
     $logOutNum = $request->logOutNum;
     $logInNum = $request->logInNum;
     $logInDate = date("d.m.Y", strtotime($request->logInDate));
     $name = $request->declarant->name;
     $realEstate = $request->realEstate;
     $answer = $request->answerText; 
     $attach = $request->attach;
     $address = $request->declarant->address;
     $email = $request->declarant->email;
     $performer = $request->performer->name;
     $performer2 = $request->performer->shortName;
     $title = $request->performer->title;


    // Define the name of the output file
    $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
    $output_file_name = explode('/', $logInNum)[1].'-'.date('Y-m-d').'.docx';
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

?>