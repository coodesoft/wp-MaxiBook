<?php
/*
Plugin Name: MxiBook Wrapper SSL
Plugin URI:
Description: Wrapper - Formulario de reservaciones - para evitar error de SSL
Version: 1.0
Author:
Author URI:
License: GPL2
*/


function wp_mxibook_short_code($attrs){
  $id = $attrs['id'];
  return '<iframe id="reserva" width="500" height="300" frameborder="0" src="http://book.maxibook.com.ar/index.php?horde='.$id.'" allowfullscreen></iframe>';
}
add_shortcode('maxibook_form', 'wp_mxibook_short_code');

function wp_mxibook_on_activate()
{
    //add_option('mi_opcion',255,'','yes');
}
register_activation_hook(__FILE__,'wp_mxibook_on_activate');
?>
