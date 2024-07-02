<?php

class WA_Shortcodes_Module extends WA_Module
{

    public function init()
    {

        // $this->load_config();

        add_shortcode('webadictos', array($this, 'shortcode_handler'), 10, 2);
        remove_filter('the_content', 'wpautop');
        add_filter('the_content', array($this, 'remove_wpautop_in_front'), 10, 1);
        // add_filter('the_content', array($this, 'remove_unused_shortcodes'), 10, 1);
    }


    public function shortcode_handler($atts, $content = null)
    {
        $fixedAtts = array();

        foreach ($atts as $k => $v) {
            // Convert boolean strings to boolean values
            if ($v === "false" || $v === "true") {
                $v = filter_var($v, FILTER_VALIDATE_BOOLEAN);
            } elseif (strpos($v, '|') !== false) {
                // If value contains '|', parse it as a simple array
                $v = explode('|', $v);
            } elseif (strpos($v, ':') !== false && strpos($v, '{') === false) {
                // If value contains ':' and does not contain '{', parse it as an associative array
                $v = $this->parse_associative_array($v);
            } elseif (strpos($v, '{') !== false && strpos($v, '}') !== false) {
                // If value contains '{' and '}', parse it as a nested array
                $v = $this->parse_nested_array($v);
            }

            $fixedAtts[$k] = $v;
        }

        // Copy 'query_args' to 'queryArgs' for backward compatibility
        if (isset($fixedAtts['query_args'])) {
            $fixedAtts['queryArgs'] = $fixedAtts['query_args'];
        }

        $atts = $fixedAtts;

        // Handle title attribute
        if (isset($atts['title']) && !is_null($atts['title'])) {
            $atts['section_name'] = $atts['title'];
        }

        // Handle content description
        if (!is_null($content)) {
            $atts['section_description'] = $content;
        }


        // Output buffering for template part rendering
        ob_start();



        // If 'modulo' attribute is not specified, return empty string
        if (empty($atts['modulo'])) {
            return ob_get_clean();
        }

        // Include template part with attributes
        get_template_part('template-parts/' . $atts['modulo'], null, $atts);

        return ob_get_clean();
    }

    private function parse_associative_array($string)
    {
        $result = array();
        $pairs = explode(",", $string);
        foreach ($pairs as $pair) {
            list($key, $value) = explode(":", $pair, 2);
            $result[trim($key)] = trim($value);

            if (is_string($result[trim($key)]) && ($result[trim($key)] === "false" || $result[$key] === "true")) {
                $result[trim($key)] = filter_var($result[trim($key)], FILTER_VALIDATE_BOOLEAN);
            }
        }
        return $result;
    }

    private function parse_nested_array($string)
    {
        // Initialize result array
        $result = array();

        // Define regex pattern to match key-value pairs
        $pattern = '/([a-zA-Z0-9_\-]+)\s*:\s*(\{(?:[^{}]+|(?R))*\}|[^,{}]+)/';

        // Match all key-value pairs in the string
        preg_match_all($pattern, $string, $matches, PREG_SET_ORDER);

        // Iterate through matched pairs
        foreach ($matches as $match) {
            $key = trim($match[1]);
            $value = trim($match[2]);

            // Check if value is a nested array (contains curly braces)
            if (strpos($value, '{') !== false && strpos($value, '}') !== false) {
                // Recursively parse nested array
                $result[$key] = $this->parse_nested_array(substr($value, 1, -1));
            } elseif (strpos($value, ':') !== false && strpos($value, ',') !== false) {
                // Check if value is an associative array (contains ':' and ',')
                $result[$key] = $this->parse_associative_array($value);
            } else {
                // Otherwise, treat as simple key-value pair
                $result[$key] = $value;
            }
        }

        return $result;
    }



    public function shortcode_handler_bk($atts, $content = null)
    {

        $fixedAtts = array();

        foreach ($atts as $k => $v) {


            if ($v === "false" || $v === "true") {
                $v = filter_var($v, FILTER_VALIDATE_BOOLEAN);
            }

            $fixedAtts[$k] = $v;
        }

        $atts = $fixedAtts;

        if (isset($atts['title']) && !is_null($atts['title'])) $atts['section_name'] = $atts['title'];

        if (isset($atts['query_args']) && !is_null($atts['query_args'])) {
            $_query = explode(",", $atts['query_args']);
            $queryArgs = array();
            foreach ($_query as $q) {
                $vals = explode(":", $q);

                if ($vals[1] === "false" || $vals[1] === "true") {
                    $vals[1] = filter_var($vals[1], FILTER_VALIDATE_BOOLEAN);
                }

                $queryArgs[$vals[0]] = $vals[1];
            }

            $atts['queryArgs'] = $queryArgs;
        }

        if (isset($atts['items_config']) && !is_null($atts['items_config'])) {
            $_query = explode(",", $atts['items_config']);
            $queryArgs = array();
            foreach ($_query as $q) {
                $vals = explode(":", $q);

                if ($vals[1] === "false" || $vals[1] === "true") {
                    $vals[1] = filter_var($vals[1], FILTER_VALIDATE_BOOLEAN);
                }

                $queryArgs[$vals[0]] = $vals[1];
            }

            $atts['items_config'] = $queryArgs;
        }




        if (!is_null($content)) {
            $atts['section_description'] = $content;
        }




        ob_start();
        print_r($atts);
        //Si no especifican módulo se devuelve cadena vacia.
        if (isset($atts['modulo'])) return ob_get_clean();

        get_template_part('template-parts/' . $atts['modulo'], null, $atts);


        return ob_get_clean();
    }

    public function remove_wpautop_in_front($content)
    {
        if (is_home() || is_front_page() || is_page())
            return $content;
        else
            return wpautop($content);
    }


    public function remove_unused_shortcodes($content)
    {
        $pattern = $this->unused_shortcode_regex();
        $content = preg_replace_callback('/' . $pattern . '/s', 'strip_shortcode_tag', $content);
        return $content;
    }

    public function unused_shortcode_regex()
    {
        global $shortcode_tags;
        $tagnames = array_keys($shortcode_tags);
        $tagregexp = join('|', array_map('preg_quote', $tagnames));
        $regex = '\\[(\\[?)';
        $regex .= "(?!$tagregexp)";
        $regex .= '\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
        return $regex;
    }
}
