
<?
//incluímos la clase ajax
require ('../../xajax/xajax.inc.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();

require ('../includes/funciones_XAJAX.php');

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequests();

?>
<html xmlns="http://www.w3.org/1999/xhtml"xml:lang="es" lang="es" dir="ltr">
<head>
<script language=javascript type=text/javascript>
function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 8) && (node.type=="text")) {return false;}
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
function validar2(e){
tecla_codigo = (document.all) ? e.keyCode : e.which;
if (tecla_codigo==8)return false;
return true;
}
document.onkeypress = stopRKey;
document.onkeydown = stopRKey;
</script>

 <? $xajax->printJavascript("../../xajax/");  ?>

<script language="Javascript">
<!--
 function doClear(theText) {
     if (theText.value == theText.defaultValue) {
         theText.value = ""
     }
 }

//-->
</script>

  <title><? echo "$empresa $aplicacion $page $usuario"; ?></title>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="../estilos/estilo.css" rel="stylesheet" type="text/css">
  <link rel="SHORTCUT ICON" href="../icono.ico"></head>

<body >

					

<?php
$control_version = '0aa0b6b3207f0b3839381db1962574a2'; 
/*  ATENCION: Puede existir una versión mas reciente de este archivo en http://GaleNUx.com
    por favor compruebelo antes de modificarlo. control de versión [0aa0b6b3207f0b3839381db1962574a2]
    
    Copyright ©  13-22-2/ 17-Dic-2008 Dirección nacional de derechos de autor Colombia 
    http://GaleNUx.com Es un sistema para de información para la salud adaptado al sistema
    de salud Colombiano.
    
    Si necesita consultoría o capacitación en el manejo, instalación y/o soporte o 
    ampliación de prestaciones de GaleNUx por favor comuniquese con nosotros 
    al email praxis@galenux.com.

    Este programa es software libre: usted puede redistribuirlo y/o modificarlo 
    bajo los términos de la Licencia Pública General GNU publicada 
    por la Fundación para el Software Libre, ya sea la versión 3 
    de la Licencia, o cualquier versión posterior.

    Este programa se distribuye con la esperanza de que sea útil, pero 
    SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita 
    MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO. 
    Consulte los detalles de la Licencia Pública General GNU para obtener 
    una información más detallada. 

    Debería haber recibido una copia de la Licencia Pública General GNU 
    junto a este programa. 
    En caso contrario, consulte <http://www.gnu.org/licenses/>.
    
    POR FAVOR CONSERVE ESTA NOTA SI EDITA ESTE ARCHIVO

 */ 
?>