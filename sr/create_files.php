<?php 

$n = $_POST["n"];

$v = $_POST["v"];

$input = $_POST["srs"];

$data = json_encode(json_decode($input));


$myfile = fopen($v. "/sr". $n. ".json", "w") or die("Unable to open file!");

fwrite($myfile, $data);

fclose($myfile);

echo "OK ".$n;


?>