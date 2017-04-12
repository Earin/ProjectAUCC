<?php require_once('Connections/signup.php'); ?>
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

mysql_select_db($database_signup, $signup);
$query_login = "SELECT * FROM users WHERE F_Name = 'F_Name'";
$login = mysql_query($query_login, $signup) or die(mysql_error());
$row_login = mysql_fetch_assoc($login);
$totalRows_login = mysql_num_rows($login);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['textfield'])) {
  $loginUsername=$_POST['textfield'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_signup, $signup);
  
  $LoginRS__query=sprintf("SELECT Username, Password FROM users WHERE Username=%s AND Password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $signup) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
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
			<div id="header"><img class="logo" src="images/logouc.png" width="376" height="171" alt=""/>	
			</div>
			<div id="content">
			  <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" id="login"><table id="log" width="200">
  <tbody>
    <tr>
      <td><label for="textfield">Username:</label></td>
      <td><input type="text" name="textfield" id="textfield"></td>
    </tr>
    <tr>
      <td><label for="password">Password:</label></td>
      <td><input name="password" type="password" required id="password"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" id="submit" value="Sign In"></td>
    </tr>
  </tbody>
</table>
</form><br/>
           <p>New Here? <a href="signup.php">Sign Up!</a></p>
            </div>
			<div id="footer">
            <h5>KMS Copyright @ 2017  All Rights Reserved</h5></div>
		</div>
        </div>
	</div>
	</body>
    </html>
<?php
mysql_free_result($login);
?>
