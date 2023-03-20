<?php

// //!NO FORMATEAR

function BootstrapJs(){wp_enqueue_script('bootstrapJs', plugins_url('../admin/bootstrap/js/bootstrap.min.js', __FILE__), array('jquery'));}
function BootstrapCss(){wp_enqueue_style('BootstrapCss', plugins_url('../admin/bootstrap/css/bootstrap.min.css', __FILE__));}
function Styles(){wp_enqueue_style('Styles', plugins_url('../admin/bootstrap/styles/index.css', __FILE__));}
function callScript(){wp_enqueue_script('callScript', plugins_url('../admin/bootstrap/scripts/main.js', __FILE__), array('jquery'));}
function callFontAwesomeCnd(){wp_enqueue_style('load-fa', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css');}

//ACTIONS FOR PATH
add_action('admin_enqueue_scripts', 'BootstrapJs');
add_action('admin_enqueue_scripts', 'BootstrapCss');
add_action('admin_enqueue_scripts', 'Styles');
add_action('admin_enqueue_scripts', 'callScript');
add_action('admin_enqueue_scripts', 'callFontAwesomeCnd');
