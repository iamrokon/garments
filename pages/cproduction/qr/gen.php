<?php    


    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;

    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";

    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);


    $filename = $PNG_TEMP_DIR.'test.png';
	//$number = $_POST['number'];

	if (isset($_POST['btn'])) {
    $number = $_POST['number'];
    } else{
		$number = 0;
	}

     $errorCorrectionLevel = 'M';
     $matrixPointSize = min(max((int)6, 1), 10);


    if (isset($_REQUEST['data'])) {

        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');

        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

    }


    //config form
    echo '<form  action="generate.php" method="post">
        Data:&nbsp;<input name="data" value="" />&nbsp
        &nbsp&nbsp<input name="number" value="" />
        <input name="btn" type="submit" value="GENERATE"></form>';


    $i = $number;
	while($i>0)
	{
    //display generated file
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';
	$i--;
	}
