
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

        $(".job-field-25, .job-field-27, .job-field-29").hide(); //nack, chest, Shoulders

        $(".job-field-44, .job-field-45, .job-field-46, .job-field-47").hide(); //Car
        $(".job-field-37, .job-field-39, .job-field-41").hide(); //Bust Size, Cup Size , Hip Size

        //$("input:radio[name='JobFieldValue[6][value]']").trigger('click'); //Gender
        //$("input:radio[name='JobFieldValue[42][value]']").trigger('click'); //Vehical

        if ( ! $("input:radio[name='JobFieldValue[6][value]']").is(':checked') ) {
            $("input:radio[name='JobFieldValue[6][value]']").filter('[value=Male]').prop('checked', true);
        }

        var talentgender = $("input:radio[name='JobFieldValue[6][value]']:checked").val();
        if(talentgender == "Male"){
            $(".job-field-25, .job-field-27, .job-field-29 ").show(); //nack, chest, Shoulders
            $(".job-field-37, .job-field-39, .job-field-41").hide(); //Bust Size, Cup Size , Hip Size
        }
        else if(talentgender == "Female"){
            $(".job-field-25, .job-field-27, .job-field-29 ").hide(); //nack, chest, Shoulders
            $(".job-field-37, .job-field-39, .job-field-41").show(); //Bust Size, Cup Size , Hip Size
        }

        var vehicle = $("input[name='JobFieldValue[42][value]']:checked").val();
        if(vehicle  == "Yes"){
            $(".job-field-44, .job-field-45, .job-field-46, .job-field-47 ").show(); //Car
        }else if( vehicle  == "No")
        {
            $(".job-field-44, .job-field-45, .job-field-46, .job-field-47 ").hide(); //Car
        }
    });

    $("input:radio[name='JobFieldValue[6][value]']").click(function() {

        var gender = $(this).val();
        if(gender == "Male"){
            $(".job-field-25, .job-field-27, .job-field-29 ").show(); //nack, chest, Shoulders
            $(".job-field-37, .job-field-39, .job-field-41").hide(); //Bust Size, Cup Size , Hip Size
        }
        else if(gender == "Female"){

            $(".job-field-25, .job-field-27, .job-field-29 ").hide(); //nack, chest, Shoulders
            $(".job-field-37, .job-field-39, .job-field-41").show(); //Bust Size, Cup Size , Hip Size
        }
    });

    $("input:radio[name='JobFieldValue[42][value]']").click(function() {
        var vehicle = $(this).val();
        if(vehicle  == "Yes"){
            $(".job-field-44, .job-field-45, .job-field-46, .job-field-47 ").show(); //Car
        }else if( vehicle  == "No")
        {
            $(".job-field-44, .job-field-45, .job-field-46, .job-field-47 ").hide(); //Car
        }
    });
});
