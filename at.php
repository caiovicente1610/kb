<?php require_once('Connections/teste.php'); ?><?php
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE clientes SET Nome=%s, RG=%s, `Data de Nasc`=%s, Telefone=%s, `End 1`=%s, End2=%s WHERE CPF=%s",
                       GetSQLValueString($_POST['Nome'], "text"),
                       GetSQLValueString($_POST['RG'], "int"),
                       GetSQLValueString($_POST['Data_de_Nasc'], "date"),
                       GetSQLValueString($_POST['Telefone'], "int"),
                       GetSQLValueString($_POST['End_1'], "text"),
                       GetSQLValueString($_POST['End2'], "text"),
                       GetSQLValueString($_POST['CPF'], "int"));

  mysql_select_db($database_teste, $teste);
  $Result1 = mysql_query($updateSQL, $teste) or die(mysql_error());

  $updateGoTo = "cadastro.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_GET['CPF'])) && ($_GET['CPF'] != "")) {
  $deleteSQL = sprintf("DELETE FROM clientes WHERE CPF=%s",
                       GetSQLValueString($_GET['CPF'], "int"));

  mysql_select_db($database_teste, $teste);
  $Result1 = mysql_query($deleteSQL, $teste) or die(mysql_error());
}

$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_teste, $teste);
$query_DetailRS1 = sprintf("SELECT * FROM clientes  WHERE Nome = %s", GetSQLValueString($colname_DetailRS1, "text"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $teste) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Atualizar registros</title>
<style type="text/css">
<!--
.style1 {
	color: #000099;
	font-size: 24px;
}
-->
</style>
</head>

<body>
<table width="367" border="1" align="left">
  <tr>
    <td width="84">Nome</td>
    <td width="243"><?php echo $row_DetailRS1['Nome']; ?> </td>
  </tr>
  <tr>
    <td>CPF</td>
    <td><?php echo $row_DetailRS1['CPF']; ?> </td>
  </tr>
  <tr>
    <td>RG</td>
    <td><?php echo $row_DetailRS1['RG']; ?> </td>
  </tr>
  <tr>
    <td>Data de Nasc</td>
    <td><?php echo $row_DetailRS1['Data de Nasc']; ?> </td>
  </tr>
  <tr>
    <td>Telefone</td>
    <td><?php echo $row_DetailRS1['Telefone']; ?> </td>
  </tr>
  <tr>
    <td>End 1</td>
    <td><?php echo $row_DetailRS1['End 1']; ?> </td>
  </tr>
  <tr>
    <td>End2</td>
    <td><?php echo $row_DetailRS1['End2']; ?> </td>
  </tr>
</table>

<form id="form1" name="form1" method="post" action="">
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form id="form3" name="form3" method="post" action="">
  <input name="hiddenField" type="hidden" id="hiddenField" />
  <input type="submit" name="button2" id="button2" value="Submit" />
</form>
<p class="style1">&nbsp;</p>
<p class="style1">
  <label></label> 
  Atualizar Registro
</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table border="1" align="left">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nome:</td>
      <td><input type="text" name="Nome" value="<?php echo htmlentities($row_DetailRS1['Nome'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CPF:</td>
      <td><?php echo $row_DetailRS1['CPF']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">RG:</td>
      <td><input type="text" name="RG" value="<?php echo htmlentities($row_DetailRS1['RG'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Data de Nasc:</td>
      <td><input type="text" name="Data_de_Nasc" value="<?php echo htmlentities($row_DetailRS1['Data de Nasc'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefone:</td>
      <td><input type="text" name="Telefone" value="<?php echo htmlentities($row_DetailRS1['Telefone'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">End 1:</td>
      <td><input type="text" name="End_1" value="<?php echo htmlentities($row_DetailRS1['End 1'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">End2:</td>
      <td><input type="text" name="End2" value="<?php echo htmlentities($row_DetailRS1['End2'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Atualizar registro" /> 
        <a href="delete.php?CPF=<?php echo $row_DetailRS1['CPF']; ?>">Excluir</a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2" />
</form>
<form id="form5" name="form5" method="post" action="">
  <input type="hidden" name="CPF" value="<?php echo $row_DetailRS1['CPF']; ?>" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form id="form4" name="form4" method="post" action="cadastro.php">
  <label>
  <input type="submit" name="button" id="button" value="Voltar para cadastro" />
  </label>
</form>
<p>&nbsp;</p>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>
