<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: error.php");
// echo "hola 2";
} 

function publicacion_hc($id,$capa,$accion){
$respuesta = new xajaxResponse('utf-8');

if($id == ''){
$resultado .= " <input type='text' name='id' id='id' onchange=\"xajax_publicacion_hc(this.value,'documento',''); \">
<input type='button' value ='Buscar una Historia clinica por ID de Usuario'   ><hr>

<input type='text' name='id' id='id' onchange=\"xajax_publicacion_hc(this.value,'documento','eps'); \">
<input type='button' value ='Buscar una Historia clinica por EPS'   ><hr>

";
				}else{

include_once("librerias/conex_oncolinux.php");
$link=Conectarse_oncolinux(); 
mysql_query("SET NAMES 'utf8'");
if($accion == 'eps'){$sql=mysql_query("SELECT * FROM Usuarios WHERE EPS = '$id'  ",$link);}
else{
$sql=mysql_query("SELECT * FROM Usuarios WHERE ID_Usuario = '$id' LIMIT 1 ",$link);
}
if (mysql_num_rows($sql)!='0'){
$resultado.= "<table>";
while( $row = mysql_fetch_array( $sql ) ) {
$resultado .= "<tr><td>$row[ID_Usuario]</td><td>$row[Primer_Nombre]</td><td title='$row[Segundo_Nombre]'>$row[Primer_Apellido]</td><td>$row[Segundo_Apellido]</td><td><a href='oncolinux/hc.php?ID_Usuario=$row[ID_Usuario]' target='hc'>EXPORTAR</a></td></tr>";
															}
$resultado.= "</table>";														
										}else {$resultado ="Sin resultado ";}		
				}

$respuesta->addAssign($capa,"innerHTML",$resultado);
return $respuesta;
}
$xajax->registerFunction("publicacion_hc");


function publicacion_listado($formulario,$capa,$accion){
$respuesta = new xajaxResponse('utf-8');
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT * FROM publicacion_contenido WHERE id_empresa = '$_SESSION[id_empresa]' ORDER BY timestamp DESC ",$link);
if (mysql_num_rows($sql)!='0'){
$resultado.= "Documentos<table>";
while( $row = mysql_fetch_array( $sql ) ) {
$resultado .= "<tr><td>$row[timestamp]</td><td>$row[id_publicacion_tipo]</td><td title='$row[encabezado]'>$row[titulo]</td><td>$row[id_usuario]</td><td><a href='publicacion/pdf.php?doc=$row[control]' >PDF</a></td></tr>";
															}
$resultado.= "</table>";														
										}else {$resultado ="Sin resultado ";}
$respuesta->addAssign($capa,"innerHTML",$resultado);
return $respuesta;
}
$xajax->registerFunction("publicacion_listado");

function tipo_publicacion($id,$estado){
if($estado ==''){$estado = '';}else {$estado= "AND activo ='$estado'";}
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql=mysql_query("SELECT * FROM publicacion_tipo WHERE id_empresa = '$_SESSION[id_empresa]' $estado ",$link);
               
if (mysql_num_rows($sql)!='0'){
$tipo_documento= "Tipo de documento: <select name='tipo_publicacion'  id='tipo_publicacion' title='Elija un tipo de documento '>";
while( $row = mysql_fetch_array( $sql ) ) {
if($row['id_publicacion_tipo']==$id){$selected='selected';}else{$selected='';}
$tipo_documento .= "<option value='$row[id_publicacion_tipo]' title= '$row[tipo_descripcion]' $selected> $row[publicacion_tipo]</option>";
															}
$tipo_documento .= "</select>";															
										}else {$tipo_documento ="No se han especificado ";}
return $tipo_documento;
									}

