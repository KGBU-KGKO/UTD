<?php
error_reporting(E_ALL);

$numInLog = $_GET['numInLog'];
$numOutLog = $_GET['numOutLog'];
//проверка, есть ли шаблон под данную услугу
include '../data/tplHandler.php';
//если нету, то выдавать заглушку, вот вам номер и дата
//если есть, то отдать шаблон







/*


include_once('../lib/tbs/tbs_class.php');
include_once('../lib/tbs/tbs_plugin_opentbs.php');


$TBS = new clsTinyButStrong;
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

$template = 'tpl.docx';
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).


// $yourname = 'qwe';

// $data = array(
//  array('date' => '2013-10-13', 'thin' => 156, 'heavy' => 128, 'total' => 284),
//  array('date' => '2013-10-14', 'thin' => 233, 'heavy' =>  25, 'total' => 284),
//  array('date' => '2013-10-15', 'thin' => 110, 'heavy' => 412, 'total' => 130),
//  array('date' => '2013-10-16', 'thin' => 258, 'heavy' => 522, 'total' => 258),
// );
// $TBS->MergeBlock('c', $data);

$logOutDate = '';
$logOutNum = '';
$numLog = '';
$dateReq = '';
$name = '';
$realEstate = '';
$performer = 'Батышева Анастасия Михайловна';
$performer2 = '';
$title = 'Документовед';

//заполняем ответ
// switch ($answer) {
//     case "yes":
         $answer = 'направляем копию учетно-технической документации на указанный объект';
//         break;
//     case "no":
//         $answer = $_GET['denyTxt'];
//         break;
// }

// Define the name of the output file
$save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
$output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
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
*/
?>