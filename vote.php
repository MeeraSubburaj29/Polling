 <?php
$link = mysql_connect('localhost', 'root', '') or die(mysql_error());
mysql_select_db('polling') or die(mysql_error());

session_start();
//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['member_id'])){
 header("location:access-denied.php");
}
?>
<?php
// retrieving positions sql query
$positions=mysql_query("SELECT * FROM tbPositions")
or die("There are no records to display ... \n" . mysql_error()); 
?>
<?php
    // retrieval sql query
// check if Submit is set in POST
 if (isset($_POST['Submit']))
 {
 // get position value
 $position = addslashes( $_POST['position'] ); //prevents types of SQL injection
 
 // retrieve based on position
 $result = mysql_query("SELECT * FROM tbCandidates WHERE candidate_position='$position' and flg='valid'")
 or die(" There are no records at the moment ... \n"); 
 
 // redirect back to vote
 //header("Location: vote.php");
 }
 else
 // do something
  
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Simple PHP Polling System:Voting Page</title>
<link href="css/user_styles.css" rel="stylesheet" type="text/css" />   
<script language="JavaScript" src="js/user.js">
</script>
<script type="text/javascript">
function getVote(int,mid)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

xmlhttp.open("GET","save.php?vote="+int+"&mid="+mid,true);
xmlhttp.send();
}

function getPosition(String)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

xmlhttp.open("GET","vote.php?position="+String,true);
xmlhttp.send();
}
</script>
<script type="text/javascript">
$(document).ready(function(){
   var j = jQuery.noConflict();
    j(document).ready(function()
    {
        j(".refresh").everyTime(1000,function(i){
            j.ajax({
              url: "admin/refresh.php",
              cache: false,
              success: function(html){
                j(".refresh").html(html);
              }
            })
        })
        
    });
   j('.refresh').css({color:"green"});
});
</script>
</head>
<body bgcolor="tan">
<center><a href ="#"><img src = "images/emblem.gif" width="100" alt="site logo"></a></center><br>     
<center><b><font color = "brown" size="6">National Polling Using FingerPrint</font></b></center><br><br>
<body>
<div id="page">
<div id="header">
  <h1>CURRENT POLLS</h1>
  <a href="voter.php">Home</a> | <a href="vote.php">Current Polls</a> | <a href="manage-profile.php">Manage My Profile</a> | <a href="logout.php">Logout</a>
</div>
<div class="refresh">
</div>
<div id="container">
<?php
$rs=mysql_query("select status from tbmembers where member_id=$_SESSION[member_id]");
$r=mysql_fetch_row($rs);
if($r[0]=="no") {
?>
<table width="420" align="center">
<?php
if(!isset($_POST['Submit'])) {
?>
<form name="fmNames" id="fmNames" method="post" action="vote.php" onsubmit="return positionValidate(this)">
<tr>
    <td>Choose Position</td>
    <td><SELECT NAME="position" id="position" onclick="getPosition(this.value)">
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
    <td><input type="submit" name="Submit" value="See Candidates" /></td>
</tr>
<tr>
    <td>&nbsp;</td> 
    <td>&nbsp;</td>
</tr>
</form> 
</table>
<?php
}
} else {
echo "<br><center>Your Vote is Registered...</center>";
}
?>
<table width="270" align="center">
<form>
<tr>
    <th>Candidates::<?php if(isset($_POST['position'])) echo $_POST['position']; ?></th>
</tr>
<?php
//loop through all table rows
//if (mysql_num_rows($result)>0){
  if (isset($_POST['Submit'])){
while ($row=mysql_fetch_array($result)){
echo "<tr>";
echo "<td>".$row['candidate_name']."</td>";
echo "<td><img src='admin/$row[symbol]' width='70px' height='40px'>";
echo "<td><input type='radio' name='vote' value='$row[candidate_name]' onclick='getVote(this.value,$_SESSION[member_id])' /></td>";
echo "</tr>";
}
mysql_free_result($result);
mysql_close($link);
//}
echo "<tr><th  colspan='3' style='text-align:center;'><input type='button' value='Go' onclick='call1()'></th></tr>";
  }
else
// do nothing
?>
<tr>    
    <th>&nbsp;</th>
</tr>

</form>
</table>
<h3>NB: Click a circle under a respective candidate to cast your vote. You can't vote more than once in a respective position. This process can not be undone so think wisely before casting your vote.</h3>
</div>
<div id="footer"> 
<div class="bottom_addr">&copy; 2022 National Polling Using FingerPrint. All Rights Reserved</div>
</div>
</div>
</body>
<script>
function call1() {
	var vt = document.getElementsByName("vote")
	flg = false
	for(i=0; i<vt.length; i++) {
		if(vt[i].checked)
		flg=true
	}
	if(!flg)
	alert("Vote for the Candidate...!")
	else
	location.href='vote.php'
}
</script>
</html>