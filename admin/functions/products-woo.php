<?php


/**
 * Listar productos
 *
 * @param Conexion $woocommerce variable que conecta con la autenticación
 * @return object
 */
function categoriesWoo($woocommerce)
{
    return $woocommerce->get('products/categories');
}
//categoriesWoo($woocommerce);



