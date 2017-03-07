 $(document).ready(function(){
    $(".user-mapper").click(function(){   
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: $(this).attr('value'),
            dataType:'JSON',
            data:   {
                        /*job_id: '<?=$model->job_id;?>',  */
                        status:$(this).attr('status')
                    },
            success: function (json) {             	
                $('#msg').html("<div class='alert alert-success'>Record has been added successfully</div>").fadeIn('slow');
                $('#msg').delay(3000).fadeOut('slow');               
                (json.success == true) ? $('#'+id).hide() : null ;
            },
            error: function (exception) {
                alert(exception);
            }
        });
    });

    $('button.owner-button').click(function(e){
        e.preventDefault();
        window.location = $(this).attr('value');
    });

    $('#SendMessage').on('click',function(){
        $('#modelContent').load($(this).attr('value'));
    });

    $('#MarkAsSponsor').on('click',function(){
         $('#modelContent').load($(this).attr('value'));
    });

     $('#RequestToRemove').on('click',function(){
         $('#modelContent').load($(this).attr('value'));
     });

     $('#RequestToRenew').on('click',function(){
         $('#modelContent').load($(this).attr('value'));
     });

     $('#RequestToUpgrade').on('click',function(){
         $('#modelContent').load($(this).attr('value'));
     });

 });