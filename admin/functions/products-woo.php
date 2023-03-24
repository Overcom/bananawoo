<?php


/**
 * Listar productos
 *
 * @param Conexion $woocommerce variable que conecta con la autenticación
 * @return object
 */
function createCategoryWoo($woocommerce, $data)
{
    return $woocommerce->get('products/categories', $data);
}
//categoriesWoo($woocommerce);

function createProductWoo($woocommerce, $data)
{
    $woocommerce->post('products', $data);
}

function updateCategoriesWoo($woocommerce,$id,$data)
{
   return  $woocommerce->put("products/$id", $data);
}

/**
 * Buscar Categorías
 *
 * @param objeto $woocommerce
 * @param string $word
 * @return mixed
 */
function searchCategoriesWoo($woocommerce, $word)
{
    return $woocommerce->get('products/categories', ['search' => $word]);
}


// function createProductsWoo($woocommerce,$productsBanana)
// {
//     foreach ($productsBanana as $key => $productoBanana) {

//         // busqueda edel pro em woo ppor sku

//         // insert true

//         $category_woo_id = [];

//         if ($productoBanana->category_name != null) {

//             $category_name_banana = explode(',', $productoBanana->category_name);


//             foreach ($category_name_banana  as $key => $word) {
//                 $result_find = searchCategoriesWoo($woocommerce, $word);

//                 array_push($category_woo_id, ['id' => $result_find[0]->id]);
//             }
//         }

//         $data = [
//             'name' => $productoBanana->name,
//             'regular_price' => $productoBanana->sale_price,
//             'stock_quantity' => $productoBanana->stock,
//             'description' => $productoBanana->description,
//             'categories' => $category_woo_id,
//             'sku' => $productoBanana->sku
//         ];
//         createProductWoo($woocommerce, $data);
//     }
// }
function updateProductsWoo($woocommerce, $id, $data)
{
    return $woocommerce->put("products/$id", $data);
}

function searchProduct($woocommerce, $word)
{
    return $woocommerce->get('products', ['sku' => $word]);
}