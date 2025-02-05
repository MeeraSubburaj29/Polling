<?php
$con = mysql_connect("localhost","root","");
if (!$con) {
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("polling", $con);
?>
<?php
// retrieving positions sql query
$positions=mysql_query("SELECT * FROM tbPositions") or die("There are no records to display ... \n" . mysql_error()); 
?>
<?php
session_start();
//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
}
?>

<?php 
if(isset($_POST['Submit'])){
//$totalvotes=$candidate_1+$candidate_2;
} 
?>

<html><head>
<link href="css/admin_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/admin.js">
</script>
</head><body bgcolor="tan">
<center><a href ="#"><img src = "images/emblem.gif" width="100" alt="site logo"></a></center><br>     
<center><b><font color = "brown" size="6">National Polling Using FingerPrint</font></b></center><br><br>
<div id="page">
<div id="header">
<h1>POLL RESULTS </h1>
<a href="admin.php">Home</a> | <a href="manage-admins.php">Manage Administrators</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="logout.php">Logout</a>
</div>
<div id="container">
<table width="420" align="center">
<?php
if(!isset($_POST['Submit'])) {
?>
<form name="fmNames" id="fmNames" method="post" action="refresh.php" onsubmit="return positionValidate(this)">
<tr>
    <td>Choose Position</td>
    <td><SELECT NAME="position" id="position">
    <OPTION VALUE="select">select
    <?php 
    //loop through all table rows
    while ($row=mysql_fetch_array($positions)){
    echo "<OPTION VALUE='$row[position_name]'>$row[position_name]"; 
    //mysql_free_result($positions_retrieved);
    //mysql_close($link);
    }
    ?>
    </SELECT></td>
    <td><input type="submit" name="Submit" value="See Results" /></td>
</tr>
<tr>
    <td>&nbsp;</td> 
    <td>&nbsp;</td>
</tr>
</form> 
</table>
<?php 
}
if(isset($_POST['Submit'])){
//echo $candidate_name_1;
} 
?>:
<br>

<br>
<?php
if(isset($_POST['Submit'])){
//echo $candidate_2;
echo "<br>Votes for the Post of <b>".strtoupper($_POST['position'])."</b><br><br>";
$rs=mysql_query("select candidate_name,candidate_cvotes,symbol from tbcandidates where candidate_position='$_POST[position]' and flg='valid'");
$rs1=mysql_query("select sum(candidate_cvotes) from tbcandidates where candidate_position='$_POST[position]' and flg='valid'");
$r1=mysql_fetch_row($rs1);
$total=$r1[0];
if($total==0) {
echo "<br><br><center>No Votes were registered for this Post Yet...!</center><br><br>";
echo "</div><div id='footer'><div class='bottom_addr'>&copy; 2015 Simple PHP Polling System. All Rights Reserved</div></div></div></body></html>";
return;
}
if(mysql_num_rows($rs)>0) {
echo "<table>";
$imgs=1;
while($r=mysql_fetch_row($rs)) {
	$imgname="images/candidate-$imgs.gif";
	$imgs++;
	if($imgs>5)
	$imgs=1;
	$candidate_count=$r[1];
	$per = round(($candidate_count/$total)*100);
	if($per==0)
	$imgwidth=1;
	else
	$imgwidth=3*$per;
	echo "<tr>";
	echo "<td><img src='$r[2]' width='50px' height='30px'></td><td>$r[0]</td><td><img src='$imgname' width='$imgwidth' height='20'>&nbsp;$per%</td>";
	echo "</tr>";
}
echo "</table>";
$rs=mysql_query("select candidate_name from tbcandidates where candidate_position='$_POST[position]' and flg='valid' and candidate_cvotes = (select max(candidate_cvotes) from tbcandidates where candidate_position='$_POST[position]')");	
if(mysql_num_rows($rs)>0) {
	$r = mysql_fetch_row($rs);
	echo "<br>Won Candidate Name : $r[0]";
}
mysql_free_result($rs);
echo "<div style='text-align:center'><a href='refresh.php?finalize' onclick=\"javascript:return confirm('Are You sure to finalize this POLL ?')\">Reset Project</a></div>";
}
}

if(isset($_GET['finalize'])) {
	mysql_query("update tbcandidates set flg='invalid'") or die(mysql_error());
	mysql_query("update tbmembers set status='no'");
	echo "<h3 align='center'>Poll Finalized...</h3>";
}
?>
</div>
<div id="footer">
<div class="bottom_addr">&copy; 2022 National Polling Using FingerPrint. All Rights Reserved</div>
</div>
</div>
</body></html>