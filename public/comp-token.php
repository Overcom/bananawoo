<?php

global $wpdb;


$user_name;
$id_user;


$query_admin = "SELECT ID,display_name FROM {$wpdb->prefix}users";
 

$user_admin = $wpdb->get_results($query_admin, ARRAY_A);
 

foreach ($user_admin as $key => $value) {
	$user_name = ucfirst($value['display_name']);
	$id_user = $value['ID'];
}
if (empty($lista_keys)) {
	$lista_keys = array();
} //si no hay registros, igual a array vació
//echo $user_name.' '. $id_user;
// echo json_encode($result); //convertir array en JSON

$datos = json_decode(file_get_contents(plugin_dir_path(__FILE__) . '/bn-confi.json'));
if (isset($_POST['submit'])) {

	$nombre_api = sanitize_file_name(ucfirst($_POST['name']));
	$TokenBn =  $_POST['tokenBn'];
	$consumer_secret =  $_POST['consumer_secret'];
	$consumer_key = sanitize_key($_POST['consumer_key']);
	$permiso = sanitize_file_name($_POST['permiso']);
	$description = sanitize_textarea_field($_POST['description']);

	$archivo = fopen(plugin_dir_path(__FILE__) . '/bn-confi.json', 'w+');
	fwrite(
		$archivo,
		'{"config":{"nombre":"' . $nombre_api . '","permisos":"' . $permiso . '","descripcion":"' . $description . '","tk_bn":"' . $TokenBn . '","tk_woo":{"secret_key":"' . $consumer_secret . '","consumer_Key":"' . $consumer_key . '"}}}'
	);
	$datos = json_decode(file_get_contents(plugin_dir_path(__FILE__) . '/bn-confi.json'));

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
		<tr>
			<td><?php echo  1 ?></td>
			<td><?php echo   $id_user ?></td>
			<td><?php echo $datos->config->nombre ?></td>
			<td><?php echo $datos->config->permisos  ?></td>
			<td><?php echo  $datos->config->descripcion ?></td>
			<td>
				<!-- //!REVISAR BOTON DE BORRAR -->
				<button name="idProducts" value="<?php echo $id_key ?>" class="btn btn-danger" type="button"><i class="fa-solid fa-trash"></i></button>
			</td>
		</tr>
	</tbody>
</table>