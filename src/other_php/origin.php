<?php

$request_headers = getallheaders();
$origin = $request_headers['Origin'];

echo $origin;

?>