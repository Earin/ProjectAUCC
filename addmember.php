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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addmember")) {
  $insertSQL = sprintf("INSERT INTO members (`FirstName`, `OtherNames`, `LastName`, Gender, DOB, Town_City, Region, Email, Mobile, Address, Picture, Program_Read, College, Faculty, Department, Admin_yr, Grad_yr) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['o_names'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['dob'], "date"),
                       GetSQLValueString($_POST['town_city'], "text"),
                       GetSQLValueString($_POST['region'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['mobile'], "int"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['image'], "text"),
                       GetSQLValueString($_POST['prog_read'], "text"),
                       GetSQLValueString($_POST['college'], "text"),
                       GetSQLValueString($_POST['faculty'], "text"),
                       GetSQLValueString($_POST['dept'], "text"),
                       GetSQLValueString($_POST['adm_yr'], "date"),
                       GetSQLValueString($_POST['grad_yr'], "date"));

  mysql_select_db($database_signup, $signup);
  $Result1 = mysql_query($insertSQL, $signup) or die(mysql_error());

  $insertGoTo = "home.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_signup, $signup);
$query_addmember = "SELECT * FROM members WHERE `FirstName` = 'FirstName'";
$addmember = mysql_query($query_addmember, $signup) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);
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
            <img class="logo" src="images/logouc.png" width="393" height="165" alt=""/>	
			</div>
			<div id="content">
            <nav id="sub">
			<li><a href="home.php"> Home</a></li>
			<li><a href="<?php echo $logoutAction ?>" button> Sign out</a></li><br/>
			</nav>
				<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="addmember" id="addmember">
			    <table width="900px">
			      <tbody>
			        <tr>
			          <td><label for="firstname">First Name:</label></td>
			          <td><input name="firstname" type="text" required id="firstname"></td>
			          <td><label for="email">Email:</label></td>
			          <td><input name="email" type="email" required id="email"></td>
			          <td><label for="prog_read">Program Read:</label></td>
			          <td><input type="text" name="prog_read" id="prog_read"></td>
		            </tr>
			        <tr>
			          <td><label for="o_names">Other Names :</label></td>
			          <td><input type="text" name="o_names" id="o_names"></td>
			          <td><label for="mobile">Mobile:</label></td>
			          <td><input name="mobile" type="tel" required id="mobile"></td>
			          <td>College</td>
			          <td><select name="college" id="college">
			            <option value="Humanities and Legal Studies">Humanities and Legal Studies</option>
			            <option>Education Studies</option>
			            <option>Agriculture and Natural Sciences</option>
			            <option>Health and Allied Sciences</option>
			            <option>School of Graduate Studies</option>
			            <option selected="selected">None</option>
		              </select></td>
		            </tr>
			        <tr>
			          <td><label for="lname">Last Name:</label></td>
			          <td><input name="lname" type="text" required id="lname"></td>
			          <td><label for="address">Address:</label></td>
			          <td><input type="text" name="address" id="address"></td>
			          <td><label for="faculty">Faculty:</label></td>
			          <td><input type="text" name="faculty" id="faculty"></td>
		            </tr>
			        <tr>
			          <td><label for="gender">Gender:</label></td>
			          <td><select name="gender" required id="gender">
			            <option>Male</option>
			            <option>Female</option>
			            <option selected="selected">None</option>
		              </select></td>
			          <td><label for="image">Image:</label></td>
			          <td><input type="file" name="image" id="image"></td>
			          <td><label for="dept">Department:</label></td>
			          <td><input type="text" name="dept" id="dept"></td>
		            </tr>
			        <tr>
			          <td><label for="dob">Date of Birth:</label></td>
			          <td><input name="dob" type="date" required id="dob"></td>
			          <td>&nbsp;</td>
			          <td>&nbsp;</td>
			          <td><label for="adm_yr">Admission Year:</label></td>
			          <td><input name="adm_yr" type="month" required id="adm_yr"></td>
		            </tr>
			        <tr>
			          <td><label for="town_city">Town/City:</label></td>
			          <td><input name="town_city" type="text" required id="town_city"></td>
			          <td>&nbsp;</td>
			          <td>&nbsp;</td>
			          <td><label for="grad_yr">Graduation Year:</label></td>
			          <td><input name="grad_yr" type="month" required id="grad_yr"></td>
		            </tr>
			        <tr>
			          <td><label for="region">Region:</label></td>
			          <td><select name="region" required id="region">
			            <option>Central</option>
			            <option>Northern</option>
			            <option>Eastern</option>
			            <option>Western</option>
			            <option>Upper East</option>
			            <option>Upper West</option>
			            <option>Brong Ahafo</option>
			            <option>Ashanti</option>
			            <option>Greater Accra</option>
			            <option>Volta</option>
		              </select></td>
			          <td>&nbsp;</td>
			          <td>&nbsp;</td>
			          <td>&nbsp;</td>
			          <td><input type="submit" name="submit" id="submit" value="Add Member"></td>
		            </tr>
		          </tbody>
		        </table>
			    <input type="hidden" name="MM_insert" value="addmember">
              </form>
				
			</div>
			<div id="footer">
            <h5>KMS Copyright @ 2017  All Rights Reserved</h5>
            </div>
		</div>
	</div>
	</body>
</html>
<?php
mysql_free_result($addmember);
?>
