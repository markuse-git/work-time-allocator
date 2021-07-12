<?php

add_filter('acf/save_post','mwta_create_report',1); 

require __DIR__ . '/../fpdf/fpdf.php';

class MyPDF extends FPDF{    
    function Header(){ 
        $this->SetFont("Helvetica","B",16);
        $this->Cell(0,20,"Job Report","B",1,"C"); 
        $this->Ln(); 
    }
}

function mwta_create_report($post_id){
    
    $old_value = get_field('closed',$post_id);
    $new_value = sanitize_text_field($_POST['acf']['field_5f67a037e3154']);
    
    //$path_option = get_option('mwta_path_option');
    $path_option = __DIR__ . '/../reports/';
    $email_option = get_option('mwta_email_option');
    
    $currency_option = get_option('mwta_currency_option');
    switch($currency_option){
        case "€":
            $currency_option = chr(128);
            break;
        case "$":
            $currency_option = chr(36);
            break;
        case "£":
            $currency_option = chr(163);
            break;
    }
    

    if($old_value == '1' && $new_value == '0'){ // delete existing report
        
        global $wpdb;
        $wpdb->delete('wp_costs',array('job_id' => $post_id));
        
        unlink($path_option . $post_id . '_report.pdf');
        
    } elseif(($old_value == '' || $old_value = '0') && $new_value == '1'){ // create report
        
        $jobs = new WP_Query(array(
                    'post_type' => 'jobs',
                    'posts_per_page' => -1,
                    'meta_key' => 'closed'
                    )
                );

        $pdf = new MyPDF();
        
        $pdf->AliasNbPages();
        $pdf->AddPage(); 
        $pdf->SetFont("Helvetica","",11);
        
        $start = get_post_time($format = 'U', $gmt = true, $post = $post_id);
        $completion = time(); 
        $duration = ($completion - $start)/60/60/24;
        $job_title = get_field('job_title',$post_id);
        $client = get_field('client',$post_id)->name;

        $pdf->Cell(50,5,"Job-Nr.:",0,0,"L");
        $pdf->Cell(30,5,$post_id,0,0,"R");
        $pdf->Ln();
        $pdf->Cell(50,5,"Job Title:",0,0,"L");
        $pdf->Cell(30,5,$job_title,0,0,"R");
        $pdf->Ln();
        $pdf->Cell(50,5,"Client:",0,0,"L");
        $pdf->Cell(30,5,$client,0,0,"R"); 
        $pdf->Ln();
        $pdf->Cell(50,5,"Start:",0,0,"L");
        $pdf->Cell(30,5,date('Y-m-d', $start),0,0,"R");
        $pdf->Ln();
        $pdf->Cell(50,5,"Completion:",0,0,"L");
        $pdf->Cell(30,5,date('Y-m-d', $completion),0,0,"R");
        $pdf->Ln();
        $pdf->Cell(50,5,"Duration:",0,0,"L");
        $pdf->Cell(30,5,number_format($duration,2,",",".") . ' days',0,0,"R");
        $pdf->Ln();       
        
        
        global $wpdb;
        
        $job_time_query = 'SELECT job, employee, date_entry, meta_value, post_id, SUM(duration) as sum, meta_key 
        FROM ' . $wpdb->prefix . 'allocation AS al
        JOIN ' . $wpdb->prefix . 'postmeta AS posts ON al.job = posts.meta_value
        WHERE job = "' . get_field('job_title',$post_id) . '" 
        Group BY employee';

        $job_results = $wpdb->get_results($job_time_query);
        
        function get_user($search_term){
            $user = get_users(array(
                'search' => $search_term
            ));
            return $user[0]->ID;
        }
        
        function mwta_id_correlation($user_id){
            global $wpdb;
            $corr_query = 'SELECT meta_value, meta_key, post_id, post_author, post_status 
            FROM ' . $wpdb->prefix . 'postmeta AS postmeta 
            JOIN ' . $wpdb->prefix . 'posts AS posts ON postmeta.post_id = posts.ID
            WHERE meta_value = ' . $user_id . '
            AND meta_key = "display_name"
            AND post_status <> "trash"';

            $corr_res = $wpdb->get_results($corr_query);
            return $corr_res;
        }
        
        function mwta_id_occupation($occupation){
            global $wpdb;
            $occ_query = 'SELECT meta_value, meta_key, post_id 
            FROM ' . $wpdb->prefix . 'postmeta 
            WHERE meta_key = "occupation" 
            AND meta_value = "' . $occupation . '" ';

            $occ_res = $wpdb->get_results($occ_query);
            return $occ_res;
        }
         
        $pdf->SetFont("Helvetica","B",12);    
        
        $pdf->Ln();
        $pdf->Cell(50,15,"Costs Structure",0,0,"L");     
        $pdf->Ln();    

        $total_costs = 0;
        $total_price = 0;
        
        $pdf->Cell(50,5,"Employee:",0,0,"L");
        $pdf->Cell(30,5,"Hours:",0,0,"R");
        $pdf->Cell(30,5,"Costs:",0,0,"R");
        $pdf->Ln();
        
        $pdf->SetFont("Helvetica","",11);
        
        $occupations = [];
       
        foreach($job_results as $jr){
            $user_id = get_user($jr->employee);
            $corr_post = mwta_id_correlation($user_id);
            $corr_post_id = $corr_post[0]->post_id;
            $costs_per_hour = get_field('costs_per_hour',$corr_post_id);
            $costs_per_person = $jr->sum/60 * $costs_per_hour;
            $total_costs += $costs_per_person;
            
            $occupation = get_field('occupation',$corr_post_id)->occupation;
            $occ_post = mwta_id_occupation($occupation);
            $occ_post_id = $occ_post[0]->post_id;
            $price_per_hour = get_field('price_per_hour',$occ_post_id);
            $price_per_person = $jr->sum/60 * $price_per_hour;
            $total_price += $price_per_person;
            
            if(array_key_exists($occupation, $occupations)){
                $occupations[$occupation][0] += $jr->sum;
                $occupations[$occupation][1] += $price_per_person;
            } else{
                $occupations += [$occupation => [$jr->sum, $price_per_person]];
            }
            
            $pdf->Cell(50,5,$jr->employee,0,0,"L");
            $pdf->Cell(30,5,number_format($jr->sum/60,2,",","."),0,0,"R");
            $pdf->Cell(30,5,number_format($costs_per_person,2,",","."),0,0,"R");
            $pdf->Cell(30,5,$currency_option,0,0,"L");
            $pdf->Ln();
        }
        
        $pdf->SetFont("Helvetica","B",11);
        
        $pdf->Ln();
        $pdf->SetLineWidth(0.4);  
        
        $pdf->Cell(50,7,"Total","T",0,"L");
        $pdf->Cell(30,7,"","T",0,"L");
        $pdf->Cell(30,7,number_format($total_costs,2,",","."),"T",0,"R");   
        $pdf->Cell(8,7,$currency_option,"T",0,"L");
        $pdf->Ln();    
        
        
        $tablename = $wpdb->prefix . 'costs';
    
        $costs_sql = "CREATE TABLE IF NOT EXISTS $tablename(
            job_id INT(11) NOT NULL,
            client VARCHAR(120) NOT NULL,
            costs FLOAT(11) NOT NULL,
            closing_date DATETIME NOT NULL,
            PRIMARY KEY(job_id)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($costs_sql);

        require_once(ABSPATH . 'wp-includes/pluggable.php');    
     
        $newdata = array(
            'job_id' => $post_id,
            'client' => $client,
            'costs' => $total_costs,
            'closing_date' => date('Y-m-d', $completion)
        );
        $wpdb->insert(
            $tablename,
            $newdata
        );

        
        $pdf->SetFont("Helvetica","B",12);    
        
        $pdf->Ln();
        $pdf->Cell(50,15,"Regular Price Structure",0,0,"L");     
        $pdf->Ln();
                
        $pdf->Cell(50,5,"Occupation:",0,0,"L");
        $pdf->Cell(30,5,"Hours:",0,0,"R");
        $pdf->Cell(30,5,"Price:",0,0,"R");
        $pdf->Ln();
        
        $pdf->SetFont("Helvetica","",11);
                
        foreach($occupations as $key => $value){
            $pdf->Cell(50,5,$key,0,0,"L");
            $pdf->Cell(30,5,number_format($value[0]/60,2,",","."),0,0,"R");
            $pdf->Cell(30,5,number_format($value[1],2,",","."),0,0,"R");
            $pdf->Cell(30,5,$currency_option,0,0,"L");
            $pdf->Ln();
        }
                
        $pdf->SetFont("Helvetica","B",11);
        
        $pdf->Ln();
        $pdf->SetLineWidth(0.4);    // Linie über 'Gesamt'
        
        $pdf->Cell(50,7,"Regular Price","T",0,"L");
        $pdf->Cell(30,7,"","T",0,"L");
        $pdf->Cell(30,7,number_format($total_price,2,",","."),"T",0,"R");
        $pdf->Cell(8,7,$currency_option,"T",0,"L");
        $pdf->Ln();  
        
        
        $price_set = get_field('price',$post_id);
        
        $pdf->SetFont("Helvetica","B",12);    

        $pdf->Ln();
        $pdf->Cell(50,15,"Summary",0,0,"L");     
        $pdf->Ln();
        
        if($price_set == NULL){
            
            $current_month = date('m',time());
            $current_year = date('Y',time());

            $costs_query = 'SELECT client, SUM(costs) as sum
            FROM ' . $wpdb->prefix . 'costs
            WHERE client = "' . $client . '"
            AND MONTH(closing_date) = ' . $current_month . '
            AND YEAR(closing_date) = ' . $current_year . '';

            $costs_res = $wpdb->get_results($costs_query);

            $fee_query = 'SELECT post_id, meta_key, meta_value
            FROM '  . $wpdb->prefix . 'postmeta
            WHERE meta_key = "name" 
            AND meta_value = "' . $client . '" ';

            $fee_res = $wpdb->get_results($fee_query);

            $clients_post_id = $fee_res[0]->post_id;
            $monthly_fee = get_field('monthly_fee',$clients_post_id);
            $costs = $costs_res[0]->sum;
            $budget_remaining = $monthly_fee - $costs;
            
            $pdf->SetFont("Helvetica","",11);

            $pdf->Cell(50,5,"Remaining Budget: ",0,0,"L");
            $pdf->Cell(30,5,number_format($budget_remaining,2,",","."),0,0,"R");
            $pdf->Cell(30,5,$currency_option,0,0,"L");
            $pdf->Ln();

            $pdf->Cell(50,5,"Monthly Fee: ",0,0,"L");
            $pdf->Cell(30,5,number_format($monthly_fee,2,",","."),0,0,"R");
            $pdf->Cell(30,5,$currency_option,0,0,"L");
            $pdf->Ln();

            $pdf->Cell(50,5,"This Month Total Costs: ",0,0,"L");
            $pdf->Cell(30,5,number_format($costs,2,",","."),0,0,"R");
            $pdf->Cell(30,5,$currency_option,0,0,"L");
            $pdf->Ln();
            
        } else{
            
            $marginal_return = $price_set - $total_costs;
            $set_regular_price = $price_set - $total_price;

            $pdf->SetFont("Helvetica","",11);    

            $pdf->Cell(50,5,"Set Price: ",0,0,"L");
            $pdf->Cell(30,5,number_format($price_set,2,",","."),0,0,"R");
            $pdf->Cell(30,5,$currency_option,0,0,"L");
            $pdf->Ln();
            $pdf->Cell(50,5,"Marginal Return: ",0,0,"L");
            $pdf->Cell(30,5,number_format($marginal_return,2,",","."),0,0,"R");
            $pdf->Cell(30,5,$currency_option,0,0,"L");
            $pdf->Ln();
            $pdf->Cell(50,5,"Set Price - Regular Price: ",0,0,"L");
            $pdf->Cell(30,5,number_format($set_regular_price,2,",","."),0,0,"R");
            $pdf->Cell(30,5,$currency_option,0,0,"L");
            $pdf->Ln();
            
        }

        $pdf->Output($path_option . $post_id . '_report.pdf','F');   
        
        wp_mail($email_option, "New Report, Job: $post_id", "The job $job_title has been closed and a new report was generated.","",__DIR__ . "/../reports/" . $post_id . '_report.pdf');
    
    }

}

?>