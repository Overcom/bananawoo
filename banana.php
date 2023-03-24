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
function activar(){
}

/**
 * desactivar plugin
 *
 * @return  array
 */
function botonDesactivar(){
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



