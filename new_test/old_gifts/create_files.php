<?php 

$n = $_POST["n"];

$input = $_POST["data"];

$data = json_encode(json_decode($input));


$myfile = fopen("new_ids/ids". $n. ".json", "w") or die("Unable to open file!");

fwrite($myfile, $data);

fclose($myfile);

echo "OK";


?>