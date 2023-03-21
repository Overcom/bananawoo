<?php

global $wpdb;


$user_name;
$id_user;


$query_admin = "SELECT ID,display_name FROM {$wpdb->prefix}users";
$query_tonken = "SELECT * {$wpdb->prefix}woocommerce_api_keys";
$query = "SELECT * FROM  {$wpdb->prefix}bn_keys ";

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
	$TokenBn =  $_POST['tokenBn'];
	$consumer_secret =  $_POST['consumer_secret'];
	$consumer_key = sanitize_key($_POST['consumer_key']);
	$permiso = sanitize_file_name($_POST['permiso']);
	$description = sanitize_textarea_field($_POST['description']);

	$str = "INSERT INTO wp_bn_keys(`user_id`,`name_api`,`permissions`,
		`description`,`tokenBn`,`consumer_key`,`consumer_secret`)
	VALUES('" . $id_user . "','" . $nombre_api . "','" . $permiso . "',
		'" . $description . "','" . $TokenBn . "','" . $consumer_key . "','" . $consumer_secret . "')";
	$conex = $wpdb->get_results($str, ARRAY_A);
    //echo  $str; exit();

//    $sql = "SELECT  FROM {$wpdb->prefix}bn_keys"

// 	function autenticar($bool)
// 	{
// 		return $bool;
// 	}
    /*
     TODO: $id_user pertenece tabla wp_users
     */
 }
  ?>
  <table class="wp-list-table widefat fixed striped pages">
  	<thead>
  		<th>#</th>
  		<th>Usuario</th>
  		<th>Nombre Token</th>
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
                            $tokenBn = $value['tokenBn'];
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