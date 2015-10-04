<?php

$link = mysql_connect("amtis.net","amtisnet_root","r00tqwerty!") or die(mysql_error());
echo "connected..<br>";

mysql_select_db("amtisnet_akademia_db",$link) or die(mysql_error());
echo "database selected..<br>";
?>