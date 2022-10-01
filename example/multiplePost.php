<?php
error_reporting(0);
header("Content-Type: application/json; charset=utf-8");
require("../V4/wpcomment.php");

use wpcomment\bot;

if($_POST) {
    extract($_POST);

    $sendcomment = \wpcomment\bot::sendComment($post_address, array(
        "comment" => $comment,
        "author" => $author,
        "email" => $email,
        "site_address" => $site_address
    ));

    die(json_encode($sendcomment));
}
?>
