<?php
add_action('init', 'ninja_forms_register_tab_addons');

function ninja_forms_register_tab_addons(){
    $args = array(
        'name' => 'Addons',
        'page' => 'ninja-forms-addons',
        'display_function' => 'ninja_forms_tab_addons',
        'save_function' => 'ninja_forms_save_addons',
        'show_save' => false,
    );
    ninja_forms_register_tab('addons', $args);

}

function ninja_forms_tab_addons(){
    echo 'Hello World';


}

function ninja_forms_save_addons($data){
    global $wpdb;

}