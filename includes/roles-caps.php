<?php

class WTA_Roles {

    function __construct(){

        register_activation_hook(dirname(__DIR__,1) . '/work-time-allocator.php', array(&$this, 'mwta_activation'));
        register_deactivation_hook(dirname(__DIR__,1) . '/work-time-allocator.php', array( &$this, 'mwta_deactivation'));
    }
    
    function mwta_activation(){

        //$role =& get_role('editor');
        $role = get_role('editor');
        $role->add_cap('manage_options'); 
        add_role('employee','Employee',$role->capabilities);
                
    }

    function mwta_deactivation(){

        $role =& get_role('editor');
        $role->remove_cap('manage_options'); 

        $roles_to_delete = array(
            'employee'
        );

        foreach ($roles_to_delete as $role){

            $users = get_users(array('role' => $role));
            
            foreach($users as $user){
                $user->add_role('editor');
                $user->remove_role($role);
            }
            
            $users = get_users(array('role' => $role));
            
            if(count($users) <= 0){

                remove_role($role);
            }
            
        }
    }
   
}

$mwta_roles = new WTA_Roles();

?>