            <?php

            set_time_limit(0);
            $products = productosBanana($urlBananaProducts, $tokenBanana);
            $categories = productosBanana($urlBananaCategories, $tokenBanana);

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
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Crear Producto
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Actualizar Producto
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <button name="sincronizar" class="btn btn-success" type="submit"><i class="fa-solid fa-arrows-rotate"></i></button>
                            </div>
                        </div>
                    </div>
                    <table class="wp-list-table widefat fixed striped pages">
                        <thead>
                            <th>Producto</th>
                            <th>SKU</th>
                            <th>Precio</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
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
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Crear Producto
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Actualizar Producto
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <button name="sincronizar" class="btn btn-success" type="submit"><i class="fa-solid fa-arrows-rotate"></i></button>
                            </div>
                        </div>
                    </div>
                    <table class="wp-list-table widefat fixed striped pages">
                        <thead>
                            <th>Categoría</th>
                            <th>Padres</th>
                            <th>Acciones</th>
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