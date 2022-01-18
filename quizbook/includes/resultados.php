<?php
if(! defined('ABSPATH')) exit();

/**
 * Recibe parámetros por medio quizbook.js y devuelve el resultado por medio de Ajax
 */
function quizbook_resultados(){

    if(isset($_POST['data'])){
        $respuestas=$_POST['data'];
    }

    $resultado=0;

    foreach($respuestas as $resp){
        $pregunta=explode(':', $resp);

        /**
         * pregunta[0] =post_id
         * pregunta[1] = respuesta del usuario
         */
        $post_id=$pregunta[0];
        $respuesta_usuario=$pregunta[1];

         $correcta = get_post_meta($post_id, 'quizbook_correcta', true);

         $letra_correcta=explode(':',$correcta);

         /**
          * letra_correcta[0] = prefijo respuesta qb_correcta
          * letra_correcta[1] = respuesta correcta          
          */
          $respuesta_correcta=$letra_correcta[1];

          if($respuesta_usuario===$respuesta_correcta){
              $resultado+=20;
          }

    }

    $respuesta=array(
        'total' => $resultado
    );
    header('content-type: application/json');
    echo json_encode($respuesta);
    die();
}

add_action( 'wp_ajax_nopriv_quizbook_resultados', 'quizbook_resultados'); //hook ajax cuando estas logueado
add_action( 'wp_ajax_quizbook_resultados', 'quizbook_resultados');//hook ajax cuando no estas logueado