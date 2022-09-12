<?php

define("QUIZBOOK_POSTTYPE_NAME","quizes");
define("QUIZBOOK_METABOX_ID","quizbook_meta_box");
define("QUIZBOOK_METABOX_TITLE","Respuestas");
define("QUIZBOOK_ASSETS_BASE_PATH", plugin_dir_path(__FILE__)."assets/");
define("QUIZBOOK_METABOX_TEMPLATE_PATH",QUIZBOOK_ASSETS_BASE_PATH."templates/quizbook-metabox.php");
define("QUIZBOOK_SHORTCODE_TEMPLATE_PATH",QUIZBOOK_ASSETS_BASE_PATH."templates/quizbook-shortcode-tpl.php");
define("QUIZBOOK_SCRIPTS_PATH",plugins_url('/assets/js/quizbook.js', __FILE__));
define("QUIZBOOK_CSS_FRONT_PATH",plugins_url('/assets/css/quizbook.css', __FILE__));
define("QUIZBOOK_CSS_ADMIN_PATH",plugins_url('/assets/css/admin-quizbook.css', __FILE__));
define("QUIZBOOK_METABOX_NONCE","quizbook_nonce");
define("QUIZBOOK_ROLES_ROL_NAME","quizbook");
define("QUIZBOOK_ROLES_DISPLAY_NAME","Quiz");
define("QUIZBOOK_MINIMUN_SCORE",60);
define("QUIZBOOK_MIN_VALID_SCORE",0);
define("QUIZBOOK_MAX_VALID_SCORE",100);