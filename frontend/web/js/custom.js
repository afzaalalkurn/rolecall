
$( document ).ready(function() {

    $(".depended-field").closest("div").each(function() {
        var parentClass = $(this).prop("class");
        var parent = parentClass.split(' ');
        $('.'+parent[1]).hide();
        var childId = $(this).children('input').attr("depends");
        $('#'+childId).on('change', function() {
            $optionsArray = $(this).val();
            if($.inArray("Other",$optionsArray) != -1){
                $('.'+parent[1]).show();
            }
            else {
                $('.'+parent[1]).hide();
            }
        });
    });

    $(window).load(function() { $("#userprofile-gender").trigger('click'); });


    $("#w4-container").hide();
    $("#w5-container").hide();
    $("#w6-container").hide();
    $("#w10-container").hide();
    $("#w11-container").hide();

    $(".field-jobfieldvalue-40-value").parent().hide();
    $(".field-jobfieldvalue-43-value").hide();
    $(".field-jobfieldvalue-44-value").hide();
    $(".field-jobfieldvalue-45-value").hide();
    $(".field-jobfieldvalue-46-value").hide();

    $(".29").hide();
    $(".30").hide();
    $(".31").hide();
    $(".32").hide();
    $(".33").hide();
    $(".34").hide();
    $(".36").hide();
    $(".37").hide();
    $(".38").hide();
    $(".39").hide();
    $(".40").hide();
    $(".41").hide();
    $(".42").hide();
    $(".43").hide();



    $("#userprofile-gender").click(function() {

        var gender = $(this).val();
        if(gender == "Male")
        {
            $(".29").show();
            $(".30").show();
            $(".31").show();
            $(".32").hide();
            $(".33").hide();
            $(".34").hide();
        }
        else if(gender == "Female")
        {
            $(".29").hide();
            $(".30").hide();
            $(".31").hide();
            $(".32").show();
            $(".33").show();
            $(".34").show();
        }

    });


    $("input:radio[name='UserFieldValue[34][value]']").click(function() {
        var vehicle = $(this).val();
        if(vehicle == "Yes")
        {
            $(".36").show();
            $(".37").show();
            $(".38").show();
            $(".39").show();
            $(".40").show();
            $(".41").show();
            $(".42").show();
            $(".43").show();
        }
        else if(vehicle == "No")
        {
            $(".36").hide();
            $(".37").hide();
            $(".38").hide();
            $(".39").hide();
            $(".40").hide();
            $(".41").hide();
            $(".42").hide();
            $(".43").hide();
        }
    });

    $("input:radio[name='JobFieldValue[6][value]']").click(function() {
        var gender = $(this).val();

        if(gender == "Male")
        {
            $("#w4-container").show();
            $("#w5-container").show();
            $("#w6-container").show();
            $("#w10-container").hide();
            $("#w11-container").hide();

            $(".field-jobfieldvalue-40-value").parent().hide();
        }
        else if(gender == "Female")
        {
            $("#w4-container").hide();
            $("#w5-container").hide();
            $("#w6-container").hide();
            $("#w10-container").show();
            $("#w11-container").show();
            $(".field-jobfieldvalue-40-value").parent().show();
        }
    });


    $("input:radio[name='JobFieldValue[42][value]']").click(function() {
        var jobvehicle = $(this).val();
        if(jobvehicle == "Yes")
        {
            $(".field-jobfieldvalue-43-value").show();
            $(".field-jobfieldvalue-44-value").show();
            $(".field-jobfieldvalue-45-value").show();
            $(".field-jobfieldvalue-46-value").show();
        }
        else if(jobvehicle == "No")
        {
            $(".field-jobfieldvalue-43-value").hide();
            $(".field-jobfieldvalue-44-value").hide();
            $(".field-jobfieldvalue-45-value").hide();
            $(".field-jobfieldvalue-46-value").hide();
        }
    });

    $( window ).load(function() {

        $(".depended-field").closest("div").each(function() {
            var parentClass = $(this).prop("class");
            //console.log(parentClass);
            var parent = parentClass.split(' ');
            $('.'+parent[1]).hide();
            var childId = $(this).children('input').attr("depends");
            $optionsArray = $('#'+childId).val();
            if($.inArray("Other",$optionsArray) != -1){
                $('.' + parent[1]).show();
            }else {
                $('.'+parent[1]).hide();
            }
        });

        var jobvehicle = $("input:radio[name='JobFieldValue[42][value]']:checked").val();
        if(jobvehicle == "Yes")
        {
            $(".field-jobfieldvalue-43-value").show();
            $(".field-jobfieldvalue-44-value").show();
            $(".field-jobfieldvalue-45-value").show();
            $(".field-jobfieldvalue-46-value").show();
        }
        else if(jobvehicle == "No")
        {
            $(".field-jobfieldvalue-43-value").hide();
            $(".field-jobfieldvalue-44-value").hide();
            $(".field-jobfieldvalue-45-value").hide();
            $(".field-jobfieldvalue-46-value").hide();
        }

        var talentgender = $("input:radio[name='JobFieldValue[6][value]']:checked").val();
        if(talentgender == "Male")
        {
            $("#w4-container").show();
            $("#w5-container").show();
            $("#w6-container").show();
            $("#w10-container").hide();
            $("#w11-container").hide();
            $(".field-jobfieldvalue-40-value").parent().hide();
        }
        else if(talentgender == "Female")
        {
            $("#w4-container").hide();
            $("#w5-container").hide();
            $("#w6-container").hide();
            $("#w10-container").show();
            $("#w11-container").show();
            $(".field-jobfieldvalue-40-value").parent().show();
        }


        var gender = $("input:radio[name='UserFieldValue[17][value]']:checked").val();
        if(gender == "Male")
        {
            $(".29").show();
            $(".30").show();
            $(".31").show();
            $(".32").hide();
            $(".33").hide();
            $(".34").hide();
        }
        else if(gender == "Female")
        {
            $(".29").hide();
            $(".30").hide();
            $(".31").hide();
            $(".32").show();
            $(".33").show();
            $(".34").show();
        }

        var vehicle = $("input[name='UserFieldValue[34][value]']:checked").val();

        if(vehicle == "yes")
        {
            $(".36").show();
            $(".37").show();
            $(".38").show();
            $(".39").show();
            $(".40").show();
            $(".41").show();
            $(".42").show();
            $(".43").show();
        }
        else if(vehicle == "no")
        {
            $(".36").hide();
            $(".37").hide();
            $(".38").hide();
            $(".39").hide();
            $(".40").hide();
            $(".41").hide();
            $(".42").hide();
            $(".43").hide();
        }

    });
});
