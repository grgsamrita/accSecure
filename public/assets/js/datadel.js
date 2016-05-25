$('.delete').click(function()
    {
        var confirmdialog =  confirm('Are you sure you want to delete this account?');
        if(confirmdialog == true){
            $('#success').hide();
            var thisdata = $(this);
            var id = thisdata.data("id");
            var url = $('#base_url').val();
            var token = '';
            $.ajax(
            {
                url: url+'/accountdata/destroy/'+id+"?_token="+token,
                type: 'GET',
            
                success: function (response)
                {
                    if ( response.status == 'success' ) {
                        console.log('deleted');             
                        thisdata.closest('tr').fadeOut();
                        $('#success').html(response.msg).show();
                        $('#success').fadeOut(2000);                          
                        
                    }
                }
            });
        }
        else{
            return false;
        }

    });