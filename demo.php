<?php
	mysql_connect("localhost","root","");
	mysql_select_db("polling");
	$mypassword="admin";
	$encrypted_mypassword=md5($mypassword);
	$mypassword = stripslashes($mypassword);
	$mypassword = mysql_real_escape_string($mypassword);
	mysql_query("update tbadministrators set password='$encrypted_mypassword' where admin_id=1");
?>