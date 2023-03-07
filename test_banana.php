<?php

use Composer\Installers\Plugin;

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

// Variables peticion  Banana API ''
$urlBanana = 'https://server.bananaerp.com/api/access/products/';
$method = 'GET';

// var_dump($res[0]); exit();


/**
 * Api res Banana WOO 
 * 
 * @param string $url Url de peticion
 * @param string $token token de seguridad
 * @param string $method  get,post,pup etc
 * @return object
 */
function apiBananaWoo($urlBanana, $method)
{
    global $wpdb;

    $sql = "SELECT * FROM wp_bn_keys LIMIT 1";
    $res = $wpdb->get_results($sql, ARRAY_A);

    // $tokenBanana = null;
    foreach ($res as $key => $value) {
        var_dump($value);
        $tokenBanana = $value['api_key'];
    }

    // var_dump($tokenBanana);

    $opciones = array(
        'http' => array(
            'header' =>  'token: ' . $tokenBanana,
            'method' => $method,
        ),
    );

    $contexto = stream_context_create($opciones);

    $res = file_get_contents($urlBanana, false, $contexto);

    if ($res === false) {
        echo "Error en la peticion ";
        exit;
    } else {
        $object = json_decode($res)->products;
        var_dump($object);
    }
}
apiBananaWoo($urlBanana, $method);


function botonActivar()
{
    global $wpdb;

    $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}bn_keys(
            `id_key` int NOT NULL AUTO_INCREMENT,
            `user_id` int NOT NULL,
            `name_api` varchar(50),
            `permissions` varchar(100) NOT NULL,
            `description` varchar(100) NOT NULL,
            `api_key` varchar(500) NOT NULL,
            `consumer_key` varchar(500) NOT NULL,
            PRIMARY KEY (`id_key`))";

    $wpdb->query($sql);
    //echo $sql; exit();



}
function botonDesactivar()
{
}

register_activation_hook(__FILE__, 'botonActivar');
register_deactivation_hook(__FILE__, 'botonDesactivar');


add_action('admin_menu', 'menuBanana');

function menuBanana()
{
    add_menu_page(
        'Claves API RES', //cambiar titulo
        'Banana', //titulo menu
        'manage_options', //permisos
        plugin_dir_path(__FILE__) . 'admin/rpt_llaves.php',
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

//llamar Boostrap

function callBootstrapJs($hook)
{

    //echo "<script>console.log('$hook')</script>";
    // if ($hook != 'banana/admin/rpt_llaves.php') {
    //     return;
    // }
    wp_enqueue_script('bootstrapJs', plugins_url('admin/bootstrap/js/bootstrap.min.js', __FILE__), array('jquery'));
}
add_action('admin_enqueue_scripts', 'callBootstrapJs');

function callBootstrapCss($hook)
{

    //echo "<script>console.log('$hook')</script>";
    // if ($hook != 'banana/admin/rpt_llaves.php') {
    //     return;
    // }
    wp_enqueue_style('callBootstrapCss', plugins_url('admin/bootstrap/css/bootstrap.min.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'callBootstrapCss');

//encolar archivos
function callJs($hook)
{

    //echo "<script>console.log('$hook')</script>";
    // if ($hook != 'banana/admin/rpt_llaves.php') {
    //     return;
    // }
    wp_enqueue_script('mainJs', plugins_url('admin/bootstrap/scripts/main.js', __FILE__), array('jquery'));
}
add_action('admin_enqueue_scripts', 'callJs');

// function callFontAwesome(){
//     wp_enqueue_style('callFontAwesome',plugins_url('admin/font-awesome/css/font-awesome.min.css',__FILE__));
// }
// add_action('admin_enqueue_scripts','callFontAwesome');

function callFontAwesomeCnd()
{
    wp_enqueue_style('load-fa', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css');
}
add_action('admin_enqueue_scripts', 'callFontAwesomeCnd');
