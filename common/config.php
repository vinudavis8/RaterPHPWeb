<?php
//live db
DEFINE ('DB_USER', 'c1056386');
DEFINE ('DB_PASSWORD', 'abcd123456789');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'c1056386_db1');

//local db
// DEFINE ('DB_USER', 'root');
// DEFINE ('DB_PASSWORD', 'abcd1234');
// DEFINE ('DB_HOST', 'localhost');
// DEFINE ('DB_NAME', 'testdb');

function createConnection()
{
// Create connection
$dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($dbc->connect_error) {
	die("Connection failed: " . $dbc->connect_error);
}

$dbc -> set_charset("utf8");
return $dbc;
}
?>