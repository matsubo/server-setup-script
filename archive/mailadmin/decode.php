<?php
/*
 ** Decode encrypted mail address
 *
 * 2005/1/29 matsu@ht.sfc.keio.ac.jp
 */

require_once("config.inc");
require_once("classes/TransformTable.php");


$action = new TransformTable();
$raw = $_GET['address'];
$decode1 = base64_decode($raw);
$decode2 = $action->decode($decode1);


?>

<html>
<head>
<title>Mail administrator</title>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />

<link href="main.css" style="text/css" rel="stylesheet"/>
</head>

<body>


<H1>Decode encrypted mail address</H1>

<form action="decode.php">

<input type="text" size="30" name="address" value="<?php print $raw; ?>">
<input type="submit" value="decrypt">

<br>
<br>
result:<?php print $decode2; ?>

</form>

<a href="index.html">トップへ戻る</a>


</body>
</html>

