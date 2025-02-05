<html><head>
<link href="css/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/user.js">
</script>
</head><body bgcolor="tan">
<center><a href ="#"><img src = "images/emblem.gif" width="100" alt="site logo"></a></center><br>     
<center><b><font color = "brown" size="6">National Polling Using FingerPrint</font></b></center><br><br>
<div id="page">
<div id="header">
<h1>Voter Registration </h1>
<div class="news"><marquee>New polls are up and running. But they will not be up forever! Just Login and then go to Current Polls to vote for your favourate candidates. </marquee></div>
</div>
<div id="container">
<?php

mysql_connect('localhost', 'root', '') or die(mysql_error());
mysql_select_db('polling') or die(mysql_error());

//Process
if (isset($_POST['submit']))
{
if($_FILES['fingerprint']['size']>0) {
	$type=$_FILES['fingerprint']['type'];
	if($type!="image/pjpeg" && $type!="image/jpeg" && $type!="image/jpg" && $type!="image/gif"  && $type!="image/png") {
	echo "<center><br>".$_FILES['fingerprint']['type']." : Your Fingreprint should be of type jpg/gif<br><a href='registeracc.php'>Back</a></center>";
	echo "</div><div id='footer'><div class='bottom_addr'>&copy; 2022 National Polling Using FingerPrint. All Rights Reserved</div></div></div></body></html>";
	return;
	}
	$fp=fopen($_FILES['fingerprint']['tmp_name'],"r");
	$c=fread($fp,$_FILES['fingerprint']['size']);
	$cc=addslashes($c);	
	fclose($fp);
	$fflg=true;
	$res1 = mysql_query("select fingerprint from tbmembers");
	while($r1 = mysql_fetch_row($res1)) {
		if($r1[0]==$c) {
		$fflg=false;
		break;
		}
	}
	if($fflg==true) {
$myFirstName = addslashes( $_POST['firstname'] ); //prevents types of SQL injection
$myLastName = addslashes( $_POST['lastname'] ); //prevents types of SQL injection
$myEmail = $_POST['email'];
$myPassword = $_POST['password'];
$newpass = md5($myPassword); //This will make your password encrypted into md5, a high security hash
$aadharno = $_POST['aadharno'];

$sql = mysql_query( "INSERT INTO tbMembers(first_name, last_name, email, password,fingerprint,aadharno) VALUES ('$myFirstName','$myLastName', '$myEmail', '$newpass','$cc','$aadharno')" ) or die( mysql_error() );

die( "You have registered for an account.<br><br>Go to <a href=\"login.html\">Login</a>" );
	} else {
echo "<center><br>Your Finger Print is Invalid...!<br>Try Again<br><a href='registeracc.php'>Back</a></center>";
	}
} else {
echo "<center><br>Your Finger Print is not Uploaded...!<br>Try Again<br><a href='registeracc.php'>Back</a></center>";
}
}

echo "<center><h3>Register an account by filling in the needed information below:</h3></center><br><br>";
echo '<form action="registeracc.php" method="post" onsubmit="return registerValidate(this)" enctype="multipart/form-data">';
echo '<table align="center"><tr><td>';
echo "<tr><td>First Name:</td><td><input type='text' style='background-color:#999999; font-weight:bold;' name='firstname' maxlength='15' value=''></td></tr>";
echo "<tr><td>Last Name:</td><td><input type='text' style='background-color:#999999; font-weight:bold;' name='lastname' maxlength='15' value=''></td></tr>";
echo "<tr><td>Email Address:</td><td><input type='text' style='background-color:#999999; font-weight:bold;' name='email' maxlength='100' value=''></td></tr>";
echo "<tr><td>Password:</td><td><input type='password' style='background-color:#999999; font-weight:bold;' name='password' maxlength='15' value=''></td></tr>";
echo "<tr><td>Confirm Password:</td><td><input type='password' style='background-color:#999999; font-weight:bold;' name='ConfirmPassword' maxlength='15' value=''></td></tr>";
echo "<tr><td>Your Finger Print:</td><td><input type='file' style='background-color:#999999; font-weight:bold;' name='fingerprint' required></td></tr>";
echo "<tr><td>Aadhar Number:</td><td><input type='text' style='background-color:#999999; font-weight:bold;' name='aadharno' maxlength='12' pattern='\d{12}' required></td></tr>";
echo "<tr><td colspan='2' align='center'><input type='submit' name='submit' value='Register Account'/></td></tr>";
echo "<tr><td colspan = '2'><p>Already have an account? <a href='login.html'><b>Login Here</b></a></td></tr>";
echo "</tr></td></table>";
echo "</form>";
?>
</div> 
<div id="footer">
<div class="bottom_addr">&copy; 2022 National Polling Using FingerPrint. All Rights Reserved</div>
</div>
</div>
</body></html>