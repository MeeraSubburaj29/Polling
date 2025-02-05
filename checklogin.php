<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Simple PHP Polling System Access Denied</title>
<link href="css/user_styles.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="tan">
<center><a href ="#"><img src = "images/emblem.gif" width="100" alt="site logo"></a></center><br>     
<center><b><font color = "brown" size="6">National Polling Using FingerPrint</font></b></center><br><br>
<body>
<div id="page">
<div id="header">
<h1>Invalid Credentials Provided </h1>
<p align="center">&nbsp;</p>
</div>
<div id="container">
<?php
ini_set ("display_errors", "1");
error_reporting(E_ALL);

ob_start();
session_start();
$host="localhost"; // Host name
$username="root"; // Database username
$password=""; // Database password
$db_name="polling"; // Database name
$tbl_name="tbMembers"; // Table name

// This will connect you to your database
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

// Defining your login details into variables
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];
$encrypted_mypassword=md5($mypassword); //MD5 Hash for security
// MySQL injection protections
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$aadharno = mysql_real_escape_string($_POST['aadharno']);
	$fp=fopen($_FILES['fingerprint']['tmp_name'],"r");
	$c=fread($fp,$_FILES['fingerprint']['size']);
	fclose($fp);

$sql="SELECT * FROM $tbl_name WHERE email='$myusername' and password='$encrypted_mypassword' and aadharno='$aadharno'" or die(mysql_error());
$result=mysql_query($sql) or die(mysql_error());

// Checking table row
$count=mysql_num_rows($result);
// If username and password is a match, the count will be 1

if($count==1){
// If everything checks out, you will now be forwarded to voter.php
$user = mysql_fetch_assoc($result);
	$c1=$user['fingerprint'];
	if($c!=$c1) {
	echo "<br><br><center>Finger Print does not Match !<br>Try Again...<br><a href='login.html'>Login</a></center>";
	echo "</div><div id='footer'><div class='bottom_addr'>&copy; 2015 National Polling Using FingerPrint. All Rights Reserved</div></div></div></body></html>";
	return;
	}	
$_SESSION['member_id'] = $user['member_id'];
header("location:voter.php");
}
//If the username or password is wrong, you will receive this message below.
else {
echo "Wrong Username or Password<br><br>Return to <a href=\"login.html\">login</a>";
}

ob_end_flush();

?> 
</div>
<div id="footer"> 
<div class="bottom_addr">&copy; 2022 National Polling Using FingerPrint. All Rights Reserved</div>
</div>
</div>
</body>
</html>