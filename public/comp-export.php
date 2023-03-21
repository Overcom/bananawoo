<?php
$urlBananaProducts = 'https://server.bananaerp.com/api/access/products/';
$urlBananaCategories = 'https://server.bananaerp.com/api/access/categories';
$tokenBanana = extractTokenBanana();
//productos banana 
$products = productosBanana($urlBananaProducts, $tokenBanana);
//categorias banana
$categories = productosBanana($urlBananaCategories, $tokenBanana);
//Tokens woo

$consumer_secret_Woo = tokenWoo(1);
$consumer_key_Woo = tokenWoo(0);

$urlHost = "https://" . $_SERVER['HTTP_HOST'];

if (isset($_POST['sincronizar'])) {
    $category_woo_id = [];
    if (isset($_POST['actualizar']) or isset($_POST['crear'])) {
        set_time_limit(0);

        $productsCreates = 0;
        $productsUpdates = 0;
        $productExist = 0;
        $category_woo_id = [];
        $productNotSku = 0;
        $woocommerce = aunthenticationWoo($consumer_key_Woo, $consumer_secret_Woo, $urlHost);
        // $productsBanana = $products->products;
        
        foreach ($products->products as $key => $productoBanana) {
            $actualizado = false;
            $productWoo = searchProduct($woocommerce, $productoBanana->sku);

            $data = [
                'name' => $productoBanana->name,
                'regular_price' => $productoBanana->sale_price,
                'stock_quantity' => $productoBanana->stock,
                'description' => $productoBanana->description,
                'categories' => $category_woo_id,
                'sku' => $productoBanana->sku
            ];

            if (count($productWoo) > 0) {
                $id = $productWoo[0]->id;
                $sku = $productWoo[0]->sku;

                if (isset($_POST['actualizar'])) {
                    $actualizado = true;
                    updateProductsWoo($woocommerce, $id, $data);
                    $productsUpdates++;
                }
            }

            if (isset($_POST['crear']) && !$actualizado) {
                if ($productoBanana->sku == $sku) {
                    $productExist++;
                } else {
                    createProductWoo($woocommerce, $data);
                    $productsCreates++;
                }
            }
        }
        echo '<div class="alert alert-success" role="alert">
                    ' . $productsCreates . ' Productos Creados Exitosamente
                    ' . $productExist . ' Ya existen, ' . $productsUpdates . ' en existencia.
                  </div>';
    }



    // if (isset($_POST['crear'])) {

    //     foreach ($productsBanana as $key => $productoBanana) {
    //         $productWoo = searchProduct($woocommerce, $productoBanana->sku);
    //         if (count($productWoo) > 0) {
    //             $productExist++;
    //         } else {

    //             createProductWoo($woocommerce, $dataCreate);
    //             $productsCreates++;
    //         }
    //     }
    //     echo '<div class="alert alert-success" role="alert">
    //             ' . $productsCreates . ' Productos Creados Exitosamente
    //             ' . $productExist . 'Ya existen,
    //           </div>';
    // }

    // if (isset($_POST['actualizar'])) {
    //     $productNotSku = 0;

    //     foreach ($productsBanana as $key => $producto) {
    //         if ($producto->sku != null) {
    //             $productWoo = searchProduct($woocommerce, $producto->sku);
    //             if (count($productWoo) > 0) {
    //                 $id = $productWoo[0]->id;
    //                 $dataUpdate = [
    //                     'name' => $producto->name,
    //                     'regular_price' => $producto->sale_price,
    //                     'stock_quantity' => $producto->stock,
    //                     'description' => $producto->description,
    //                     'categories' => $category_woo_id,
    //                     'sku' => $producto->sku
    //                 ];
    //                 updateProductsWoo($woocommerce, $id, $dataUpdate);
    //             }
    //         } else {
    //             $productNotSku++;
    //         }
    //     }
    //     echo '<div class="alert alert-warning" role="alert">
    //             ' . $productNotSku . ' Productos no tienen sku
    //           </div>';
    // } elseif (isset($_POST['actualizar']) and isset($_POST['crear'])) {
    //     echo 'los dos';
    // }


    //    var_dump( searchCategoriesWoo($woocommerce, 'CAMPIoikjiokjuiouijNG'));
}