function publicacion($formulario,$capa,$accion){
//creo el xajaxResponse para generar una salida
$respuesta = new xajaxResponse('utf-8');
$resultado .= "<form name='formulario_$capa' id='formulario_$capa' title='Aplicación para la publicación de documentos'>";
$titulo = addslashes($formulario["titulo"]);
$pencabezado = nl2br($formulario["encabezado"]) ;
$pcontenido = nl2br($formulario["contenido"]);
$ppie = nl2br($formulario["pie"]);
$encabezado = addslashes($formulario["encabezado"]);
$contenido = addslashes($formulario["contenido"]);
$pie = addslashes($formulario["pie"]);
$tags = addslashes($formulario["tags"]);
$tipo_publicacion = $formulario["tipo_publicacion"];
$estado = $formulario["estado"];
$control = $formulario["control"];

if($accion =='preview'){

$resultado .= "
<!-- <input type='text' name='Dtipo_publicacion' id='' value='$tipo_publicacion'>
<input type='text' name='Destado' id='Destado'  value='$estado'>
<input type='text' name='Dcontrol' id='Dcontrol'  value='$control'> -->

<table cellpadding='20' cellspacing='5' border='1' bgcolor='#F4F4C0' width='500'>
	<tr>
		<td>
		<b>Titulo: $titulo</b><hr>
		<b title='Encabezado'>$pencabezado</b><br>
		<p title='Contenido'>$pcontenido</p>
		<p title='Pié'>$ppie</p>
		<hr>
		<div align='center'><input type='button' style='width: 200px;' value='Grabar' title='Grabar el documento'
		 onclick=\"xajax_publicacion(xajax.getFormValues(formulario_$capa),'documento','grabar');\"></div>
		</td>
	</tr>
	
</table>";
}/// fin preview
elseif($accion=='grabar'){
$link=Conectarse(); 
mysql_query("SET NAMES 'utf8'");
$sql="INSERT INTO `publicacion_contenido` (`id`, `id_empresa`, `id_usuario`, `id_publicacion_tipo`, `estado`, `titulo`, `encabezado`, `contenido`, `pie`, `tags`,  `control`) 
VALUES (NULL, '$_SESSION[id_empresa]', '$_SESSION[id_usuario]', 'tipo_publicacion', '$estado', '$titulo', '$encabezado', '$contenido', '$pie', '$tags', '$control');";
$resultado .= "<h2>El documento se ha guardado</h2>";
$sql=mysql_query($sql,$link);
$respuesta->addAssign($capa,"innerHTML",$resultado);
return $respuesta;
}/// fin de grabar
$control= md5(microtime().$_SESSION[id_usuario]);
//include_once("librerias/conex.php"); 
//$sql=mysql_query("SELECT * FROM d9_users WHERE nombre_completo != '' LIMIT 0,10",$link);
//if ($formulario ==''){}
$tipo_documento = tipo_publicacion($tipo_publicacion,'');
if($estado==0){$s0='selected';}
elseif($estado==1) {$s1='selected';}
elseif($estado==2) {$s2='selected';}
elseif($estado==3) {$s3='selected';}
else {$s3='selected';}
$resultado .= "
<input type='hidden' name='control' id='control' value='$control'> 
<table >
	<tr>
		<td>
		$tipo_documento
		</td>
	</tr>
	<tr>
		<td>
		Titulo:<br>
		<input type='text' value='$titulo' name='titulo' id='titulo' size='70' maxlength='200' title='Breve descripción del documento' >
		</td>
	</tr>
	<tr>
		<td>
		Encabezado:<br>
		<textarea  name='encabezado' id='encabezado' rows='3' cols='70' title='Encabezado: Señores ... etc' >$encabezado</textarea>
		</td>
	</tr>
	<tr>
		<td>
		Contenido:<br>
		<textarea  name='contenido' id='contenido' rows='12' cols='70' title='Escriba aqui el texto principal del documento '>$contenido</textarea>
		</td>
	</tr>
	<tr>
		<td>
		Pie:<br>
		<textarea  name='pie' id='pie'  rows='3' cols='70'title='Pie del documento' >$pie</textarea>
		</td>
	</tr>
	<tr>
		<td>
		Etiquetas: <input type='text' name='tags' value='$tags' id='tags' size='60' maxlength='200' title='Etiquetas para la busqueda separadas por comas' >
		</td>
	</tr>
	<tr>
		<td>
		Estado: <select name='estado' id='estado' title='Seleccione el estado de la publicación'>
		
		<option value='0' $s0>Documento interno</option>
		<option value='1' $s1>Documento público</option>
		<option value='2' $s2>Suspendido</option>
		<option value='3' $s3>Borrador</option>
		</select>
		<input type='button' value='Previsualizar' title='Vista previa del documento' onclick=\"xajax_publicacion(xajax.getFormValues(formulario_$capa),'documento','preview');\">
		</td>
	</tr>
</table>
</form>
";

$respuesta->addAssign($capa,"innerHTML",$resultado);
return $respuesta;
} 
$xajax->registerFunction("publicacion");