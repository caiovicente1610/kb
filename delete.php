<?php require_once('Connections/teste.php'); ?>
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

if ((isset($_GET['CPF'])) && ($_GET['CPF'] != "")) {
  $deleteSQL = sprintf("DELETE FROM clientes WHERE CPF=%s",
                       GetSQLValueString($_GET['CPF'], "text"));

  mysql_select_db($database_teste, $teste);
  $Result1 = mysql_query($deleteSQL, $teste) or die(mysql_error());

  $deleteGoTo = "apagado.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_rsExcluir = "-1";
if (isset($_GET['CPF'])) {
  $colname_rsExcluir = $_GET['CPF'];
}
mysql_select_db($database_teste, $teste);
$query_rsExcluir = sprintf("SELECT * FROM clientes WHERE CPF = %s", GetSQLValueString($colname_rsExcluir, "int"));
$rsExcluir = mysql_query($query_rsExcluir, $teste) or die(mysql_error());
$row_rsExcluir = mysql_fetch_assoc($rsExcluir);
$totalRows_rsExcluir = mysql_num_rows($rsExcluir);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsExcluir);
?>
