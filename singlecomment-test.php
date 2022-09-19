<?php
error_reporting(0);
$dir = __DIR__;
require($dir . "/V4/wpcomment.php");

use wpcomment\bot;

    $singlecomment = \wpcomment\bot::sendComment("https://leventemre.com/example-post/", array(
        "comment" => "test comment",
        "author" => "v4r1able",
        "email" => "test@example.com",
        "site_address" => "example.com"
    )); 

    print_r($singlecomment);

?>