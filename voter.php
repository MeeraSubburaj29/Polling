<?php
mysql_connect('localhost', 'root', '') or die(mysql_error());
mysql_select_db('polling') or die(mysql_error());

session_start();
//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['member_id'])){
 header("location:access-denied.php");
}
$rs=mysql_query("select status from tbmembers where member_id=$_SESSION[member_id]");
$r=mysql_fetch_row($rs);
if($r[0]=="yes")
echo "<script type='text/javascript'>alert('Your Vote is Already Registered... You cannot Vote Either...')</script>";
?>
<html><head>
<link href="css/user_styles.css" rel="stylesheet" type="text/css" />
</head><body bgcolor="tan">
<center><a href ="#"><img src = "images/emblem.gif" width="100" alt="site logo"></a></center><br>     
<center><b><font color = "brown" size="6">National Polling Using FingerPrint</font></b></center><br><br>
<div id="page">
<div id="header">
<h1>VOTER HOME </h1>
<a href="voter.php">Home</a> | <a href="vote.php">Current Polls</a> | <a href="manage-profile.php">Manage My Profile</a> | <a href="logout.php">Logout</a>
</div>
<div id="container">
<p> Click a link above to do some stuff.</p>
<center>
<?php
//mysql_connect('localhost', 'root', '') or die(mysql_error());
//mysql_select_db('polling') or die(mysql_error());
$rs = mysql_query("select candidate_id,candidate_name,candidate_position,partyname,symbol from tbcandidates where flg='valid'");
echo "<br><br><table border='0' bgcolor='tan' cellpadding='5'><tr><th>Id<th>Candidate Name<th>Position Name<th>Party Name<th>Symbol";
while($r = mysql_fetch_row($rs)) {
	echo "<tr>";
	echo "<th>$r[0]<td>$r[1]<td>$r[2]<td>$r[3]<td><img src='./admin/$r[4]' width='50px' height='30px'>";
}
echo "</table>";
?>
</center>
</div>
<div id="footer">
<div class="bottom_addr">&copy; 2022 National Polling Using FingerPrint. All Rights Reserved</div>
</div>
</div>
</body></html>