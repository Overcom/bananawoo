<?php
global $wpdb;

$user_name;
$id_user;


$query_admin = "SELECT ID,display_name FROM wp_users";
$query_tonken = "SELECT * wp_woocommerce_api_keys";
$query = "SELECT * FROM  wp_bn_keys ";

$lista_keys = $wpdb->get_results($query, ARRAY_A);
$user_admin = $wpdb->get_results($query_admin, ARRAY_A);
$lista_tokens = $wpdb->get_results($query_tonken, ARRAY_A);

foreach ($user_admin as $key => $value) {
    $user_name = ucfirst($value['display_name']);
    $id_user = $value['ID'];
}
if (empty($lista_keys)) {
    $lista_keys = array();
} //si no hay registros, igual a array vació
//echo $user_name.' '. $id_user;
// echo json_encode($result); //convertir array en JSON

//!ARREGLAR
if (isset($_POST['button'])) {
    $idProduct = $_POST['idProducts'];

    echo $idProduct;
    exit();
}

if (isset($_POST['submit'])) {
    $nombre_api = sanitize_file_name(ucfirst($_POST['name']));
    $api_key =  $_POST['api_key'];
    //$consumer_key =sanitize_key($_POST['consumer_key']);
    $permiso = sanitize_file_name($_POST['permiso']);
    $description = sanitize_textarea_field($_POST['description']);

    $str = "INSERT INTO wp_bn_keys(`user_id`,`name_api`,`permissions`,
    `description`,`api_key`)VALUES('" . $id_user . "','" . $nombre_api . "','" . $permiso . "',
    '" . $description . "','" . $api_key . "')";

    $conex = $wpdb->get_results($str, ARRAY_A);
    //echo  print_r($str); exit();

    /*
     TODO: $id_user pertenece tabla wp_users
     */
}

?>

<body>
    <style>
        /* .btn-search {
            font-size: 120%;
            padding: 0px 10px;
        } */

        /* .box-filter {
            display: flex;
            padding: 0px 0px;
        } */

        /* .input-filter {
            height: 20px;
        } */
    </style>
    <div class="container-fluid">
        <div align="center" class="mt-4 mb-2 container">
            <h1>Panel Banana Woo</h1>
        </div>

        <!-- PAGES BTN -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">APIS Banana</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Exportar</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Contact</button>
            </li>
        </ul>
        <!-- comienza contenido -->
        <div class="tab-content" id="myTabContent">
            <!-- contenido uno APIS -->
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <div class="row mt-4">
                    <div class="col">
                        <?php
                        echo "<h1 class='wp-heading-inline'>" . get_admin_page_title() . "</h1>";
                        ?>
                    </div>
                    <div class="col">
                        <a id="viewModal" class="btn btn-primary">Autenticar Token</a>
                    </div>
                    <div class="col">
                        <div class="box-filter">
                            <button class="btn btn-search"><i class="fa-sharp fa-1x fa-solid fa-magnifying-glass"></i></button>
                            <input class="input-filter" type="text">
                        </div>
                    </div>
                </div>


                <table class="wp-list-table widefat fixed striped pages">
                    <thead>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Nombre API</th>
                        <th>Permisos</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody id="the-list">
                        <?php
                        $ls = 0;
                        foreach ($lista_keys as $key => $value) {
                            $ls++;
                            $id_key = $value['id_key']; //clave de la tabla
                            $user_id = $value['user_id'];
                            $name_api = $value['name_api'];
                            $permiso = $value['permissions'];
                            $description = $value['description'];
                            $consumer_key = $value['consumer_key'];
                            $api_key = $value['api_key'];
                        ?>
                            <tr>
                                <td><?php echo esc_html($ls) ?></td>
                                <td><?php echo  esc_html($user_name) ?></td>
                                <td><?php echo  esc_html($name_api) ?></td>
                                <td><?php echo  esc_html($permiso) ?></td>
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
                <!-- Modal -->
                <div class="modal fade" id="modalNuevo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de llaves</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Nombre API</label>
                                                <input class="form-control" id="name" name="name" minlength="4" maxlength="20" type="text">
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="api_key">Consumer key</label>
                                                    <input class="form-control" id="consumer_key" type="text" name="consumer_key">
                                                </div>
                                            </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="secret">API Key</label>
                                            <input class="form-control" id="secret" name="api_key" type="password">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="permisos">Permisos</label>
                                            <select name="permiso" id="permisos" class="form-select" aria-label="Default select example">
                                                <option value="w">Escritura</option>
                                                <option value="r">Lectura</option>
                                                <option value="r/w">Escritura/Lectura</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="des">Descripción</label>
                                            <textarea class="form-control" style="resize: none;" name="description" id="des" cols="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <input type="submit" name="submit" class="btn btn-primary" value="Guardar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- contenido dos Exportación -->
        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
            <h4 class="mt-3">Métodos de relación</h4>
            <hr>
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-2">
                        <div id="box-producto" class="box-check">
                            <div class="form-check">
                                <input hidden class="" type="checkbox" value="Producto" id="producto">
                                <label class="word-check" for="producto">
                                    Productos
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div id="box-categoria" class="box-check">
                            <div class="form-check">
                                <input hidden type="checkbox" value="categoria" id="categoria">
                                <label class="word-check" for="categoria">
                                    Categorías
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div id="box-lista" class="box-check">
                            <div class="form-check">
                                <input hidden class="" type="checkbox" value="" id="lista">
                                <label class="word-check" for="lista">
                                    Lista Precios
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div id=box-stock class="box-check">
                            <div class="form-check">
                                <input hidden class="" type="checkbox" value="" id="stock">
                                <label class="word-check" for="stock">
                                    Stocks
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div id="box-elemento" class="box-check">
                            <div class="form-check">
                                <input hidden class="" type="checkbox" value="" id="elemento">
                                <label class="word-check" for="elemento">
                                    Elemento
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div id="box-todo" class="box-check">
                            <div class="form-check">
                                <input hidden class="" type="checkbox" value="" id="todo">
                                <label class="word-check" for="todo">
                                    Todo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contenido tres opciones avanzadas -->
        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
            <h1>Contenido tres opciones avanzadas</h1>
        </div>
    </div>
    <!-- contenidos -->

</body>