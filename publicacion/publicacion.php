<?php
session_start();
// Comprobamos si existe la variable
if ( !isset ( $_SESSION['grupo'] ) ) {
 // Si no existe 
 header("Location: error.php");
// echo "hola 2";
} ?>

<a onclick="xajax_publicacion('','documento','');">Nuevo </a> |
<a onclick="xajax_publicacion_listado('','documento','');">Listado </a>|
<a onclick="xajax_publicacion_hc('','documento','');">Historia clinica </a>|

 <div id='documento' name='documento'></div>