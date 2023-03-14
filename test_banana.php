<?php

use Automattic\WooCommerce\Admin\API\Products;
use Composer\Installers\Plugin;
use Automattic\WooCommerce\Client;

global $wpdb;
/**
 * Plugin Name: Banana ERP
 * Plugin URI: https://pablomonteserin.com
 * Description: Conecta tus paginas web con banana
 * Version: 1.0.0
 * Author: Louis Sarmiento
 * Author URI: 
 * License: GPL2
 */
function tokenBanana()
{
    global $wpdb;
    $sql = "SELECT * FROM wp_bn_keys  LIMIT 1";
    $res = $wpdb->get_results($sql, ARRAY_A);

    // $tokenBanana = null;
    foreach ($res as $key => $value) {
        //var_dump($value);
        return $value['tokenBn'];
    }

    // var_dump($tokenBanana);
}


/**
 * Capturar Tokens de woocomerce
 *
 * @return array [0] consumer_key ,[1] consumer_secret
 */
function tokenWoo()
{
    global $wpdb;

    $tokenWoo = [];
    $sql = "SELECT * FROM wp_bn_keys  LIMIT 1";
    $res = $wpdb->get_results($sql, ARRAY_A);

    // $tokenBanana = null;
    foreach ($res as $key => $value) {
        //var_dump($value);
        $tokenWoo[] =  $value['consumer_key'];
        $tokenWoo[] =  $value['consumer_secret'];
        return $tokenWoo;
    }
}



// Variables petición  Banana API 
$urlBanana = 'https://server.bananaerp.com/api/access/products/';
$method = 'GET';
$tokenBanana = tokenBanana();

$consumer_key_Woo = tokenWoo()[0];
$consumer_secret_Woo = tokenWoo()[1];
// $urlWoo = "http://pruebas.local/wp-json/wc/v3/products/categories?consumer_key=" . $consumer_key_Woo . "&consumer_secret=" . $consumer_secret_Woo . "";
$urlWoo = "https://pruebas.local/wp-json/wc/v3/products/categories";
$params = [
    'consumer_key' => $consumer_key_Woo,
    'consumer_secret' => $consumer_secret_Woo,
    'sslverify' => false,
];
//var_dump($tokenBanana);
// var_dump($res[0]); exit();
/* function wp_remote_get($url, $args = array())
{
    $http = _wp_http_get_object();
    return $http->get($url, $args);
} */

/**
 * Metodo para auntenticaren woo
 * 
 * @return ;
 */
function aunthenticationWoo($urlWoo, $params)
{
    $response = wp_remote_get($urlWoo, $params);

    if (is_array($response) && !is_wp_error($response)) {
        $headers = $response['headers']; // array of http header lines
        $body    = $response['body']; // use the content
    } else {
        var_dump($response);
    }
}
// aunthenticationWoo($urlWoo, $params);


/**
 * autenticación de banana
 * 
 * @param string $url Url de peticion
 * @param string $token token de seguridad
 * @param string $method  get,post,pup etc
 * @return object
 */
function productosBanana($urlBanana, $tokenBanana)
{
    $params = array(
        'headers' =>  array(
            'token' => $tokenBanana,
            'organization' => 1,
        ),
    );

    $response = wp_remote_get($urlBanana, $params);

    $body_https = $response['body'];
    $products = json_decode($body_https);
    
    return $products->products;
}
function activar()
{
    global $wpdb;

    $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}bn_keys(
            `id_key` int NOT NULL AUTO_INCREMENT,
            `user_id` int NOT NULL,
            `name_api` varchar(50),
            `permissions` varchar(100) NOT NULL,
            `description` varchar(100) NOT NULL,
            `tokenBn` varchar(500) NOT NULL,
            `consumer_key` varchar(500) NOT NULL,
            `consumer_secret`  varchar(500) NOT NULL,
            PRIMARY KEY (`id_key`)
        )";

    $wpdb->query($sql);
    //echo $sql; exit();



}
function botonDesactivar()
{
}

register_activation_hook(__FILE__, 'activar');
register_deactivation_hook(__FILE__, 'botonDesactivar');


add_action('admin_menu', 'menuBanana');

function menuBanana()
{
    add_menu_page(
        'Claves API RES', //cambiar titulo
        'Banana', //titulo menu
        'manage_options', //permisos
        plugin_dir_path(__FILE__) . 'admin/index.php',
        null,
        null, //icono
        '8' //position del menu
    );
    // add_submenu_page(
    //     'bn_menu_parent',
    //     'Agregar llaves',
    //     'Agregar llave',
    //     'manage_options',
    //     'bn_submenu_add_llaves',
    //     'Add'
    // );

    // function Rpt() //Ver llaves
    // {
    //     $templateRpt = plugin_dir_path(__FILE__) . 'admin/rpt_llaves.php'; //url

    //     return '<script language="javascript">window.location.href="' . $templateRpt . '" </script>';
    // }
    // function Add() //Anadir llave
    // {
    //     $templateAdd = plugin_dir_path(__FILE__) . 'admin/add_llaves.php'; //url

    //     return '<script language="javascript">window.location.href="' . $templateAdd . '" </script>';
    // }

}

//LLAMADA DE ARCHIVOS

/**
 * LLamar a bostrap js
 *
 * 
 */
function callBootstrapJs()
{
    wp_enqueue_script('bootstrapJs', plugins_url('admin/bootstrap/js/bootstrap.min.js', __FILE__), array('jquery'));
}
add_action('admin_enqueue_scripts', 'callBootstrapJs');


/**
 * Llamar a BostrapcSS
 *
 * 
 */
function callBootstrapCss()
{
    wp_enqueue_style('callBootstrapCss', plugins_url('admin/bootstrap/css/bootstrap.min.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'callBootstrapCss');


/**
 * Llamar estilos css
 *
 * 
 */
function callStyles()
{
    wp_enqueue_style('callStyles', plugins_url('admin/bootstrap/styles/index.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'callStyles');

/**
 * llamar Scrips js
 */
function callJs()
{
    wp_enqueue_script('mainJs', plugins_url('admin/bootstrap/scripts/main.js', __FILE__), array('jquery'));
}
add_action('admin_enqueue_scripts', 'callJs');

/**
 * llamar a font Awesome 
 *
 * 
 */
function callFontAwesomeCnd()
{
    wp_enqueue_style('load-fa', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css');
}
add_action('admin_enqueue_scripts', 'callFontAwesomeCnd');
