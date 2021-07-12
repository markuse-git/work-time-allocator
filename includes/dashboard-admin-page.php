<?php

function mwta_dashboard_admin_page(){
    $output = '
        <div class="wrap">
            
            <h2>Work Time Allocator</h2>
            
            <h4>The ok work time allocation plugin for WordPress.</h4>
            
            <p>
                <ol>
                    <li>
                        First, go to Users and give the role "Employee" to those to work with the plugin.
                        Its capabilities are the same as those of the "Editor" role. In the "Employees" section
                        you will only be able to choose Employees and Anministrators. 
                    </li>
                    <li>
                        Next, create Occupations then Employees then Clients and last Jobs.
                    </li>
                    <li>
                        In the Options section you need to choose the currency you work with and provide email 
                        addresses to send reports to. 
                    </li>
                    <li>
                        Put the shortcode [timetracker] on the page on which you want to book the times you spent
                        working on jobs.
                    </li>
                </ol>
            </p>
        
        </div>
    ';
    
    echo $output;
}

?>