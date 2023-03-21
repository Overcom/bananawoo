<?php

/**
 * Plugin Name: BananaWoo
 * Plugin URI: https://pablomonteserin.com
 * Description: Administra tus productos 
 * Author: Overcom
 * Author URI:
 * License: GPL2
 * version: 0.1.2
 * Text Domain: banana
 */

global $wpdb;
defined('ABSPATH') or die("Por aquí no vamos a ninguna parte");
define('BN_DIR', plugin_dir_path(__FILE__));


/**
 * Activar plugin
 *
 * @return array
 */
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

    // $wpdb->query($sql);
    //echo $sql; exit();

}

/**
 * desactivar plugin
 *
 * @return  array
 */
function botonDesactivar()
{
    global $wpdb;
    $sql = "DELETE FROM {$wpdb->prefix}_bn_keys ";
    $wpdb->query($sql);
}

register_activation_hook(__FILE__, 'activar');
register_deactivation_hook(__FILE__, 'botonDesactivar');


//?--- MENUS -----------------------------

add_action('admin_menu', 'bn_menu');

function bn_menu()
{
    add_menu_page(
        'BananaWoo', //cambiar titulo
        'BananaWoo', //titulo menu
        'manage_options', //permisos
        BN_DIR . '/public/index.php',
        null,
        null, //icono
        '8' //position del menu
    );

    add_submenu_page(
        BN_DIR . '/public/index.php',
        'Configuración',
        'Configuración',
        'manage_options',
        BN_DIR . '/public/panel-config.php',
        null,
        '1'

    );
}

//?MÉTODOS FOR wooocomerce 

include plugin_dir_path(__FILE__).'admin/functions/products-woo.php';

//?MÉTODOS FOR PROPDUCTOS BANANA

include plugin_dir_path(__FILE__).'admin/functions/products-banana.php';

//?MÉTODOS FOR TOKENES

include plugin_dir_path(__FILE__).'admin/functions/tokens.php';

//? PATH ULR 
include plugin_dir_path(__FILE__).'src/rutes.php';



