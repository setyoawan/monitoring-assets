<?php
function template($dir, $data = array())
{
    $CI = &get_instance();
    $CI->load->view('templates/header', $data);
    $CI->load->view('templates/sidebar', $data);
    $CI->load->view('templates/topbar', $data);
    $CI->load->view($dir, $data);
    $CI->load->view('templates/footer', $data);
}
