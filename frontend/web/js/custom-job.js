
$( document ).ready(function() {

    $(window).load(function() {

        $(".job-field-25, .job-field-27, .job-field-29").hide(); //nack, chest, Shoulders

        $(".job-field-44, .job-field-45, .job-field-46, .job-field-47").hide(); //Car
        $(".job-field-37, .job-field-39, .job-field-41").hide(); //Bust Size, Cup Size , Hip Size
        $("input:radio[name='JobFieldValue[6][value]']").trigger('click'); //Gender
        $("input:radio[name='JobFieldValue[42][value]']").trigger('click'); //Vehical

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
