<?php
session_start();
// connection details
error_reporting(E_ERROR);
$link = mysql_connect('localhost', 'root', '') or die(mysql_error());
mysql_select_db('polling') or die(mysql_error());


//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
} 
//retrive candidates from the tbcandidates table
$result=mysql_query("SELECT * FROM tbCandidates where flg='valid'")
or die("There are no records to display ... \n" . mysql_error()); 
if (mysql_num_rows($result)<1){
    $result = null;
}
?>
<?php
// retrieving positions sql query
$positions_retrieved=mysql_query("SELECT * FROM tbPositions")
or die("There are no records to display ... \n" . mysql_error()); 
/*
$row = mysql_fetch_array($positions_retrieved);
 if($row)
 {
 // get data from db
 $positions = $row['position_name'];
 }
 */
?>
<?php
// inserting sql query
if (isset($_POST['Submit']))
{

$newCandidateName = addslashes( $_POST['name'] ); //prevents types of SQL injection
$newCandidatePosition = addslashes( $_POST['position'] ); //prevents types of SQL injection
$partyname = addslashes($_POST['partyname']);
	if(!is_uploaded_file($_FILES['symbol']['tmp_name'])) {
		echo "<script>alert('Symbol Not Uploaded...')</script>";
	return;
	}
$symbol = "symbols/".time().$_FILES['symbol']['name'];
	move_uploaded_file($_FILES['symbol']['tmp_name'], $symbol) or die("Symbol Not Uploaded...");

$sql = mysql_query( "INSERT INTO tbCandidates(candidate_name,candidate_position,partyname,symbol) VALUES ('$newCandidateName','$newCandidatePosition','$partyname','$symbol')" )
        or die("Could not insert candidate at the moment". mysql_error() );

// redirect back to candidates
 header("Location: candidates.php");
}
?>
<?php
// deleting sql query
// check if the 'id' variable is set in URL
 if (isset($_GET['id']))
 {
 // get id value
 $id = $_GET['id'];
 
 // delete the entry
 $result = mysql_query("DELETE FROM tbCandidates WHERE candidate_id='$id'")
 or die("The candidate does not exist ... \n"); 
 
 // redirect back to candidates
 header("Location: candidates.php");
 }
 else
 // do nothing   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Administration Control Panel:Candidates</title>
<link href="css/admin_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/admin.js">
</script>
</head>
<body bgcolor="tan">
<center><a href ="#"><img src = "images/emblem.gif" width="100" alt="site logo"></a></center><br>     
<center><b><font color = "brown" size="6">National Polling Using FingerPrint</font></b></center><br><br>
<div id="page">
<div id="header">
  <h1>MANAGE CANDIDATES</h1>
  <a href="admin.php">Home</a> | <a href="manage-admins.php">Manage Administrators</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="logout.php">Logout</a>
</div>
<div id="container">
<table width="380" align="center">
<CAPTION><h3>ADD NEW CANDIDATE</h3></CAPTION>
<form name="fmCandidates" id="fmCandidates" action="candidates.php" method="post" onsubmit="return candidateValidate(this)" enctype="multipart/form-data">
<tr>
    <td>Candidate Name</td>
    <td><input type="text" name="name" required /></td>
</tr>
<tr>
    <td>Candidate Position</td>
    <!--<td><input type="combobox" name="position" value="<?php echo $positions; ?>"/></td>-->
    <td><SELECT NAME="position" id="position">select
    <OPTION VALUE="select">select
    <?php
    //loop through all table rows
    while ($row=mysql_fetch_array($positions_retrieved)){
    echo "<OPTION VALUE='$row[position_name]'>$row[position_name]";
    //mysql_free_result($positions_retrieved);
    //mysql_close($link);
    }
    ?>
    </SELECT>
    </td>
</tr>
<tr>
  <td>Party Name
  <td><input type="text" name="partyname" required>
</tr>
<tr>
  <td>Symbol
  <td><input type="file" name="symbol" accept="image/*" required>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Add" /></td>
</tr>
</table>
<hr>
<table border="0" width="620" align="center">
<CAPTION><h3>AVAILABLE CANDIDATES</h3></CAPTION>
<tr>
<th>Candidate ID</th>
<th>Candidate Name</th>
<th>Candidate Position</th>
<th>Party Name</th>
<th>Symbol</th>
<th>Task</th>
</tr>

<?php
//loop through all table rows
if(mysql_num_rows($result)>0) {
while ($row=mysql_fetch_array($result)){
echo "<tr>";
echo "<td>" . $row['candidate_id']."</td>";
echo "<td>" . $row['candidate_name']."</td>";
echo "<td>" . $row['candidate_position']."</td>";
echo "<td>" . $row['partyname']."</td>";
echo "<td><img src='" . $row['symbol']."' width='50px' height='30px'></td>";
echo "<td><a href=\"candidates.php?id=$row[candidate_id]\" onclick=\"javascript:return confirm('Are You sure to Delete ?')\">Delete Candidate</a></td>";
echo "</tr>";
}
mysql_free_result($result);
}
mysql_close($link);
?>
</table>
<hr>
</div>
<div id="footer"> 
<div class="bottom_addr">&copy; 2022 National Polling Using FingerPrint. All Rights Reserved</div>
</div>
</div>
</body>
</html>