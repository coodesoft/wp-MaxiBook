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
  $id         = $attrs['id'];
  $html_book  = file_get_contents('http://book.maxibook.com.ar/index.php?horde='.$id);
  $url_plugin = plugin_dir_url(__FILE__);

  $html_cont = str_replace(["<script language='javascript' type='text/javascript' src='lib/js/jquery-1.7.2.min.js'></script>",
                            "<script src='lib/js/jquery.tooltipster.min.js'></script>",
                            "<link rel='stylesheet' type='text/css' href='lib/estilo.css'>",
                            "<link rel='stylesheet' type='text/css' href='lib/js/tooltipster.css'>"],['','','',''],$html_book);

  $html_cont = str_replace(["imagenes/load_zona.GIF",
                            "imagenes/sombra_lateral.png",
                            "imagenes/cubiertos_blanco.png"],[$url_plugin.'img/load_zona.GIF',$url_plugin.'img/sombra_lateral.png',$url_plugin.'img/cubiertos_blanco.png'],$html_cont);

  $html_cont .= '<script src="'.$url_plugin.'js/jquery-1.7.2.min.js'.'"></script>';
  $html_cont .= '<script src="'.$url_plugin.'js/jquery.tooltipster.min.js'.'"></script>';
  $html_cont .= '<link rel="stylesheet" type="text/css" href="'.$url_plugin.'css/tooltipster.css'.'" media="screen" />';
  $html_cont .= '<link rel="stylesheet" type="text/css" href="'.$url_plugin.'css/maxbook-estilo.css'.'" media="screen" />';

  return '<div id="reserva" width="500" height="300" allowfullscreen>'.$html_cont.'</div>';
}
add_shortcode('maxibook_form', 'wp_mxibook_short_code');

function wp_mxibook_on_activate()
{
}
register_activation_hook(__FILE__,'wp_mxibook_on_activate');

?>
