
$( document ).ready(function() {

    $(window).load(function() {

        $(".user-field-29, .user-field-30, .user-field-31").hide(); //nack, chest, Shoulders
        $(".user-field-32, .user-field-33, .user-field-34").hide(); //Hip size, Bust Size, Cup Size

        $(".user-field-36, .user-field-37, .user-field-38, .user-field-39").hide(); //Car

        $("#userprofile-gender").trigger('click'); //Gender
        $("input:radio[name='UserFieldValue[33][value]']").trigger('click'); //Vehical

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
            $(".user-field-36, .user-field-37, .user-field-38, .user-field-39").show(); //Car
        }else if( vehicle  == "No")
        {
            $(".user-field-36, .user-field-37, .user-field-38, .user-field-39").hide(); //Car
        }
    });
});
