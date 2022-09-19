# WordPress Comment Bot

* Single and multiple sending feature
* Works on php 5.6.0 or higher

Add the "bot" class to your file
-----------------------
```php
$directory = __DIR__;
require($directory . '/V4/wpcomment.php');

use wpcomment\bot;
```

Single Comment Post Example
-----------------------
```php
$singlecomment = \wpcomment\bot::sendComment("https://leventemre.com/test/example-post/", array(
    "comment" => "test comment",
    "author" => "v4r1able",
    "email" => "test@example.com",
    "site_address" => "example.com"
));

// print return array
print_r($singlecomment);
```

Output:
```
Array
(
    [status] => 1
    [comment_address] => https://leventemre.com/test/example-post/
    [message] => Comment posted, check it out
)
```

Multiple Comment Post Example
-----------------------
```php
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

// print return array
print_r($multiplecomment);
```

Output:
```
Array
(
    [0] => Array
        (
            [status] => 0
            [comment_address] => https://leventemre.com/example-post/
            [message] => You have posted the same comment before or have been blocked by this site. Failed to submit comment
        )

    [1] => Array
        (
            [status] => 0
            [comment_address] => https://example.com/test/test-post/
            [message] => example.com could not find post_id data of address
        )

)
```