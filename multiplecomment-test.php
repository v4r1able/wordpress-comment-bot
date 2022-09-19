<?php
error_reporting(0);
$dir = __DIR__;
require($dir . "/V4/wpcomment.php");

use wpcomment\bot;

    $postadresses_array = array(
        "https://leventemre.com/example-post/",
        "https://example.com/test/test-post/"
    );
    $multiplecomment = \wpcomment\bot::sendCommentMultiple($postadresses_array, array(
        "comment" => "test comment",
        "author" => "v4r1able",
        "email" => "test@example.com",
        "site_address" => "example.com"
    ));

    print_r($multiplecomment);

?>