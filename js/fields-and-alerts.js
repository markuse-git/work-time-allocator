jQuery(document).ready(function($){
        
    // ------------DATEPICKER----------------------
    $("#idDate").datepicker();
    
    var $datepicker = $('#ui-datepicker-div');
    $datepicker.css({
        backgroundColor: 'white'
    });
    
    // prevent user from typing in manually
    $('#idDate').keydown(function(e) {
       e.preventDefault();
       return false;
    });
    
    // -------------CHECK DURATION INPUT-----------------
    $("#idDuration").change(function(){
        var duration = $(this).val();
        
        if(Number(duration)){
            parseInt(duration);
        } else{
            alert('Please insert an integer!');
        }
        
    });
    
    $("#idSubmit").click(function(e){
       if($("#idDuration").val() == ''){
           alert('Please fill in how many minutes you spent!');
           e.preventDefault();
       } 
    });
        
});