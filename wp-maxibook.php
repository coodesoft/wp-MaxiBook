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
  $html_book = file_get_contents('http://book.maxibook.com.ar/index.php?horde='.$id);
  $html_cont = $html_book;
  $html_cont .= '<script src="'.plugin_dir_url(__FILE__).'js/jquery-1.7.2.min.js'.'"></script>';
  $html_cont .= '<script src="'.plugin_dir_url(__FILE__).'js/jquery.tooltipster.min.js'.'"></script>';
  $html_cont .= '<link rel="stylesheet" type="text/css" href="'.plugin_dir_url(__FILE__).'css/maxbook-estilo.css'.'" media="screen" />';
  $html_cont .= '<link rel="stylesheet" type="text/css" href="'.plugin_dir_url(__FILE__).'css/tooltipster.css'.'" media="screen" />';

  return '<div id="reserva" width="500" height="300" allowfullscreen>'.$html_cont.'</div>';
}
add_shortcode('maxibook_form', 'wp_mxibook_short_code');

function wp_mxibook_on_activate()
{
}
register_activation_hook(__FILE__,'wp_mxibook_on_activate');

?>
