<?php

session_start();

add_shortcode('timetracker','mwta_create_timetracker');

function mwta_create_timetracker(){
    
    if(is_user_logged_in()){
        $role = wp_get_current_user()->roles[0];    
    }
        
    if(is_user_logged_in() && ($role == 'employee' || $role == 'administrator')){
    
    $jobs = new WP_Query(array(
                    'post_type' => 'jobs',
                    'posts_per_page' => -1,
                    'meta_key' => 'closed',
                    'meta_query' => array( // Damit nur offene Jobs in die Jobauswahl gehen
                        'key' => 'closed',
                        'value' => '1',
                        'compare' => '!='
                    )
                ));
    
    $clients = new WP_Query(array(
                    'post_type' => 'clients',
                    'posts_per_page' => -1
                ));
    
?>
<!-----------------------------INPUT FIELDS------------------------------>    
        <form method="post">
            
            <?php
            $rand = rand();
            $_SESSION['rand'] = $rand;
            ?>
            
            <input type="hidden" value="<?php echo $rand;?>" name="randcheck">
            
            <p><Label for="idDate">Date</label>
            <input name="entry_date" id="idDate" value="<?php echo date("d. F Y",time());?>"></p>
            
            <p><label for="idClient">Client</label>
            <select name="client" id="idClient"> 
            
                <?php        
                while($clients->have_posts()){ 
                    $clients->the_post(); ?>
                        <option class="clients"><?php the_field("name");?></option>                    
                <?php } 
                ?>
        
            </select>
            </p>
            
            <?php
    
                $job_repository = [];
                while($jobs->have_posts()){
                    $jobs->the_post();
                    $client = get_field('client');
                    $job = get_field('job_title');
                    $job_repository[] = array($client->name => $job);
                }
    
            ?>
            
            <script>
                var jobs_json = <?php echo json_encode($job_repository);?>;
            </script>
            
            <p><label for="idJob">Job</label>
            <select name="job" id="idJob"></select>
            </p>
            
            <p><label for="idDuration">Minutes*</label>
            <input name="duration" id="idDuration"></p>
            
            <p><input type="submit" id="idSubmit" name="submit" value="add time"></p>
            
        </form>

<!------------------------------GET TABLE DATA---------------------------------------->

<?php
    
    global $wpdb;
        
    $sql_query = 'SELECT job, time_id, employee, date_entry, meta_value, post_id, duration, meta_key 
    FROM ' . $wpdb->prefix . 'allocation AS al
    JOIN ' . $wpdb->prefix . 'postmeta AS posts ON al.job = posts.meta_value
    WHERE employee = "' . wp_get_current_user()->display_name . '" 
    ORDER BY time_id
    DESC LIMIT 10 '; 
        
    function mwta_get_shortcut($client_name){
        
        global $wpdb;
        $shortcut_query = 'SELECT post_id, meta_key, meta_value
        FROM ' . $wpdb->prefix . 'postmeta
        WHERE meta_key = "name"
        AND meta_value = "' . $client_name  . '" ';
        
        $shortcut_result = $wpdb->get_results($shortcut_query);
        
        if(!empty($shortcut_result)){
            $shortcut_post_id = $shortcut_result[0]->post_id;
        
            return $shortcut_post_id;    
        } else{
            return '';
        }
        
    }
                
?>

        <form method="post">
            <table>
                <tr>    
                    <th>Pick</th>
                    <th>Date</th>
                    <th>Client</th>
                    <th>User</th>
                    <th>Job</th>
                    <th>Minutes</th>
                </tr>
                
                <?php 
                    require_once(ABSPATH . 'wp-includes/pluggable.php');    
                    $current_user = wp_get_current_user();
    
                    global $wpdb; 
                    $results = $wpdb->get_results($sql_query);
            
                    try{
                        foreach($results as $result){ 
                            $client_name = get_field('client',$result->post_id)->name;
                            $shortcut_post_id = mwta_get_shortcut($client_name);
                    ?>
                        <tr>
                            <td><input type="radio" name="delete" value="<?php echo $result->time_id; ?>"></td>
                            <td><?php echo date('Y-m-d', strtotime($result->date_entry));?></td>
                            <td><?php echo get_field('shortcut',$shortcut_post_id);?></td>
                            <td><?php echo $result->employee;?></td>
                            <td><?php echo $result->job;?></td>
                            <td><?php echo $result->duration;?></td>
                        </tr>
                        <?php } 
                    } catch(Exception $e){
                        
                    } ?>
        
            </table>
            
            <input type="submit" name="delete_entry" value="Delete">
        </form>

<?php } else{
        echo "Sorry, for employees only!";
    }

}
    
//-----------------------------CREATE TABLE----------------------------------------------

$tablename = "wp_allocation";

$sql = "CREATE TABLE IF NOT EXISTS $tablename(
    time_id INT(11) NOT NULL AUTO_INCREMENT,
    job VARCHAR(120) NOT NULL,
    employee VARCHAR(100) NOT NULL,
    date_entry DATETIME NOT NULL,
    duration INT(11) NOT NULL,
    PRIMARY KEY(time_id)
);";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); // um dbDelta() zu ermöglichen

dbDelta($sql);

//--------------------------------INSERT--------------------------------------------------    

if(isset($_POST['submit']) && $_POST['randcheck'] == $_SESSION['rand'] ){ // && ... um resubmit nach refresh zu vermeiden
    
    require_once(ABSPATH . 'wp-includes/pluggable.php'); // um wp_get_current_user() zu ermöglichen   
    $current_user = wp_get_current_user();
            
    $newdata = array(
        'job' => sanitize_text_field($_POST['job']),
        'employee' => $current_user->display_name,
        'date_entry' => date('Y-m-d', strtotime(sanitize_text_field($_POST['entry_date']))),
        'duration' => absint(sanitize_text_field($_POST['duration'])),
    );
    
    $wpdb->insert(
        $tablename,
        $newdata
    );
    
}
    
/*-----------------------------DELETE-------------------------------------------------------------*/

if(isset($_POST['delete_entry'])){
    $wpdb->delete($wpdb->prefix . 'allocation',array('time_id' => sanitize_text_field($_POST['delete'])));    
}

?>