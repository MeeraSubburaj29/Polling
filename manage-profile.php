<?php
// connection details
$link = mysql_connect('localhost', 'root', '') or die(mysql_error());
mysql_select_db('polling') or die(mysql_error());

session_start();
//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['member_id'])){
 header("location:access-denied.php");
} 
//retrive voter details from the tbmembers table
$result=mysql_query("SELECT * FROM tbMembers WHERE member_id = '$_SESSION[member_id]'")
or die("There are no records to display ... \n" . mysql_error()); 
if (mysql_num_rows($result)<1){
    $result = null;
}
$row = mysql_fetch_array($result);
if($row)
 {
 // get data from db
 $stdId = $row['member_id'];
 $firstName = $row['first_name'];
 $lastName = $row['last_name'];
 $email = $row['email'];
 $aadharno = $row['aadharno'];
 }
?>
<?php
// updating sql query
if (isset($_POST['update'])){
$myId = addslashes( $_GET[id]);
$myFirstName = addslashes( $_POST['firstname'] ); //prevents types of SQL injection
$myLastName = addslashes( $_POST['lastname'] ); //prevents types of SQL injection
$myEmail = $_POST['email'];
$myPassword = $_POST['password'];

$newpass = md5($myPassword); //This will make your password encrypted into md5, a high security hash

$sql = mysql_query( "UPDATE tbMembers SET first_name='$myFirstName', last_name='$myLastName', email='$myEmail', password='$newpass' WHERE member_id = '$myId'" )
        or die( mysql_error() );

// redirect back to profile
 header("Location: manage-profile.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Voter Profile Management</title>
<link href="css/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/user.js">
</script>
</head>
<body bgcolor="tan">
<center><a href ="#"><img src = "images/emblem.gif" width="100" alt="site logo"></a></center><br>     
<center><b><font color = "brown" size="6">National Polling Using FingerPrint</font></b></center><br><br>
<div id="page">
<div id="header">
  <h1>MANAGE MY PROFILE</h1>
  <a href="voter.php">Home</a> | <a href="vote.php">Current Polls</a> | <a href="manage-profile.php">Manage My Profile</a> | <a href="logout.php">Logout</a>
</div>
<div id="container">
<table>
<tr>
<td>
<table width="380" align="center">
<CAPTION><h3>MY PROFILE</h3></CAPTION>
<tr>
    <td>Voter Id:</td>
    <td><?php echo $stdId; ?></td>
</tr>
<tr>
    <td>First Name:</td>
    <td><?php echo $firstName; ?></td>
</tr>
<tr>
    <td>Last Name:</td>
    <td><?php echo $lastName; ?></td>
</tr>
<tr>
    <td>Email:</td>
    <td><?php echo $email; ?></td>
</tr>
<tr>
    <td>Aadhar No:</td>
    <td><?php echo $aadharno; ?></td>
</tr>
<tr>
    <td>Password:</td>
    <td>Encrypted</td>
</tr>
</table>
</td>
<td>
<table border="0" width="620" align="center">
<CAPTION><h3>UPDATE PROFILE</h3></CAPTION>
<form action="manage-profile.php?id=<?php echo $_SESSION['member_id']; ?>" method="post" onsubmit="return updateProfile(this)">
<table align="center">
<tr><td>First Name:</td><td><input type="text" style="background-color:#999999; font-weight:bold;" name="firstname" maxlength="15" value=""></td></tr>
<tr><td>Last Name:</td><td><input type="text" style="background-color:#999999; font-weight:bold;" name="lastname" maxlength="15" value=""></td></tr>
<tr><td>Email Address:</td><td><input type="text" style="background-color:#999999; font-weight:bold;" name="email" maxlength="100" value=""></td></tr>
<tr><td>New Password:</td><td><input type="password" style="background-color:#999999; font-weight:bold;" name="password" maxlength="5" value=""></td></tr>
<tr><td>Confirm New Password:</td><td><input type="password" style="background-color:#999999; font-weight:bold;" name="ConfirmPassword" maxlength="15" value=""></td></tr>
<tr><td>&nbsp;</td></td><td><input type="submit" name="update" value="Update Profile"></td></tr>
</table>
</form>
</td>
</tr>
</table>
<hr>
</div>
<div id="footer"> 
<div class="bottom_addr">&copy; 2022 National Polling Using FingerPrint. All Rights Reserved</div>
</div>
</div>
</body>
</html>