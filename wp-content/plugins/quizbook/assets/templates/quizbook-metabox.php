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