<?php

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



