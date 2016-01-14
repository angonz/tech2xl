<?php
$target_dir = "uploads/" . date("YmdHis") . "-" . uniqid() . "/";
mkdir($target_dir);

$uploadOk = 1;
for($i=0; $i<count($_FILES["fileToUpload"]["name"]); $i++) {
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);


  // Check file size
  if ($_FILES["fileToUpload"]["size"][$i] > 500000000) {
    echo "Sorry, your file " . basename($_FILES["fileToUpload"]["name"][$i]) . " is too large.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";


  // if everything is ok, try to upload file
  } else {
    $moved=move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file);
    if (!$moved) {
      echo "Server error moving " . basename($_FILES["fileToUpload"]["name"][$i]);
      $uploadOk = 0;
    }
  }
}

if ($uploadOk == 1) {

        ob_start();
        passthru('/usr/bin/python3.4 /home/andres/git/tech2xl/tech2xl.py ' . $target_dir .  'output.xls ' . $target_dir . '*');
        $output=ob_get_clean();

        $attachment_location = $target_dir . "output.xls";
        if (file_exists($attachment_location)) {


            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Cache-Control: public"); // needed for i.e.
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length:".filesize($attachment_location));
            header("Content-Disposition: attachment; filename=output.xls");
            readfile($attachment_location);
            die();        
        } else {
            die("Error: File not found.");
        } 


    } else {
        echo "Not uploaded because of error";
    }

?>
