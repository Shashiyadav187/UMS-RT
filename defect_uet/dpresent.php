<?php
require("../library/navigation.php");
?>
<html>
<link href="../style/design.css" rel="stylesheet" type="text/css"/>
<script>
    function docheck1(){
        if(document.form1.pid.value==""){
        alert("Please select a project name!");
        return false;
        }
    }
</script>
<fieldset>
<legend>User Experience Test -> Defect -> View Defect</legend>
<p></p>
<?php
if($_POST[pid] =="" && $_COOKIE[temp1]==""){
?>
<form name="form1" action="dpresent.php" method="POST" onsubmit="return docheck1()">
<table>
<tr>
<td>Project Name</td>
<td>: <select name="pid" style="width:60mm">
<option value=""> - SELECT PROJECT NAME -</option>
<?php
require("../library/connection.php");

$sql = "SELECT DISTINCT project FROM defect WHERE testingtype='UET'";
$result = mysql_query($sql,$con);

if ($myrow = mysql_fetch_array($result)){
do {
?>
	<option value="<?php printf("%s",$myrow["project"]); ?>"><?php printf("%s",$myrow["project"]); ?></option>
<?php
} while ($myrow = mysql_fetch_array($result));

} else {}

mysql_close($con);
?>
</select>
</td>
<td>
<input type="submit" name="submit" value="GO">
</td> 
</tr>
</table>
</form>
<?php
}

if($_POST[pid] !="" || $_COOKIE[temp1] !=""){

if($_COOKIE[temp1] !=""){
$_POST["pid"]=$_COOKIE["temp1"];
}
?>		
<SCRIPT TYPE="text/javascript" SRC="slideshow.js"></SCRIPT>

<SCRIPT TYPE="text/javascript">
ss = new slideshow("ss");
</SCRIPT>

<?php
require("../library/connection.php");
$sql = "SELECT * FROM defect WHERE project='$_POST[pid]' AND testingtype='UET'";
$result = mysql_query($sql,$con);

if ($myrow = mysql_fetch_array($result)){
do {

$status = $myrow["status"];
$string = preg_replace("(\r\n\r\n|\n\n|\r\r)", "<p />", $myrow["issue"]);
$string = stripcslashes(preg_replace("(\r\n|\n|\r)", "<br />", $string));
$string1 = preg_replace("(\r\n\r\n|\n\n|\r\r)", "<p />", $myrow["recommendation"]);
$string1 = stripcslashes(preg_replace("(\r\n|\n|\r)", "<br />", $string1));
$string2 = preg_replace("(\r\n\r\n|\n\n|\r\r)", "<p />", $myrow["screen"]);
$string2 = stripcslashes(preg_replace("(\r\n|\n|\r)", "<br />", $string2));
$string3 = preg_replace("(\r\n\r\n|\n\n|\r\r)", "<p />", $myrow["scrubbingnote"]);
$string3 = stripcslashes(preg_replace("(\r\n|\n|\r)", "<br />", $string3));
$string4 = preg_replace("(\r\n\r\n|\n\n|\r\r)", "<p />", $myrow["impact"]);
$string4 = stripcslashes(preg_replace("(\r\n|\n|\r)", "<br />", $string4));
?>
<SCRIPT TYPE="text/javascript">
s = new slide();
s.src =  "uploads/<?php printf("%s",$myrow["file"]);?>";
s.title = "<?php printf("%s - %s",$myrow["id"],$myrow["severity"]); ?>";
s.text = "<b><u>Issue</u></b> - (<?php printf("%s",$status); ?>)<br/>&#149; <?php printf("%s",$string); ?><br/><b><u>Category</u></b><br/>&#149; <?php printf("%s",$myrow["category"]); ?><br/><b><u>Recommendation</u></b><br/>&#149; <?php printf("%s",$string1); ?><br/><b><u>Screen</u></b><br/>&#149; <?php printf("%s",$string2); ?><br/><b><u>Impact</u></b><br/>&#149; <?php printf("%s",$string4); ?><b><br/><u>Note</u></b><br/>&#149; <?php printf("%s",$string3); ?>";
ss.add_slide(s);
</SCRIPT>
<?php
} while ($myrow = mysql_fetch_array($result));

} else {

}
?>

<body ONLOAD="ss.restore_position('SS_POSITION');ss.update();"
ONUNLOAD="ss.save_position('SS_POSITION');">
<p></p>
<DIV ID="slideshow">

<FORM ID="ss_form" NAME="ss_form" ACTION="" METHOD="GET">

<DIV ID="ss_controls">
<b>ISSUE</b> # 
<SELECT ID="ss_select" NAME="ss_select" ONCHANGE="ss.goto_slide(this.selectedIndex)">

</SELECT>

<A ID="ss_prev" HREF="javascript:ss.previous()"><button type="button">Previous</button></A>

<A ID="ss_next" HREF="javascript:ss.next()"><button type="button">Next</button></A>

</DIV>

<DIV ID="ss_img_div">
<table><tr><td><br/>
<IMG
ID="ss_img" NAME="ss_img" 
STYLE="width:500px;filter:progid:DXImageTransform.Microsoft.Fade();"
ALT=""><br/></td>
<td width="20px"></td>
<td><DIV ID="ss_text"></DIV>

</td></tr></table>

</DIV>

</FORM>

</DIV>

<SCRIPT TYPE="text/javascript">

function config_ss_select() {
  var selectlist = document.ss_form.ss_select;
  selectlist.options.length = 0;
  for (var i = 0; i < ss.slides.length; i++) {
    selectlist.options[i] = new Option();
    selectlist.options[i].text = (i + 1) + '. ' + ss.slides[i].title;
  }
  selectlist.selectedIndex = ss.current;
}

ss.pre_update_hook = function() {
  return;
}

ss.post_update_hook = function() {
  document.ss_form.ss_select.selectedIndex = this.current;
  return;
}

if (document.images) {
  ss.image = document.images.ss_img;
  ss.textid = "ss_text";
  config_ss_select();
  ss.update();
}
</SCRIPT>
</fieldset>
</body>
<?php 
}
?>
</html>