?>

<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Productos</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Categorias</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Stoks</button>
    </li>
</ul>
<!-- CONTENIDO -->
<div class="tab-content" id="pills-tabContent">
    <!-- RPT PRODUCTOS -->
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
        <div class="container mb-4">
            <form method="post">
                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input name="crear" class=" " type="checkbox" value="crear" id="flexCheckDefault1">
                            <label class="form-check-label" for="flexCheckDefault1">
                                Crear Producto
                            </label>
                        </div>
                    </div>
                    <div class="col ">
                        <div class="form-check">
                            <input name="actualizar" type="checkbox" value="actualizar" id="flexCheckDefault2">
                            <label class="form-check-label" for="flexCheckDefault2">
                                Actualizar Producto
                            </label>
                        </div>
                    </div>
                    <div class="col ">
                        <button name="sincronizar" class="btn btn-success" type="submit"><i class="fa-solid fa-arrows-rotate"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <h6 class="mb-3 text-primary">Estos son tus productos de Banana</h5>
            <table class="wp-list-table widefat  fixed striped pages">
                <thead>
                    <th class="text-primary">Producto</th>
                    <th class="text-primary">SKU</th>
                    <th class="text-primary">Precio</th>
                    <th class="text-primary">Categoría</th>
                    <th class="text-primary ">Descripción</th>
                    <th class="text-primary">Acciones</th>
                </thead>
                <tbody id="the-list">
                    <?php
                    $ls = 0;
                    foreach ($products->products as $product) {
                        $ls++;
                        $name = $product->name; //clave de la tabla
                        $id = $product->id;
                        $sku = $product->sku;
                        $category_name = $product->category_name;
                        $description = $product->description;
                        $sale_price = $product->sale_price;
                    ?>
                        <tr>
                            <td>
                                <p><?php echo  esc_html($name); ?></p>
                                <b class="text-sm-start"><?php echo  esc_html($id) ?></b>
                            </td>
                            <td><?php echo  esc_html($sku) ?></td>
                            <td><?php echo  esc_html($sale_price) ?></td>
                            <td><?php echo  esc_html($category_name) ?></td>
                            <td><?php echo  esc_html($description) ?></td>
                            <td>
                                <!-- //!REVISAR BOTON DE BORRAR -->
                                <button name="idProducts" value="<?php echo $id_key ?>" class="btn btn-danger" type="button"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php
                    }

                    ?>
                </tbody>
            </table>
    </div>
    <!-- Listado de categorias -->
    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                        <label class="form-check-label" for="flexCheckDefault1">
                            Crear Producto
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                        <label class="form-check-label" for="flexCheckDefault2">
                            Actualizar Producto
                        </label>
                    </div>
                </div>
                <div class="col">
                    <button name="sincronizar" class="btn btn-success" type="submit"><i class="fa-solid fa-arrows-rotate"></i></button>
                </div>
            </div>
        </div>
        <h6 class="mb-3 text-primary">Estas son tus categorías en banana</h5>
            <table class="wp-list-table widefat fixed striped pages">
                <thead>
                    <th class=" text-primary">Categoría</th>
                    <th class="  text-primary">Padres</th>
                    <th class="  text-primary">Acciones</th>
                </thead>
                <tbody id="the-list">
                    <?php
                    $ls = 0;
                    foreach ($categories as $categoric) {
                        $ls++;

                        $name = $categoric->name;
                        $id = $categoric->id;
                        $padre = $categoric->path;
                    ?>
                        <tr>
                            <td>
                                <p><?php echo  esc_html($name); ?></p>
                                <b class="text-sm-start"><?php echo  esc_html($id) ?></b>
                            </td>
                            <td><?php echo  esc_html($padre) ?></td>
                            <td>
                                <!-- //!REVISAR BOTON DE BORRAR -->
                                <button name="idProducts" value="<?php echo $id_key ?>" class="btn btn-danger" type="button"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php
                    }

                    ?>
                </tbody>
            </table>
    </div>
    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">...</div>
</div>
<!-- termina contenido-->