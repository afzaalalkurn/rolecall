
$( document ).ready(function() {

    $(".depended-field").closest("div").each(function() {
        var parentClass = $(this).prop("class");
        var parent = parentClass.split(' ');
        $('.'+parent[1]).hide();
        var childId = $(this).children('input').attr("depends");
        var inputId = $(this).children('input').attr("id");
        $('#'+childId).on('change', function() {
            $optionsArray = $(this).val();
            if($.inArray("Other",$optionsArray) != -1){
                $('.'+parent[1]).show();
            }
            else {
                $('.'+parent[1]).hide();
                $('#'+inputId).attr("value", "");
            }
        });
    });

    $(window).load(function() {

        $(".depended-field").closest("div").each(function() {
            var parentClass = $(this).prop("class");
            //console.log(parentClass);
            var parent = parentClass.split(' ');
            $('.'+parent[1]).hide();
            var childId = $(this).children('input').attr("depends");
            var inputId = $(this).children('input').attr("id");
            $optionsArray = $('#'+childId).val();
            if($.inArray("Other",$optionsArray) != -1){
                $('.' + parent[1]).show();
            }else {
                $('.'+parent[1]).hide();
                $('#'+inputId).attr("value", "");
            }
        });

        $(".user-field-29, .user-field-30, .user-field-31").hide(); //nack, chest, Shoulders
        $(".user-field-32, .user-field-33, .user-field-34").hide(); //Hip size, Bust Size, Cup Size

        $(".user-field-36, .user-field-37, .user-field-38, .user-field-39").hide(); //Car

        $(".carpics").hide();

        //$("#userprofile-gender").trigger('click'); //Gender
        //$("input:radio[name='UserFieldValue[33][value]']").trigger('click'); //Vehical

        var talentgender = $('select#userprofile-gender option:selected').val();
        if(talentgender == "Male"){
            $(".user-field-29, .user-field-30, .user-field-31").show(); //nack, chest, Shoulders
            $(".user-field-32, .user-field-33, .user-field-34").hide(); //Hip size, Bust Size, Cup Size
        }
        else if(talentgender == "Female"){
            $(".user-field-29, .user-field-30, .user-field-31").hide(); //nack, chest, Shoulders
            $(".user-field-32, .user-field-33, .user-field-34").show(); //Hip size, Bust Size, Cup Size
        }

        var vehicle = $("input[name='UserFieldValue[33][value]']:checked").val();
        if(vehicle  == "Yes"){
            $(".user-field-36, .user-field-37, .user-field-38, .user-field-39").show();
            //Car
            $(".carpics").show();//car pics
        }else {
            $(".user-field-36, .user-field-37, .user-field-38, .user-field-39").hide(); //Car
            $(".carpics").hide();//car pics
        }

    });

    $("#userprofile-gender").click(function() {

        var gender = $(this).val();
        if(gender == "Male"){
            $(".user-field-29, .user-field-30, .user-field-31").show(); //nack, chest, Shoulders
            $(".user-field-32, .user-field-33, .user-field-34").hide(); //Hip size, Bust Size, Cup Size
        }
        else if(gender == "Female"){

            $(".user-field-29, .user-field-30, .user-field-31").hide(); //nack, chest, Shoulders
            $(".user-field-32, .user-field-33, .user-field-34").show(); //Hip size, Bust Size, Cup Size
        }
    });

    $("input:radio[name='UserFieldValue[33][value]']").click(function() {
        var vehicle = $(this).val();
        if(vehicle  == "Yes"){
            $(".user-field-36, .user-field-37, .user-field-38, .user-field-39").show();
            //Car
            $(".carpics").show();//car pics
        }else if( vehicle  == "No")
        {
            $(".user-field-36, .user-field-37, .user-field-38, .user-field-39").hide(); //Car
            $(".carpics").hide();//car pics
        }
    });
});
