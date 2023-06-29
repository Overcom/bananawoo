<?php

require __DIR__ . '/../../vendor/autoload.php';

use Automattic\WooCommerce\Client;


global $wpdb;

$urlBananaProducts = 'https://server.bananaerp.com/api/access/products/';
$urlBananaCategories = 'https://server.bananaerp.com/api/access/categories';
$tokenBanana = null;

//$consumer_key_Woo = tokenWoo(0);
//$consumer_secret_Woo = tokenWoo(1);
// $urlWoo = "http://pruebas.local/wp-json/wc/v3/products/categories?consumer_key=" . $consumer_key_Woo . "&consumer_secret=" . $consumer_secret_Woo . "";
$urlWoo = "https://" . $_SERVER['HTTP_HOST'];
$params = array(
    'headers' =>  array(
        //'consumer_key' => $consumer_key_Woo,
        //'consumer_secret' => $consumer_secret_Woo,
    ),
);

/**
 * Extraer los tokens insertados en el archivo
 * bn-confi 
 *
 * @param object  $datos
 * @return array ,
 * 
 * 
 * tk_bn - token banana
 * 
 * ck - consumer key
 *  
 * cs - consumer secret
 */
function extractToken ($datos)
{
    $tokenBn = $datos->config->tk_bn;
    $ck = $datos->config->tk_woo->secret_key;
    $cs = $datos->config->tk_woo->consumer_Key;

    $tokens = array(
        'tk_bn' => $tokenBn,
        'ck' =>  $ck,
        'cs' => $cs,
    );
    return $tokens;
}

function authenticationWoo($consumer_key_Woo, $consumer_secret_Woo, $urlWoo)
{
    $ssl= true ;
    if ($_SERVER['REQUEST_SCHEME'] != 'https' ) {
        $ssl = false;
    }
    
    $woocommerce = new Client(
        $urlWoo,
        $consumer_secret_Woo,
        $consumer_key_Woo,
        [
            'wp_api' => true,
            'version' => 'wc/v3',
            'verify_ssl' => $ssl
        ]
    );

    return $woocommerce;
}

/**
 * Autenticar el registro de los tokens
 *
 * @param  object  $config
 * @return boolean
 */
function validationTokens($datos)
{
    $urlBananaProducts = 'https://server.bananaerp.com/api/access/products/';
    $urlBananaCategories = 'https://server.bananaerp.com/api/access/categories';
    $urlWoo = "https://" . $_SERVER['HTTP_HOST'];
    $validation = false;

    $tokenBn = $datos->config->tk_bn;
    $ck = $datos->config->tk_woo->secret_key;
    $cs = $datos->config->tk_woo->consumer_Key;

    $banana  =  productosBanana($urlBananaProducts, $tokenBn);
    $woocommerce = authenticationWoo($ck, $cs, $urlWoo);

    if ($woocommerce == false) {
        $validation = false;
        return $validation;
    } else {
        if ($banana == true) {
            $validation = true;
            return $validation;
        } else {
            $validation = false;
            return $validation;
        }
    }
    return $validation;
}

