<?php

class WA_Newsletter_Module extends WA_Module
{



    public function init()
    {
        $this->loader->add_action('wp_ajax_suscribenewsletter', $this, 'wa_suscribe_multiple_lists', 10, 1);
        $this->loader->add_action('wp_ajax_nopriv_suscribenewsletter', $this, 'wa_suscribe_multiple_lists', 10, 1);

        // add_action('wp_ajax_suscribenewsletter', array($this, 'wa_suscribe_multiple_lists')); // wp_ajax_{action}
        // add_action('wp_ajax_nopriv_suscribenewsletter', array($this, 'wa_suscribe_multiple_lists')); // wp_ajax_nopriv_{action}
    }


    public function wa_suscribe_multiple_lists()
    {
        $sendy_url = 'https://mailing.technology/';
        $default_list = 'wvZ9Dq1ASFQQhKeWQ7ETdA';
        $api_key = "sO9R7HY30YJgSo2sKAed";
        $lists = $_POST['lists'];
        // $name = $_POST['nombre'];
        $email = $_POST['email'];

        //Loop through the checkboxes and add them to Sendy if checked
        $results[] = "";

        foreach ($lists as $list) {

            print_r($list);
            //-------- Subscribe --------//
            $postdata = http_build_query(
                array(
                    'email' => $email,
                    'list' => $list,
                    'api_key' => $api_key,
                    'boolean' => 'true'
                )
            );
            $opts = array('http' => array('method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata));
            $context  = stream_context_create($opts);
            $results[] = file_get_contents($sendy_url . '/subscribe', false, $context);
            //-------- Subscribe --------//
        }

        echo implode("\n", $results);

        die; // here we exit the script and even no wp_reset_query() required!
    }
}
