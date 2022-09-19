<?php
/**
 * V4R1 Wordpress Comment Bot
 *
 * @author Levent Emre PAÇAL
 * @web https://leventemre.com
 * @update 20 Sep 2022
*/

namespace wpcomment;

class bot {

    private static function basic_cURL($address) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $address);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $cikti = curl_exec($ch);
        return $cikti;
    }

    public static function sendComment($postaddress, $variables = array()) {
    $gir = self::basic_cURL($postaddress);
    preg_match_all("@<input type='hidden' name='comment_post_ID' value='(.*?)'@si", $gir, $post_id);
    $post_id = $post_id[1][0];
    $postaddress_curl = "https://".parse_url($postaddress)["host"]."/wp-comments-post.php";

        if(empty(trim($post_id))) {
        return [
            "status" => 0,
            "comment_address" => htmlspecialchars($postaddress),
            "message" => parse_url($postaddress)["host"]." could not find post_id data of address"
        ];
        } else {
        $postfields = array(
            "comment" => $variables["comment"],
            "author" => $variables["author"],
            "email" => $variables["email"],
            "url" => $variables["site_address"],
            "comment_post_ID" => $post_id,
            "comment_parent" => 0
        );
        $ch = curl_init($postaddress_curl);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.79 Safari/537.36");
        curl_setopt($ch, CURLOPT_REFERER, $postaddress);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        $index = curl_exec($ch);
        
        if(strstr($index, "error-page")) {
        return [
            "status" => 0,
            "comment_address" => htmlspecialchars($postaddress),
            "message" => "You have posted the same comment before or have been blocked by this site. Failed to submit comment"
        ];
        } else {
        if(strstr($index, "comment-awaiting-moderation")) {
        return [
            "status" => 1,
            "comment_address" => htmlspecialchars($postaddress),
            "message" => "The comment probably fell into the approval process"
        ];
        } else {
        return [
            "status" => 1,
            "comment_address" => htmlspecialchars($postaddress),
            "message" => "Comment posted, check it out"
        ];
        }

        }
    }
    }

    public static function sendCommentMultiple($postaddresses = array(), $variables = array()) {
        $outputs = array();
        foreach($postaddresses as $postaddress) {
            $sendcomment = self::sendComment($postaddress, $variables);
            array_push($outputs, $sendcomment);
        }
        return $outputs;
    }

}
?>