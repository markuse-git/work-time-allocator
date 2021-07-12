jQuery(document).ready(function($){
    
    var client_jobs = [];
    
    function mwta_add_jobs(){
        
        client_jobs = []; 
        var selected_client = $("#idClient :selected").val(); 
                        
        for(var i in jobs_json){ 
            var entry = jobs_json[i]; 
            for(var key in entry){             
                if(key == selected_client){ 
                    client_jobs.push(entry[key]) 
                }
            } 
        }
        
        if( client_jobs.length > 0  ){
                
            for(let item of client_jobs){
                var optionElement = document.createElement('option');
                optionElement.setAttribute('class','job_option');
                var optionText = document.createTextNode(item);
                optionElement.append(optionText);
                $("#idJob").append(optionElement);
            }        
        
        } else{
            var optionElement = document.createElement('option');
            optionElement.setAttribute('class','job_option');
            var optionText = document.createTextNode('No open job available');
            optionElement.append(optionText);
            $("#idJob").append(optionElement);
        }
        
    }
    
    mwta_add_jobs();
    
    $("#idClient").change(function(){
        $('.job_option').remove();
        mwta_add_jobs();
    });
            
});