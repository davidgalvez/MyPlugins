<?php
if(! defined('ABSPATH')) exit();

class quizbookAjaxResults{

    private int $notaMinima;
    private int $notaMinimaValida;
    private int $notaMaximaValida;
    function __construct(int $notaMinima, int $notaMinimaValida, int $notaMaximaValida)
    {
        $this->notaMinimaValida=$notaMinimaValida;
        $this->notaMaximaValida=$notaMaximaValida;
        $this->notaMinima=$this->setValidNotaMinima($notaMinima);
    }
    /**
     * Recibe las respuestas marcadas por el usuario por medio quizbook.js y devuelve el resultado por medio de Ajax
     */
    function getQuizbookResult()
    {
        if(isset($_POST['data'])){
            $respuestas=$_POST['data'];
        }
    
        $resultado=0;

        $puntosPorPregunta=$this->getPuntosPorPregunta($respuestas);
    
        foreach($respuestas as $resp){
           

            $post_id=$this->extractPostID($resp);
            $respuesta_usuario=$this->extractUserAnswer($resp);
    
             
              $respuesta_correcta=$this->getCorrectAnswer($post_id);
    
              if($this->isCorrectAnswer($respuesta_usuario,$respuesta_correcta)){
                  $resultado+=$puntosPorPregunta;
              }
    
        }
    
        $respuesta=array(
            'total' => $resultado,
            'mensaje' => $this->messageAproved($resultado)
        );
        $this->returnResultJson($respuesta);

    }

    /**
     * Funcion para asegurarnos que la nota mínima esté entre 0 y 100
     */
    function setValidNotaMinima(int $notaMinima){
        if($notaMinima>$this->notaMaximaValida) return $this->notaMaximaValida;
        if($notaMinima<$this->notaMinimaValida) return $this->notaMinimaValida;
        return $notaMinima;
    }

    /**
     * Devuelve el valor del parametro de nota minima
     */
    function getNotaMinima(){
        return $this->notaMinima;
    }

    /**
     * Verifica si el usuario a aprobado el quizz
     */
    function messageAproved(float $resultado){
        return ($resultado>=$this->notaMinima)?"aprobado":"desaprobado";
    }

    /**
     * Devuelve el resultado en formato Json
     */
    function returnResultJson(array $respuesta){
        header('content-type: application/json');
        echo json_encode($respuesta);
        die();
    }

    /**
     * Valida si la respuesta enviada por el usuario es correcta
     */
    function isCorrectAnswer(string $userAnswer, string $correctAnswer){
        return $userAnswer===$correctAnswer;
    }

    /**
     * Obtiene el puntaje que se asignará a cada pregunta correcta segun el total de preguntas
     */
    function getPuntosPorPregunta($respuestas)
    {
        $totalPreguntas=count($respuestas);
        return (100/$totalPreguntas);
    }

    /**
     * Obtiene la respuesta corecta correspondienta al postID
     */
    function getCorrectAnswer(int $postID){
        /**
         * Correcta prefijo:letraCorrecta (qb_correcta:a)
         */
        $correcta = get_post_meta($postID, 'quizbook_correcta', true);
    
             $letra_correcta=explode(':',$correcta);
    
             /**
              * letra_correcta[0] = prefijo respuesta qb_correcta
              * letra_correcta[1] = respuesta correcta          
              */              
              return $letra_correcta[1];
    }

    /**
     * Obtiene la respuesta marcada por el usuario para la pregunta seleccionada
     * 
     * @param respuesta viene en el siguiente formato: postID:userAnswer ejm: "38:d"
     * 
     * @return array devuelve un array asociativo ["postID"=>valPostID,"userAnswer"=>valUserAnswer]
     */
    function parseUserAnswer(string $respuesta){
        $pregunta=explode(':', $respuesta);
    
            /**
             * pregunta[0] =post_id
             * pregunta[1] = respuesta del usuario
             */
            return array(
                "postID" =>$pregunta[0],
                "userAnswer"=>$pregunta[1]
            );            
    }

    /**
     * Extrae la letra de la respuesta marcada por el usuario para la pregunta 
     */
    function extractUserAnswer(string $respuesta){
        $result=$this->parseUserAnswer($respuesta);
        return $result["userAnswer"];

    }


    /**
     * Extrae el postID de la pregunta que respondió el usuario 
     */
    function extractPostID(string $respuesta){
        $result=$this->parseUserAnswer($respuesta);
        return $result["postID"];
    }
}

/*
function quizbook_resultados(){

    if(isset($_POST['data'])){
        $respuestas=$_POST['data'];
    }

    $resultado=0;

    foreach($respuestas as $resp){
        $pregunta=explode(':', $resp);

        
        $post_id=$pregunta[0];
        $respuesta_usuario=$pregunta[1];

         $correcta = get_post_meta($post_id, 'quizbook_correcta', true);

         $letra_correcta=explode(':',$correcta);

        
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
*/