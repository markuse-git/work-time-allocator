jQuery(document).ready(function($){
    
    // stop our admin menus from collapsing
    if( $('body[class*=" mwta_"]').length || $('body[class*=" post-type-"]').length ) {

        $slb_menu_li = $('#toplevel_page_mwta_dashboard_admin_page');
        
        $slb_menu_li
        .removeClass('wp-not-current-submenu')
        .addClass('wp-has-current-submenu')
        .addClass('wp-menu-open');
        
        $('a:first',$slb_menu_li)
        .removeClass('wp-not-current-submenu')
        .addClass('wp-has-submenu')
        .addClass('wp-has-current-submenu')
        .addClass('wp-menu-open');
        
    }
    
    
});