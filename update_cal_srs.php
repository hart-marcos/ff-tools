<?php 

$v = $_POST["v"] ?? "us";

$input = $_POST["new_srs"] ?? "[]";

$new_srs = json_encode(json_decode($input));

if($new_srs === null || $new_srs === []){
    exit("Error with srs Not Valid ... ");
}

$file = "";

switch ($v) {
    case "us":
        $file = "sr/sr_cal.json";
        break;
    case "th":
        $file = "sr/sr_th.json";
        break;
    case "fr":
        $file = "sr/sr_fr.json";
        break;
}


$myfile = fopen($file, "w") or die("Unable to open file!");

fwrite($myfile, $new_srs);

fclose($myfile);

echo "OK";

?>