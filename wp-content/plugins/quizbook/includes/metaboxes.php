<?php
if(! defined('ABSPATH')) exit();

function quizbook_agregar_metaboxes(){

    //Agregar el metabox al plugin
    add_meta_box( 'quizbook_meta_box', 'Respuestas', 'quizzbook_metaboxes', 'quizes', 'normal', 'high', null );

}

add_action( 'add_meta_boxes', 'quizbook_agregar_metaboxes');

/**
 * Muestra el contenido html de los metaboxes
 */
function quizzbook_metaboxes($post){
    wp_nonce_field(basename(__FILE__), 'quizbook_nonce');
?>
    <table class="form-table">
       <tr>
           <th class="row-title" colspan="2">
               <h2>Añade las respuestas aquí</h2>
           </th>
       </tr>
       <tr>
           <th class="row-title">
               <label for="respuesta_a">a)</label>
           </th>
           <td>
                <input value="<?php echo esc_attr(get_post_meta($post->ID, 'qb_respuesta_a', true)); ?>" id="respuesta_a" name="qb_respuesta_a" class="regular-text" type="text" >
           </td>
       </tr>
       <tr>
           <th class="row-title">
               <label for="respuesta_b">b)</label>
           </th>
           <td>
                <input value="<?php echo esc_attr(get_post_meta($post->ID, 'qb_respuesta_b', true)); ?>" id="respuesta_b" name="qb_respuesta_b" class="regular-text" type="text">
           </td>
       </tr>
       <tr>
           <th class="row-title">
               <label id="respuesta_c">c)</label>
           </th>
           <td>
                <input value="<?php echo esc_attr(get_post_meta($post->ID, 'qb_respuesta_c', true)); ?>" id="respuesta_c" name="qb_respuesta_c" class="regular-text" type="text">
           </td>
       </tr>
       <tr>
           <th class="row-title">
               <label id="respuesta_d">d)</label>
           </th>
           <td>
                <input value="<?php echo esc_attr(get_post_meta($post->ID, 'qb_respuesta_d', true)); ?>" id="respuesta_d" name="qb_respuesta_d" class="regular-text" type="text">
           </td>
       </tr>
       <tr>
           <th class="row-title">
               <label id="respuesta_e">e)</label>
           </th>
           <td>
                <input value="<?php echo esc_attr(get_post_meta($post->ID, 'qb_respuesta_e', true)); ?>" id="respuesta_e" name="qb_respuesta_e" class="regular-text" type="text">
           </td>
       </tr>
       <tr>
           <th class="row-title">
               <label for="respuesta_correcta">Respuesta Correcta</label>
           </th>
           <td>
           <?php $respuesta= esc_html(get_post_meta($post->ID, 'quizbook_correcta', true)); ?>
               <select name="quizbook_correcta" id="respuesta_correcta" class="postbox">
                   <option value="">Elige la respuesta correcta</option>
                   <option <?php selected($respuesta,'qb_correcta:a'); ?>value="qb_correcta:a">a</option>
                   <option <?php selected($respuesta,'qb_correcta:b'); ?>value="qb_correcta:b">b</option>
                   <option <?php selected($respuesta,'qb_correcta:c'); ?>value="qb_correcta:c">c</option>
                   <option <?php selected($respuesta,'qb_correcta:d'); ?>value="qb_correcta:d">d</option>
                   <option <?php selected($respuesta,'qb_correcta:e'); ?>value="qb_correcta:e">e</option>
               </select>
           </td>
       </tr>
    </table>

<?php
} //-->fin de funcion quizzbook_metaboxes()


function quizbook_guardar_metaboxes($post_id, $post, $update){

    if(!isset($_POST['quizbook_nonce']) || !wp_verify_nonce( $_POST['quizbook_nonce'],basename(__FILE__))){
        return $post_id;
    }

    if(!current_user_can('edit_post',$post_id)){
        return $post_id;
    }

    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
        return $post_id;
    }

    $respuesta_a = $respuesta_b = $respuesta_c = $respuesta_d = $respuesta_e = '';


     if(isset( $_POST['qb_respuesta_a'] ) ) {
       $respuesta_a = sanitize_text_field($_POST['qb_respuesta_a']);
     }
     update_post_meta($post_id, 'qb_respuesta_a', $respuesta_a );

     if(isset($_POST['qb_respuesta_b'])) {
       $respuesta_b = sanitize_text_field($_POST['qb_respuesta_b']);
     }
     update_post_meta($post_id, 'qb_respuesta_b', $respuesta_b );

     if(isset($_POST['qb_respuesta_c'])) {
       $respuesta_c = sanitize_text_field($_POST['qb_respuesta_c']);
     }
     update_post_meta($post_id, 'qb_respuesta_c', $respuesta_c );

     if(isset($_POST['qb_respuesta_d'])) {
       $respuesta_d = sanitize_text_field($_POST['qb_respuesta_d']);
     }
     update_post_meta($post_id, 'qb_respuesta_d', $respuesta_d );

     if(isset($_POST['qb_respuesta_e'])) {
       $respuesta_e = sanitize_text_field($_POST['qb_respuesta_e']);
     }
     update_post_meta($post_id, 'qb_respuesta_e', $respuesta_e );

     if(isset($_POST['quizbook_correcta'])) {
       $correcta = sanitize_text_field($_POST['quizbook_correcta']);
     }
     update_post_meta($post_id, 'quizbook_correcta', $correcta );
}

add_action( 'save_post', 'quizbook_guardar_metaboxes', 10, 3 );

?>