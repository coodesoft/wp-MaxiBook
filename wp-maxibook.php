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
add_action('init', 'handle_mxibook_requests');
function handle_mxibook_requests(){
  if ($_GET['accion'] === 'get_mxbook_init_html'){
    $id = $_GET['id'];
    echo wp_mxibook_get_init_html($id);
    die();
  }

  if ($_GET['accion'] === 'refrescarHora'){
    die();
  }

  if ($_GET['accion'] === 'refrescarCombos'){
    die();
  }

  if ($_GET['accion'] === 'getTraduccion'){
    die();
  }

  if ($_GET['accion'] === 'prereserva'){
    echo file_get_contents('http://book.maxibook.com.ar/index.php?accion=prereserva').wp_mxibook_get_html_styles();
    die();
  }

  if ($_GET['accion'] === 'volver'){
    die();
  }

}

function wp_mxibook_get_html_styles(){
  $url_plugin = plugin_dir_url(__FILE__);
  $html_cont =  '<link rel="stylesheet" type="text/css" href="'.$url_plugin.'css/tooltipster.css'.'" media="screen" />';
  $html_cont .= '<link rel="stylesheet" type="text/css" href="'.$url_plugin.'css/maxbook-estilo.css'.'" media="screen" />';
  return $html_cont;
}

function wp_mxibook_get_init_html($id){
  $curl       = curl_init('http://book.maxibook.com.ar/index.php?horde='.$id);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_HEADER, 1);
  $html_book = curl_exec($curl);

  //get cookies
  $matches = [];
  $cookies = [];
  preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $html_book, $matches);
  foreach($matches[1] as $item) {
      parse_str($item, $cookie);
      $cookies = array_merge($cookies, $cookie);
  }
  curl_close($curl);
  setcookie('PHPSESSID', $cookies['PHPSESSID'], time()+3600);

  $html_book  = substr($html_book, strpos($html_book, '<'));
  $url_plugin = plugin_dir_url(__FILE__);

  $html_cont = str_replace(["<script language='javascript' type='text/javascript' src='lib/js/jquery-1.7.2.min.js'></script>",
                            "<script src='lib/js/jquery.tooltipster.min.js'></script>",
                            "<link rel='stylesheet' type='text/css' href='lib/estilo.css'>",
                            "<link rel='stylesheet' type='text/css' href='lib/js/tooltipster.css'>"],['','','',''],$html_book);

  $html_cont = str_replace(["index.php?",
                            "imagenes/load_zona.GIF",
                            "imagenes/sombra_lateral.png",
                            "imagenes/cubiertos_blanco.png"],['?id='.$id.'&',$url_plugin.'img/load_zona.GIF',$url_plugin.'img/sombra_lateral.png',$url_plugin.'img/cubiertos_blanco.png'],$html_cont);

  $html_cont  = '<script src="'.$url_plugin.'js/jquery-1.7.2.min.js'.'"></script>'.'<script src="'.$url_plugin.'js/jquery.tooltipster.min.js'.'"></script>'.$html_cont;
  $html_cont .= wp_mxibook_get_html_styles();

  return $html_cont;
}

function wp_mxibook_short_code($attrs){
  $id = $attrs['id'];
  return '<iframe id="reserva" width="500" height="300" allowfullscreen src="'.get_site_url().'/index.php/?id='.$id.'&accion=get_mxbook_init_html"></iframe>';
}
add_shortcode('maxibook_form', 'wp_mxibook_short_code');

function wp_mxibook_on_activate()
{
}
register_activation_hook(__FILE__,'wp_mxibook_on_activate');

?>
