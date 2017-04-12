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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_displayrec = 20;
$pageNum_displayrec = 0;
if (isset($_GET['pageNum_displayrec'])) {
  $pageNum_displayrec = $_GET['pageNum_displayrec'];
}
$startRow_displayrec = $pageNum_displayrec * $maxRows_displayrec;

mysql_select_db($database_signup, $signup);
$query_displayrec = "SELECT * FROM members";
$query_limit_displayrec = sprintf("%s LIMIT %d, %d", $query_displayrec, $startRow_displayrec, $maxRows_displayrec);
$displayrec = mysql_query($query_limit_displayrec, $signup) or die(mysql_error());
$row_displayrec = mysql_fetch_assoc($displayrec);

if (isset($_GET['totalRows_displayrec'])) {
  $totalRows_displayrec = $_GET['totalRows_displayrec'];
} else {
  $all_displayrec = mysql_query($query_displayrec);
  $totalRows_displayrec = mysql_num_rows($all_displayrec);
}
$totalPages_displayrec = ceil($totalRows_displayrec/$maxRows_displayrec)-1;

$queryString_displayrec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_displayrec") == false && 
        stristr($param, "totalRows_displayrec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_displayrec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_displayrec = sprintf("&totalRows_displayrec=%d%s", $totalRows_displayrec, $queryString_displayrec);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UCC Connect</title>
</head>

<body>
<table border="0">
  <tr>
    <td><?php if ($pageNum_displayrec > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_displayrec=%d%s", $currentPage, 0, $queryString_displayrec); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_displayrec > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_displayrec=%d%s", $currentPage, max(0, $pageNum_displayrec - 1), $queryString_displayrec); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_displayrec < $totalPages_displayrec) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_displayrec=%d%s", $currentPage, min($totalPages_displayrec, $pageNum_displayrec + 1), $queryString_displayrec); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_displayrec < $totalPages_displayrec) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_displayrec=%d%s", $currentPage, $totalPages_displayrec, $queryString_displayrec); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>

</br> </br>
<table border="1" cellpadding="1" cellspacing="1">
  <tr>
    <td>Member_ID</td>
    <td>FirstName</td>
    <td>OtherNames</td>
    <td>LastName</td>
    <td>Gender</td>
    <td>DOB</td>
    <td>Town_City</td>
    <td>Region</td>
    <td>Email</td>
    <td>Mobile</td>
    <td>Address</td>
    <td>Picture</td>
    <td>Program_Read</td>
    <td>College</td>
    <td>Faculty</td>
    <td>Department</td>
    <td>Admin_yr</td>
    <td>Grad_yr</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="updaterecord.php?Member_ID=<?php echo $row_displayrec['Member_ID']; ?>"><?php echo $row_displayrec['Member_ID']; ?></a></td>
      <td><?php echo $row_displayrec['FirstName']; ?></td>
      <td><?php echo $row_displayrec['OtherNames']; ?></td>
      <td><?php echo $row_displayrec['LastName']; ?></td>
      <td><?php echo $row_displayrec['Gender']; ?></td>
      <td><?php echo $row_displayrec['DOB']; ?></td>
      <td><?php echo $row_displayrec['Town_City']; ?></td>
      <td><?php echo $row_displayrec['Region']; ?></td>
      <td><?php echo $row_displayrec['Email']; ?></td>
      <td><?php echo $row_displayrec['Mobile']; ?></td>
      <td><?php echo $row_displayrec['Address']; ?></td>
      <td><?php echo $row_displayrec['Picture']; ?></td>
      <td><?php echo $row_displayrec['Program_Read']; ?></td>
      <td><?php echo $row_displayrec['College']; ?></td>
      <td><?php echo $row_displayrec['Faculty']; ?></td>
      <td><?php echo $row_displayrec['Department']; ?></td>
      <td><?php echo $row_displayrec['Admin_yr']; ?></td>
      <td><?php echo $row_displayrec['Grad_yr']; ?></td>
    </tr>
    <?php } while ($row_displayrec = mysql_fetch_assoc($displayrec)); ?>
</table>
</body>
<div id="footerh">
				<h5>KMS Copyright @ 2017  All Rights Reserved</h5></br>
			</div>
</html>
<?php
mysql_free_result($displayrec);
?>
