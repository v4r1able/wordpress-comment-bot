<?php
error_reporting(0);

if($_POST) {
$tarih = date("Y-m-d");
$dosya = fopen("basarili-".$tarih, "a+");
fwrite($dosya, $_POST["comment_address"]."
");
fclose($dosya);
}
?>
