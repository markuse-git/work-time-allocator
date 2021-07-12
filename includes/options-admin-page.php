<?php

function mwta_options_admin_page(){ ?>

    <div class="wrap">
        <h2>Options</h2>
        <?php settings_errors();?>
        <form action="options.php" method="post">
            
            <?php settings_fields('mwta_reports_group'); ?>
            <?php do_settings_sections('mwta_options_admin_page'); ?>
            
            <?php submit_button();?>
        </form>
    </div>

<?php }

// Register and define the settings
add_action('admin_init', 'mwta_settings_init');

function mwta_settings_init(){
    register_setting(
        'mwta_reports_group',
        'mwta_path_option'
    );
    register_setting(
        'mwta_reports_group',
        'mwta_email_option'
    );
    register_setting(
        'mwta_reports_group', 
        'mwta_currency_option'
    );
    
    add_settings_section(
        'mwta_settings_general',
        'General Settings',
        'mwta_general_section_text',
        'mwta_options_admin_page'
    );
    add_settings_section(
        'mwta_settings_report',
        'Report Settings',
        'mwta_report_section_text',
        'mwta_options_admin_page'
    );
        
    add_settings_field(
        'mwta_email',
        'Email Adresses',
        'mwta_email_input',
        'mwta_options_admin_page',
        'mwta_settings_report'
    );
    add_settings_field(
        'mwta_currency_option',
        'Choose the currency you use',
        'mwta_currency_input',
        'mwta_options_admin_page',
        'mwta_settings_general'
    );
}

// Draw the section header
function mwta_report_section_text() {
    echo '<p>Enter address to send reports to. You can enter multiple addresses. Please separate with ","</p>';
}
function mwta_general_section_text() {
    echo '<p>Enter your general settings here.</p>';
}

function mwta_email_input(){
    $email = get_option( 'mwta_email_option' );
    echo "<input id='email' name='mwta_email_option' size='50' type='email' value='$email' multiple/>";
}

function mwta_currency_input(){ 
    $options = get_option('mwta_currency_option'); 
    ?>

    $ <input type="radio" name="mwta_currency_option" value="$" <?php echo ($options == '$') ? 'checked' : 'unchecked';?>> 
    € <input type="radio" name="mwta_currency_option" value="€" <?php echo ($options == '€') ? 'checked' : 'unchecked';?>> 
    £ <input type="radio" name="mwta_currency_option" value="£" <?php echo ($options == '£') ? 'checked' : 'unchecked';?>> 
    
<?php }

?>