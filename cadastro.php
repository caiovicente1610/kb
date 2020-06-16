<?php require_once('Connections/teste.php'); ?><?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "falha.html";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO clientes (Nome, CPF, RG, `Data de Nasc`, Telefone, `End 1`, End2) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Nome'], "text"),
                       GetSQLValueString($_POST['CPF'], "text"),
                       GetSQLValueString($_POST['RG'], "int"),
                       GetSQLValueString($_POST['Data_de_Nasc'], "date"),
                       GetSQLValueString($_POST['Telefone'], "text"),
                       GetSQLValueString($_POST['End_1'], "text"),
                       GetSQLValueString($_POST['End2'], "text"));

  mysql_select_db($database_teste, $teste);
  $Result1 = mysql_query($insertSQL, $teste) or die(mysql_error());

  $insertGoTo = "cadastro.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE clientes SET Nome=%s, RG=%s, Telefone=%s, End2=%s WHERE CPF=%s",
                       GetSQLValueString($_POST['Nome'], "text"),
                       GetSQLValueString($_POST['RG'], "int"),
                       GetSQLValueString($_POST['Telefone'], "int"),
                       GetSQLValueString($_POST['End2'], "text"),
                       GetSQLValueString($_POST['CPF'], "int"));

  mysql_select_db($database_teste, $teste);
  $Result1 = mysql_query($updateSQL, $teste) or die(mysql_error());
}

$colname_Recordset9 = "-1";
if (isset($_GET[''])) {
  $colname_Recordset9 = $_GET[''];
}
mysql_select_db($database_teste, $teste);
$query_Recordset9 = sprintf("SELECT * FROM clientes WHERE Nome LIKE %s ", GetSQLValueString("%" . $colname_Recordset9 . "%", "text"));
$Recordset9 = mysql_query($query_Recordset9, $teste) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

$colname_CPF = "-1";
if (isset($_GET[''])) {
  $colname_CPF = $_GET[''];
}
mysql_select_db($database_teste, $teste);
$query_CPF = sprintf("SELECT * FROM clientes WHERE CPF LIKE %s", GetSQLValueString("%" . $colname_CPF . "%", "int"));
$CPF = mysql_query($query_CPF, $teste) or die(mysql_error());
$row_CPF = mysql_fetch_assoc($CPF);
$totalRows_CPF = mysql_num_rows($CPF);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cadastro de clientes</title>
<style type="text/css">
<!--
.style1 {
	font-family: "Times New Roman", Times, serif;
	font-size: 18px;
	color: #000066;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
//-->
</script>
</head>

<body>
<form method="post" name="form1" class="style1" id="form1">
  <p>Formulário de cadastro de cliente  </p>
</form>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form2" id="form2">
  <table align="left" bgcolor="#0066FF">
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#006699">Nome:</td>
      <td><input name="Nome" type="text" id="Nome" value="<?php echo $row_Recordset9['Nome']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CPF:</td>
      <td><input name="CPF" type="text" id="CPF" value="<?php echo $row_Recordset9['CPF']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">RG:</td>
      <td><input name="RG" type="text" id="RG" value="<?php echo $row_Recordset9['RG']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Data de Nasc:</td>
      <td><input name="Data_de_Nasc" type="text" id="Data_de_Nasc" value="<?php echo $row_Recordset9['Data de Nasc']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefone:</td>
      <td><input name="Telefone" type="text" id="Telefone" value="<?php echo $row_Recordset9['Telefone']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">End 1:</td>
      <td><input name="End_1" type="text" id="End_1" value="<?php echo $row_Recordset9['End 1']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">End2:</td>
      <td><input type="text" name="End2" value="<?php echo $row_Recordset9['End2']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" onclick="MM_validateForm('Nome','','R','CPF','','RisNum','RG','','R','Data_de_Nasc','','R','Telefone','','RisNum','End_1','','R');MM_popupMsg('Cadastro efetuado com sucesso!');return document.MM_returnValue" value="Gravar registro" /></td>
    </tr>
  </table>
  <div align="left">
    <input type="hidden" name="MM_insert" value="form2" />
    <label></label>
  </div>
    <input type="hidden" name="MM_update" value="form2" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form action="" method="post" name="form4" class="style1" id="form4">
Consultar
</form>
<form id="form3" name="form1" method="get" action="mestre.php">
  <label>Buscar por nome
  <input name="Nome" type="text" id="Nome" />
  </label>
  <label>
  <input type="submit" name="99" id="99" value="Enviar" />
  </label>
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset9);

mysql_free_result($CPF);
?>