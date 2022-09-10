<?php
/**
 * @package Quizbook
 */
namespace Quizbook;
if(! defined('ABSPATH')) exit();
/**
 * Clase para validar y renderizar los elementos del shorcode
 */
class ShortCodeRender{

    /**
     * Valida si es una opcion de la pregunta y la renderiza
     */
    static function renderOpcionIfQuizbook(string $llave,array $opcion)
    {
        if(self::tienePrefijoQuizbook($llave))
        {
            $letraOpcion=self::getLetraOpcion($llave);
            $textoOpcion=self::getTextoOpcion($opcion);
            self::renderOpcion($letraOpcion,$textoOpcion);
        }
    }

    /**
     * Verifica si el texto enviado tiene el prefijo "qb_" correspondiente a los metaboxes creados para las opciones del quiz
     */
    static private function tienePrefijoQuizbook($llave)
    {
        return (strpos($llave,'qb_')===0);
    }

    /**
     * Invoca a la plantilla para renderizar la opción enviándole la letra y el texto correspondiente a la opción
     */
    static private function renderOpcion($letraOpcion,$textoOpcion)
    {                
        include QUIZBOOK_ASSETS_BASE_PATH."templates/quizbook-shortcode-option-tpl.php";
    }

    /**
     * Separa la llave en un array de tres partes (prefijo, opcion, letraOpción) y extrae el tercer elemento correspondiente a la letra de la opción.
     * @param llave es un texto con formato qb_opcion_a
     */
    static private function getLetraOpcion(string $llave)
    {
        $nLlave=explode('_',$llave);
        return $nLlave[2];
    }

    /**
     * Obtiene el texto de la opción a mostrar en la pantalla
     * @param opcion Arreglo que contiene el texto de la opción en el primer elemento
     */
    static private function getTextoOpcion(array $opcion)
    {
        return $opcion[0];

    }
}