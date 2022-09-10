    <form name="quizbook_enviar" id="quizbook_enviar">
        <div id="quizbook" class="quizbook">
            <ul>
                <?php while($quizbook->have_posts()): $quizbook->the_post(); ?>
                <li >
                    <?php the_title("<h2>", "</h2>"); ?>
                    <?php the_content();?>
                    <?php 
                        $opciones=get_post_meta(get_the_ID());
                        foreach($opciones as $llave=>$opcion){
                           \Quizbook\ShortCodeRender::renderOpcionIfQuizbook($llave,$opcion);
                        } 

                    ?>
                    
                </li>            
                <?php endwhile; wp_reset_postdata(); ?>
            </ul>            
        </div>
        <input type="submit" value="Enviar" id="quizbook_btn_submit">

        <div id="quizbook_resultado"></div>

    </form><!--form quizbook_enviar -->