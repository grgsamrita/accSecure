$('.modal-update').click(function()
    {
        $('#update-title').show();
        $('.modal-body').show();
        $('#dataupdate').show();
        $('#updatecancel').show();
        $('#update-header').hide();
        $('#success-header').hide();
        var thisbranch = $(this);
        var id = thisbranch.data("id");
        var url = $('#base_url').val();
        var token = $('#token').val();
        $.ajax(
        {
            url: url+'/accountdata/update/'+id+"?_token="+token,
            type: 'GET',
            
            success: function (response)
            {
              if(response.msg=='done'){
                
                $('#updateusername').val(response.username);
                $('#updateoldpass').val('');
                $('#updatenewpass').val('');
                $('#updaterempass').val('');
                

              }
                
                    
                
             }
        });

    });

$('#dataupdate').click(function(){
		// console.log('ji');
    
		var url = $('#base_url').val();
    	var token = $('#token').val();
      var id = $('#datahidden_id').val();
      var button = $("button[data-id="+id+"]");
      
    	$.ajax({
	    	url: url+'/accountdata/update',
	    	type: 'POST',
	    	data: {
	    		username: $('#updateusername').val(),
	    		old_password: $('#updateoldpass').val(),
          new_password: $('#updatenewpass').val(),
          remember_password: $('#updaterempass').val(),
          id: id,
	    		_token: token
	    	},
	    	success:function(response) {
	 			  console.log(response);
          if(response.msg == 'done'){ 

            $('#success-header').html('Updated successfully!!').show();
            $('#update-title').hide();
            $('#update-header').hide();
            $('.modal-body').hide();
            $('#dataupdate').hide();
            $('#updatecancel').hide();
            
            button.closest('tr').find('.username').text(''+response.username);
                      
            
          }
          if(response.warning == 'not_match'){
            $('#update-header').html(response.message).show(); 
            $('#success-header').hide();
          }
          if(response.warning == 'incorrect'){
            $('#update-header').html(response.message).show(); 
            $('#success-header').hide();
          }
          
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
        $('#update-header').html(displayErrors).show();  
                
			}
	  });

  
	});