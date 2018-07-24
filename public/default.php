<?php
//faça
// include "default.php";
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$query_string = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

echo "<strong>PATH: </strong>" . $path . "<br>";
echo "<strong>QUERY STRING: </strong>" . $query_string . "<br>";
