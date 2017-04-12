<?php require_once('Connections/signup.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE members SET `FirstName`=%s, `OtherNames`=%s, `LastName`=%s, Gender=%s, DOB=%s, Town_City=%s, Region=%s, Email=%s, Mobile=%s, Address=%s, Picture=%s, Program_Read=%s, College=%s, Faculty=%s, Department=%s, Admin_yr=%s, Grad_yr=%s WHERE Member_ID=%s",
                       GetSQLValueString($_POST['First_Name'], "text"),
                       GetSQLValueString($_POST['Other_Names'], "text"),
                       GetSQLValueString($_POST['Last_Name'], "text"),
                       GetSQLValueString($_POST['Gender'], "text"),
                       GetSQLValueString($_POST['DOB'], "date"),
                       GetSQLValueString($_POST['Town_City'], "text"),
                       GetSQLValueString($_POST['Region'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Mobile'], "int"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['Picture'], "text"),
                       GetSQLValueString($_POST['Program_Read'], "text"),
                       GetSQLValueString($_POST['College'], "text"),
                       GetSQLValueString($_POST['Faculty'], "text"),
                       GetSQLValueString($_POST['Department'], "text"),
                       GetSQLValueString($_POST['Admin_yr'], "date"),
                       GetSQLValueString($_POST['Grad_yr'], "date"),
                       GetSQLValueString($_POST['Member_ID'], "int"));

  mysql_select_db($database_signup, $signup);
  $Result1 = mysql_query($updateSQL, $signup) or die(mysql_error());

  $updateGoTo = "recupdated.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_updaterecord = "-1";
if (isset($_GET['Member_ID'])) {
  $colname_updaterecord = $_GET['Member_ID'];
}
mysql_select_db($database_signup, $signup);
$query_updaterecord = sprintf("SELECT * FROM members WHERE Member_ID = %s", GetSQLValueString($colname_updaterecord, "int"));
$updaterecord = mysql_query($query_updaterecord, $signup) or die(mysql_error());
$row_updaterecord = mysql_fetch_assoc($updaterecord);
$totalRows_updaterecord = mysql_num_rows($updaterecord);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>UCC Connect</title>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="container">
		<div id="wrapper">
			<div id="header">
             <h1>ALUMNI CONNECT</h1>
             <img class="logo" src="images/logouc.png" width="376" height="164" alt=""/>	
			</div>
		  <div id="contentb">
			<nav id="sub">
			<li><a href="home.php"> Home</a></li>
			<li><a href="<?php echo $logoutAction ?>" button> Sign out</a></li>
			</nav>
            <div id="upform">
            <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
              <table align="center">
                <tr valign="baseline">
                  <td nowrap align="right">Member_ID:</td>
                  <td><?php echo $row_updaterecord['Member_ID']; ?></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">First Name:</td>
                  <td><input type="text" name="First_Name" value="<?php echo htmlentities($row_updaterecord['FirstName'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Other Names:</td>
                  <td><input type="text" name="Other_Names" value="<?php echo htmlentities($row_updaterecord['OtherNames'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Last Name:</td>
                  <td><input type="text" name="Last_Name" value="<?php echo htmlentities($row_updaterecord['LastName'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Gender:</td>
                  <td><input type="text" name="Gender" value="<?php echo htmlentities($row_updaterecord['Gender'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">DOB:</td>
                  <td><input type="text" name="DOB" value="<?php echo htmlentities($row_updaterecord['DOB'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Town_City:</td>
                  <td><input type="text" name="Town_City" value="<?php echo htmlentities($row_updaterecord['Town_City'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Region:</td>
                  <td><input type="text" name="Region" value="<?php echo htmlentities($row_updaterecord['Region'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Email:</td>
                  <td><input type="text" name="Email" value="<?php echo htmlentities($row_updaterecord['Email'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Mobile:</td>
                  <td><input type="text" name="Mobile" value="<?php echo htmlentities($row_updaterecord['Mobile'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Address:</td>
                  <td><input type="text" name="Address" value="<?php echo htmlentities($row_updaterecord['Address'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Picture:</td>
                  <td><input type="text" name="Picture" value="<?php echo htmlentities($row_updaterecord['Picture'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Program_Read:</td>
                  <td><input type="text" name="Program_Read" value="<?php echo htmlentities($row_updaterecord['Program_Read'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">College:</td>
                  <td><input type="text" name="College" value="<?php echo htmlentities($row_updaterecord['College'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Faculty:</td>
                  <td><input type="text" name="Faculty" value="<?php echo htmlentities($row_updaterecord['Faculty'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Department:</td>
                  <td><input type="text" name="Department" value="<?php echo htmlentities($row_updaterecord['Department'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Admin_yr:</td>
                  <td><input type="text" name="Admin_yr" value="<?php echo htmlentities($row_updaterecord['Admin_yr'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Grad_yr:</td>
                  <td><input type="text" name="Grad_yr" value="<?php echo htmlentities($row_updaterecord['Grad_yr'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">&nbsp;</td>
                  <td><input type="submit" value="Update record"></td>
                </tr>
              </table>
              <input type="hidden" name="MM_update" value="form1">
              <input type="hidden" name="Member_ID" value="<?php echo $row_updaterecord['Member_ID']; ?>">
            </form>
            </div>
            <p>&nbsp;</p>
		  </div>
			<div id="footer">
            	<h5>KMS Copyright @ 2017  All Rights Reserved</h5></br>
			</div>
		</div>
	</div>
	</body>
</html>
<?php
mysql_free_result($updaterecord);

?>
