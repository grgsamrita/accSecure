$('.delete').click(function()
    {
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
                    
                    return false;
                }
             }
        });

    });