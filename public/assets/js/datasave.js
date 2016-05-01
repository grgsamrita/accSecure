$('#save').click(function(){
		// console.log('ji');
		var url = $('#base_url').val();
    	var token = $('#token').val();
    	$.ajax({
	    	url: url+'/accountdata/add',
	    	type: 'POST',
	    	data: {
	    		account: $('#accountid').val(),
          account_name: $('#accountname').val(),
	    		username: $('#username').val(),
	    		password: $('#password').val(),
	    		_token: token
	    	},
	    	success:function(response) {
	 			  console.log(response);
          
          if(response == 'done'){
            console.log(response);
            $('#add-account').fadeOut();
            $('.notify').html('One new account added!!');
            $('.notify').fadeOut(4000);
            window.location.reload();
          }
          if(response.warning == 'matches'){
            $('#errors').html(response.msg); 
          }
          // else{
          //   $('#errors').html('Cannot be added. please enter the valid account name');
          // }
			},

			error:function(data){
			
        var errors = data.responseJSON;
        console.log(errors);
        var displayErrors = '<ul>';

        // errors are in array form so we need errors not success so we write errors.errors
        $.each( errors.errors, function( key, value ) {
          displayErrors += '<li>' + value + '</li><br/>';
        });

        displayErrors += '</ul>';
        $('#errors').html(displayErrors);  
                
			}
	  });
	});