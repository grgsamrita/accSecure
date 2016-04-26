$(document).ready(function(){
	
    $('#pass-show').hide();        
    $('#pass-header').hide();

    $('#ok-view').click(function(){
    	var url = $('#base_url').val();
    	var id = $('#data_id').val();
        var token = $('#token').val();
        var password = $('.view-password').val();
                
        $.ajax(
        {
            url: url+'/accountdata/viewpswd/'+id+'/'+password+'?_token='+token,
            type: 'GET',           
            success: function (response)
            {
                if(response.msg == 'done'){
                    $('#pass-header').html("Your "+response.account+"'s password is").show();
                    $('#pass-show').html('Password: '+response.pass).show();                   
                    $('#ok-view').hide();
                    $('#main-close').hide();
                    $('.modal-body').hide();
                    $('#main-title').hide();
                }

                else{
                    $('#pass-show').html('Incorrect password. Please retype the correct password').show();
                    $('#pass-show').fadeOut(5000);                   
                }
            	console.log(response);
                return false;

            }
        });

    });

   $('.close').click(function(){
        $('input[type="password"]').val("");
        $('#pass-header').hide();
        $('#pass-show').hide();
        
        $('#ok-view').show();
        $('#main-close').show();
        $('.modal-body').show();
        $('#main-title').show();                    
    });
        
});
	
