<?php

if (! function_exists('sanitize_html')) {
    function sanitize_html($data) {
        $data = strip_tags($data, "<h3><p><a><ul><ol><li><blockquote><strong><em>");
        $data = str_replace("<p></p>","",$data);
        return str_replace("<p>&nbsp;</p>","",$data);
    }
}
