<?php 



function is_logged_in(){
    $ci=get_instance();

    if (!$ci->session->userdata('user')) {
        redirect('machito_screen');
    } 
    
    // else{
    //     $role_id=$ci->session->userdata('role_id');
    // }
}


// function logged_in()
// {

//     $ci = get_instance();

//     if ($ci->session->userdata('user') != NULL) {
//         redirect('Machito_menu');
//     }
// }