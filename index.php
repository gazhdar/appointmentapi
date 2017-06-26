<?php
/**
 * Plugin Name: Appointment API
 * Description: API for adding appointments for a form
 * Version: 1.0
 * Author: Rich Hildred
 * License: MIT
 */
require_once 'Slim/Slim.php';
require_once 'SlimWpOptions.php';

\Slim\Slim::registerAutoloader();
new \Slim\SlimWpOptions();

add_filter('rewrite_rules_array', function ($rules) {
    $new_rules = array(
        '('.get_option('slim_base_path','slim/api/').')' => 'index.php',
    );
    $rules = $new_rules + $rules;
    return $rules;
});

add_action('init', function () {
    if (strstr($_SERVER['REQUEST_URI'], get_option('slim_base_path','slim/api/'))) {
        $slim = new \Slim\Slim();
        do_action('slim_mapping',$slim);
        $slim->get("/slim/api/hello", function(){
            echo "hello world";
        });
        $slim->post("/slim/api/appointment", function(){
            wp_safe_redirect("/?page_id=6");
            exit;
            //echo "add appointment<br />";
            //echo json_encode($_POST);
        });
        $slim->run();
        exit;
    }
});