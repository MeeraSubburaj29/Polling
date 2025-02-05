<?php
$vote = $_REQUEST['vote'];
$mid=$_GET['mid'];
$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("polling", $con);

$rs=mysql_query("select status from tbmembers where member_id=$mid");
$r=mysql_fetch_row($rs);
if($r[0]=="no") {
mysql_query("UPDATE tbCandidates SET candidate_cvotes=candidate_cvotes+1 WHERE candidate_name='$vote'");
mysql_query("update tbmembers set status='yes' where member_id=$mid");
}

mysql_close($con);
?> 