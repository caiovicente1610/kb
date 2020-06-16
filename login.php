<?php require_once('Connections/teste.php'); ?><?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

mysql_select_db($database_teste, $teste);
$query_Recordset1 = "SELECT admin FROM login";
$Recordset1 = mysql_query($query_Recordset1, $teste) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=$_POST['pass'];
  $MM_fldUserAuthorization = "admin";
  $MM_redirectLoginSuccess = "cadastro.php";
  $MM_redirectLoginFailed = "falha.html";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_teste, $teste);
  	
  $LoginRS__query=sprintf("SELECT `admin`, pass, admin FROM login WHERE `admin`=%s AND pass=%s",
  GetSQLValueString($loginUsername, "-1"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $teste) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'admin');
    
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Página de login</title>
</head>

<body>
<form ACTION="<?php echo $loginFormAction; ?>" method="POST" enctype="application/x-www-form-urlencoded" name="form1" target="_top" id="form1">
  <label>Nome
  <input name="user" type="text" id="user" />
</label>
  <p>
    <label>Senha
    <input type="password" name="pass" id="pass" />
    </label>
  </p>
  <p>
    <label>
    <input type="submit" name="bt" id="bt" value="Logar" />
    </label>
  </p>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>