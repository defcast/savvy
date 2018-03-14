<?php
$link = mysql_connect('localhost', 'root', '6&^r]r`k,ts@,zHt');
if (!$link) {
die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
mysql_close($link);
?>