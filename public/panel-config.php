<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
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

<body>
    <div class="container-fluid">
        <div align="center" class="mt-4 mb-2 container">
            <h1>Panel Banana Woo</h1>
        </div>

        <!-- PAGES BTN -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Configuración</button>
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

                <?php include('comp-token.php'); ?>
                <?php
                 extractToken ($datos);
                if (validationTokens($datos) == true) {
                ?>
                    <div class="container mt-5">
                        <div class="alert alert-success" role="alert">
                            Autenticación exitosa
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="container mt-5">
                        <div class="alert alert-danger" role="alert">
                            Fallo al Autenticar vuelva a intentarlo.
                        </div>
                    </div>
                <?php
                }
                ?>
                <!-- AUTENTICAR -->
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
                                    <h4>Datos Banana</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nombre API</label>
                                                <input class="form-control" id="name" name="name" minlength="4" maxlength="20" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="secret">Token Banana</label>
                                            <input class="form-control" id="tokenBn" name="tokenBn" type="password">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="permisos">Permisos</label>
                                            <select name="permiso" id="permisos" class="form-select" aria-label="Default select example">
                                                <option value="w">Escritura</option>
                                                <option value="r">Lectura</option>
                                                <option value="r/w">Escritura/Lectura</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="des">Descripción</label>
                                            <textarea class="form-control" style="resize: none;" name="description" id="des" cols="10"></textarea>
                                        </div>
                                    </div>
                                    <h4>Datos Woocommerce</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="secret">Consumer Key</label>
                                            <input class="form-control" id="consumer_key" name="consumer_key" type="password">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="secret">Consumer secret</label>
                                            <input class="form-control" id="consumer_secret" name="consumer_secret" type="password">
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

            <div class="container-fluid mt-3">
                <?php include('comp-export.php');  ?>
            </div>

            <!-- Contenido tres opciones avanzadas -->
            <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                <h1>Contenido tres opciones avanzadas</h1>
                .....
            </div>
        </div>
        <!-- contenidos -->

</body>

</html>