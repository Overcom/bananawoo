<?php

require __DIR__ . '/vendor/autoload.php';

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


//? VARIABLES DE PETICIÓN -------------------------------------------------------------------------- 

$host = $_SERVER['HTTP_HOST'];
$urlBananaProducts = 'https://server.bananaerp.com/api/access/products/';
$urlBananaCategories = 'https://server.bananaerp.com/api/access/categories';
$method = 'GET';
$tokenBanana = tokenBanana();

$consumer_key_Woo = tokenWoo(0);
$consumer_secret_Woo = tokenWoo(1);
// $urlWoo = "http://pruebas.local/wp-json/wc/v3/products/categories?consumer_key=" . $consumer_key_Woo . "&consumer_secret=" . $consumer_secret_Woo . "";
$urlWoo = "https://" . $host;
$params = array(
    'headers' =>  array(
        'consumer_key' => $consumer_key_Woo,
        'consumer_secret' => $consumer_secret_Woo,
    ),
);


function aunthentication($consumer_key_Woo, $consumer_secret_Woo, $urlWoo)
{
    $woocommerce = new Client(
        $urlWoo,
        $consumer_key_Woo,
        $consumer_secret_Woo,
        [
            'wp_api' => true,
            'version' => 'wc/v3',
            'verify_ssl' => false
        ]
    );

    return $woocommerce;
}

$woocommerce = aunthentication($consumer_key_Woo, $consumer_secret_Woo, $urlWoo);

/**
 * Capturar token banana
 *
 * @return objetc
 */
function tokenBanana()
{
    global $wpdb;
    $sql = "SELECT * FROM {$wpdb->prefix}_bn_keys LIMIT 1";
    $res = $wpdb->get_results($sql, ARRAY_A);

    // $tokenBanana = null;
    foreach ($res as $key => $value) {
        //var_dump($value);
        return $value['tokenBn'];
    }

    // var_dump($tokenBanana);
}


/** 
 * Capturar tokens wocomerce 
 *
 * @param  int $num indice de arreglo
 * @return Array 0 consumer_key , 1 consumer_secret
 */
function tokenWoo($num)
{
    global $wpdb;
    $nombreBD = 'local';
    $tokensWoo = [];

    $ExistDB="SHOW TABLES FROM '" . $nombreBD . "' LIKE {$wpdb->prefix}_bn_keys";

    if ($ExistDB == true) {

        $sql = "SELECT * FROM {$wpdb->prefix}_bn_keys  LIMIT 1";
        $res = $wpdb->get_results($sql, ARRAY_A);
        foreach ($res as $key => $value) {
            //var_dump($value);
            $tokensWoo[] =  $value['consumer_key'];
            $tokensWoo[] =  $value['consumer_secret'];
        }
    }else{
        $tokensWoo = $num;
    }

    return $tokensWoo[$num];
}

/**
 * Metodo para auntenticaren woo
 * 
 * @return ;
 */
function categoriesWoo($woocommerce)
{
    return $woocommerce->get('products/categories');
}
categoriesWoo($woocommerce);



/**
 * Listar Productos Categorias y listados de 
 * banana
 * 
 * @param string $url Url de peticion
 * @param string $tokenBanana token de seguridad bana
 * @return object
 */
function productosBanana($url, $tokenBanana)
{
    $params = array(
        'headers' =>  array(
            'token' => $tokenBanana,
            'organization' => 1,
        ),
    );

    $response = wp_remote_get($url, $params);

    $body_https = $response['body'];
    $products = json_decode($body_https);

    return $products;
}

function activar()
{
    global $wpdb;

    $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}_bn_keys(
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
