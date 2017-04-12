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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "signup")) {
  $insertSQL = sprintf("INSERT INTO users (F_Name, Username, Password, E-mail) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['email'], "text"));

  mysql_select_db($database_signup, $signup);
  $Result1 = mysql_query($insertSQL, $signup) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_signup, $signup);
$query_registeruser = "SELECT * FROM users WHERE F_Name = 'F_Name'";
$registeruser = mysql_query($query_registeruser, $signup) or die(mysql_error());
$row_registeruser = mysql_fetch_assoc($registeruser);
$totalRows_registeruser = mysql_num_rows($registeruser);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Alumni Connect</title>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="container">
		<div id="wrapper">
			<div id="header"><img class="logo" src="images/logouc.png" width="376" height="155" alt=""/>	
			</div>
			<div id="content">
				<form action="<?php echo $editFormAction; ?>" method="POST" name="signup" id="signup">
				  <table width="300">
				    <tbody>
				      <tr>
				        <td><label for="firstname">First Name:</label></td>
				        <td><input type="Firstname" name="fname" id="fname"></td>
			          </tr>
				      <tr>
				        <td><label for="username">Username:</label></td>
				        <td><input type="username" name="username" id="username"></td>
			          </tr>
				      <tr>
				        <td><label for="password">Password:</label></td>
				        <td><input type="password" name="password" id="password"></td>
			          </tr>
				      <tr>
				        <td><label for="email">Email:</label></td>
				        <td><input type="email" name="email" id="email"></td>
			          </tr>
				      <tr>
				        <td>&nbsp;</td>
				        <td><input type="submit" name="submit" id="submit" value="Sign Up"></td>
			          </tr>
			        </tbody>
			      </table>
				</form><br />
				<p>Already Registered? <a href="index.php">Sign In</a></p>
				
		  </div>
			<div id="footer">
				<h5>KMS Copyright @ 2017  All Rights Reserved</h5>
			</div>
		</div>
	</div>
	</body>
</html>
<?php
mysql_free_result($registeruser);
?>
