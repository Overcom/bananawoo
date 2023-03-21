<?php

require __DIR__ . '/../../vendor/autoload.php';

use Automattic\WooCommerce\Client;


global $wpdb;

$urlBananaProducts = 'https://server.bananaerp.com/api/access/products/';
$urlBananaCategories = 'https://server.bananaerp.com/api/access/categories';
$tokenBanana =null;

//$consumer_key_Woo = tokenWoo(0);
//$consumer_secret_Woo = tokenWoo(1);
// $urlWoo = "http://pruebas.local/wp-json/wc/v3/products/categories?consumer_key=" . $consumer_key_Woo . "&consumer_secret=" . $consumer_secret_Woo . "";
$urlWoo = "https://".$_SERVER['HTTP_HOST'];
$params = array(
    'headers' =>  array(
        //'consumer_key' => $consumer_key_Woo,
        //'consumer_secret' => $consumer_secret_Woo,
    ),
);






/**
 * Extraer token banana
 *
 * @return string
 */
function extractTokenBanana()
{
    global $wpdb;
    $sql_banana = "SELECT * FROM {$wpdb->prefix}bn_keys limit 1";
    $res_banana = $wpdb->get_results($sql_banana, ARRAY_A);
    if ($res_banana > 0) {
        foreach ($res_banana as $key => $value) {
            //echo  json_encode( $res_banana); exit;
            return $value['tokenBn'];
        }
    }
}

/** 
 * Capturar tokens wocomerce 
 *
 * @param  int $num indice de arreglo
 * @return  Array true 0 consumer_key , 1 consumer_secret 
 * @return string false
 */
function tokenWoo($num)
{
    global $wpdb;
    $tokensWoo = [];
    $sql = "SELECT * FROM {$wpdb->prefix}bn_keys limit 1";
    $res = $wpdb->get_results($sql, ARRAY_A);

    if ($res > 0 ) {

        foreach ($res as $key => $value) {
            //var_dump($value);
            $tokensWoo[] =  $value['consumer_key'];
            $tokensWoo[] =  $value['consumer_secret'];
        }
    } else {
        $tokensWoo = $num;
    }

    return $tokensWoo[$num];
}

function aunthenticationWoo($consumer_key_Woo, $consumer_secret_Woo, $urlWoo)
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
