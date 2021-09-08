<?php

if (!function_exists("sanitize_html")) {
    function sanitize_html($data)
    {
        $data = strip_tags($data, "<h3><p><a><ul><ol><li><blockquote><strong><em>");
        $data = str_replace("<p></p>", "", $data);
        $data = str_replace("•  ", "", $data);
        return str_replace("<p>&nbsp;</p>", "", $data);
    }
}

if (!function_exists("append_query")) {
    function append_query($query)
    {
        return "?" . http_build_query(array_merge(Request()->except("page"), $query));
    }
}

if (!function_exists("convert_name_to_logo")) {
    function convert_name_to_logo($value)
    {
        if (count(explode(" ", $value)) > 1) {
            $first = explode(" ", $value)[0];
            $second = explode(" ", $value)[1];
            return "$first <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"25.2\" height=\"21\" viewbox=\"0 0 25.2 21\"><path fill=\"currentColor\" d=\"M.6 5.7L16 11.3 0 15.1 1.4 21l23.4-5.5.2-3.5.2-3.8L2.6 0z\"/></svg> $second";
        }
    }
}

// if (!function_exists("get_model_name")) {
//     function get_model_name($entry, $lowercase = false)
//     {
//         if (method_exists($entry, "total")) {
//             $name = get_class($entry->first())::$name;
//         } else {
//             $name = get_class($entry)::$name;
//         }
//         return $lowercase ? strtolower($name) : $name;
//     }
// }
