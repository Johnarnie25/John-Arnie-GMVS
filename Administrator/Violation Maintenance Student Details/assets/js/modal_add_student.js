$(document).ready(function () {
    $('#vSide').addClass('sideActive');

    let errorfst_name = true;
    let errormid_name = true;
    let errorlast_name = true;
    let errorstud_num = true;
    let aycodeError = true;
    let sectionError = true;
    let erroradd = true;
    let genderError = true;
    let progError = true;

    function checkSubmitButton() {
        if (!errorfst_name && !errormid_name && !errorlast_name && !errorstud_num && !aycodeError && !sectionError && !erroradd && !genderError && !progError) {
            $("#submit").attr("disabled", false);
            $("#submit").removeClass('disable');
            $("#submit").addClass('modal_foot_bttn1');
        } else {
            $("#submit").attr("disabled", true);
            $("#submit").removeClass('modal_foot_bttn1');
            $("#submit").addClass('disable');
        }
    }

    $("#submit").attr("disabled", true);
    $("#submit").removeClass('modal_foot_bttn1');
    $("#submit").addClass('disable');

    $('#openModal_add_student').on('click', function(){
        $('#modal_add_student').css('display', 'flex');
    });

    function resetForm() {
        errorfst_name = true;
        errormid_name = true;
        errorlast_name = true;
        errorstud_num = true;
        aycodeError = true;
        sectionError = true;
        erroradd = true;
        genderError = true;
        progError = true;

        $("#i_firstName").removeClass('fa-circle-exclamation');
        $("#i_middleName").removeClass('fa-circle-exclamation');
        $("#i_lastNamee").removeClass('fa-circle-exclamation');
        $("#i_studNum").removeClass('fa-circle-exclamation');
        $("#i_ayCode").removeClass('fa-circle-exclamation');
        $("#i_Section").removeClass('fa-circle-exclamation');
        $("#i_Addres").removeClass('fa-circle-exclamation');
        $("#i_gender").removeClass('fa-circle-exclamation');
        $("#i_progCode").removeClass('fa-circle-exclamation');

        $("#submit").attr("disabled", true);
        $("#submit").removeClass('modal_foot_bttn1');
        $("#submit").addClass('disable');

        $('#modal_add_student').css('display', 'none');
        $('#studDetails')[0].reset();
    }

    $('#close_modal').on('click', resetForm);
    $('#close_modal2').on('click', resetForm);

    $('#lastName').keyup(function(){
        var regexp = /^[a-zA-Z ]+$/;
        if (regexp.test($('#lastName').val())) {
            errorlast_name = false;
            $('#i_lastNamee').removeClass('fa-circle-exclamation');
        } else {
            errorlast_name = true;
            $('#i_lastNamee').addClass('fa-circle-exclamation');
        }
        checkSubmitButton();
    });

    $('#middleName').keyup(function(){
        var regexp = /^[a-zA-Z ]+$/;
        if (regexp.test($('#middleName').val())) {
            errormid_name = false;
            $('#i_middleName').removeClass('fa-circle-exclamation');
        } else {
            errormid_name = true;
            $('#i_middleName').addClass('fa-circle-exclamation');
        }
        checkSubmitButton();
    });

    $('#firstName').keyup(function(){
        var regexp = /^[a-zA-Z ]+$/;
        if (regexp.test($('#firstName').val())) {
            errorfst_name = false;
            $('#i_firstName').removeClass('fa-circle-exclamation');
        } else {
            errorfst_name = true;
            $('#i_firstName').addClass('fa-circle-exclamation');
        }
        checkSubmitButton();
    });

    $('#studNum').blur(function(){
        var studNumLength = $('#studNum').val().length;
        if (studNumLength >= 13 && studNumLength <= 14) {
            errorstud_num = false;
            $('#i_studNum').removeClass('fa-circle-exclamation');
        } else {
            errorstud_num = true;
            $('#i_studNum').addClass('fa-circle-exclamation');
        }
        checkSubmitButton();
    });

    $("#ayCode").change(function(){ 
        if ($("#ayCode").val() == 0) {
            aycodeError = true;
            $("#i_ayCode").addClass('fa-circle-exclamation');
        } else {
            aycodeError = false;
            $("#i_ayCode").removeClass('fa-circle-exclamation');
        }
        checkSubmitButton();
    });

    $("#Section").keyup(function(){ 
        if ($("#Section").val() == 0) {
            sectionError = true;
            $("#i_Section").addClass('fa-circle-exclamation');
        } else {
            sectionError = false;
            $("#i_Section").removeClass('fa-circle-exclamation');
        }
        checkSubmitButton();
    });

    $('#Addres').keyup(function(){
        if ($('#Addres').val().length > 0) {
            erroradd = false;
            $("#i_Addres").removeClass('fa-circle-exclamation');
        } else {
            erroradd = true;
            $("#i_Addres").addClass('fa-circle-exclamation');
        }
        checkSubmitButton();
    });

    $("#Gender").change(function(){ 
        if ($("#Gender").val().length == 0) {
            genderError = true;
            $("#i_gender").addClass('fa-circle-exclamation');
        } else {
            genderError = false;
            $("#i_gender").removeClass('fa-circle-exclamation');
        }
        checkSubmitButton();
    });

    $("#progCode").change(function(){ 
        if ($("#progCode").val().length == 0) {
            progError = true;
            $("#i_progCode").addClass('fa-circle-exclamation');
        } else {
            progError = false;
            $("#i_progCode").removeClass('fa-circle-exclamation');
        }
        checkSubmitButton();
    });

    $("#studDetails").submit(function(event){
        event.preventDefault();
        if (errorfst_name) {
            $("#i_firstName").addClass('fa-circle-exclamation');
        }

        if (errormid_name) {
            $("#i_middleName").addClass('fa-circle-exclamation');
        }

        if (errorlast_name) {
            $("#i_lastNamee").addClass('fa-circle-exclamation');
        }

        if (errorstud_num) {
            $("#i_studNum").addClass('fa-circle-exclamation');
        }

        if (aycodeError) {
            $("#i_ayCode").addClass('fa-circle-exclamation');
        }

        if (sectionError) {
            $("#i_Section").addClass('fa-circle-exclamation');
        }

        if (erroradd) {
            $("#i_Addres").addClass('fa-circle-exclamation');
        }

        if (genderError) {
            $("#i_gender").addClass('fa-circle-exclamation');
        }

        if (progError) {
            $("#i_progCode").addClass('fa-circle-exclamation');
        }

        if (!errorfst_name && !errormid_name && !errorlast_name && !errorstud_num && !aycodeError && !sectionError && !erroradd && !genderError && !progError) {
            $.ajax({
                url: "assets/save_add_student.php",
                type: 'POST',
                data: $('#studDetails').serialize(),
                datatype: "text",
                cache: false,
                success: function(result){
                    if ($.trim(result) == 'msg003'){
                        var msg = "<span class='alert_icon orange'><i class='fa-solid fa-exclamation'></i></span><span class='alert_text'>Something Wrong, Please Try again</span>";
                        $("#alert_bottom").addClass('alertOpen');
                        $("#alert_content").html(msg);
                        setTimeout(function(){
                            $("#alert_bottom").removeClass('alertOpen')
                        }, 5000);
                    }
                    else if ($.trim(result) == 'StudentNumExists'){
                        errorstud_num = true;
                        $("#i_studNum").addClass('fa-circle-exclamation');
                    }
                    else if ($.trim(result) == 'StudentExists'){
                        errorfst_name = true;
                        errormid_name = true;
                        errorlast_name = true;
                        $("#i_firstName").addClass('fa-circle-exclamation');
                        $("#i_middleName").addClass('fa-circle-exclamation');
                        $("#i_lastNamee").addClass('fa-circle-exclamation');  
                    }
                    else {
                        $("#studDetails")[0].reset();
                        errorfst_name = true;
                        errormid_name = true;
                        errorlast_name = true;
                        errorstud_num = true;
                        aycodeError = true;
                        sectionError = true;
                        erroradd = true;
                        genderError = true;
                        progError = true;

                        $("#i_firstName").removeClass('fa-circle-exclamation');
                        $("#i_middleName").removeClass('fa-circle-exclamation');
                        $("#i_lastNamee").removeClass('fa-circle-exclamation');
                        $("#i_studNum").removeClass('fa-circle-exclamation');
                        $("#i_ayCode").removeClass('fa-circle-exclamation');
                        $("#i_Section").removeClass('fa-circle-exclamation');
                        $("#i_Addres").removeClass('fa-circle-exclamation');
                        $("#i_gender").removeClass('fa-circle-exclamation');
                        $("#i_progCode").removeClass('fa-circle-exclamation');

                        $("#table").load("assets/updatedDisplay_student_details.php");

                        $("#submit").attr("disabled", true);
                        $("#submit").removeClass('modal_foot_bttn1');
                        $("#submit").addClass('disable');

                        $('#modal_add_student').css('display', 'none');

                        $("#alert_bottom").addClass('alertOpen');
                        $("#alert_content").html(result);
                        setTimeout(function(){
                            $("#alert_bottom").removeClass('alertOpen')
                        }, 5000);
                    }
                }
            });
        }
    });
});
