    <!---Modal/ Pop up-->
    <div class="modal_bg acYR" id="modal_ay_input">
        <div class="modal">
            <div class="title_bar">
                <p>Academic Year Details</p>
                <a href="" class="modal_title_bttn" id="close_modal"><i class="fas fa-times-circle"></i></a>
            </div>
            <!--<form>-->
            <form id="saveAcadYear" action="assets/save_aycode_details.php" method="POST" oninput="res.value=parseYear(yearFrom.value) + '-' +parseYear(yearTo.value);" >
                <div class="modal_content" >
                    <div class="modal_acyr_input_container">
                        
                        <div class="modal_acyr_input">
                            <p class="label">Year From: </p>
                            <input type="year" class="input_field" maxlength="4" required id="yearFrom" name="yearFrom" value="">
                            <i class="fa-solid fa-asterisk"></i>
                            <i id="i_yearFrom" class="fa-solid "></i>
                        </div>
                        <div class="modal_acyr_input">
                            <p class="label">Year To: </p>
                            <input type="year"  class="input_field" maxlength="4" required id="yearTo" name="yearTo" value="">
                            <i class="fa-solid fa-asterisk"></i>
                            <i id="i_yearTo" class="fa-solid "></i>
                        </div>
                        <div class="modal_acyr_input">
                            <p class="label">Semester: </p>
                            <input type="varchar" maxlength="15" required class="input_field" id="semester" name="semester" value="">
                            <i class="fa-solid fa-asterisk"></i>
                            <i id="i_semester" class="fa-solid "></i>
                        </div>
                    </div>
                    
                </div>
                

                <div class="footer_modal_bttn">
                    <a class="modal_foot_bttn1" id="submit" type="submit" onclick="document.getElementById('saveAcadYear').submit()"><i class="fas fa-save"></i> Save</a>
                    <a  id="close_modal2" class="modal_foot_bttn"><i class="fas fa-sign-out-alt"></i> Exit</a>
                </div>
                <!--</form>-->
            </form>
            
        </div>
    </div>

    


    <script src="assets/js/modal_ay_details.js"></script>
    