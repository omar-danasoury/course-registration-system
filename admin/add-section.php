<?php

/**
 * Add Section Page
 * Allows the admin user to 
 * add sections to the system
 * 
 * @author Omar Eldanasoury 
 */
session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

if (isset($_POST["add-section"])) {
    require_once("../functions.php");

    // Finally add the section
    $courseId = $_POST["course-code"];
    $professorId = $_POST["prof-name"];
    $sectionNum = $_POST["section-num"];
    $buildingId = $_POST["bldng"];
    $roomId = $_POST["room"];
    $dateTime = $_POST["datetime"];
    $days = $_POST["days"];
    $semId = getCurrentSemesterId();

    // but before proceesing we validate input
    // check for empty section number, or any empty value
    if (
        empty($courseId)
        or empty($professorId)
        or (empty($sectionNum))
        or empty($buildingId)
        or empty($roomId)
        or empty($dateTime)
        or empty($days)
    ) {
        $feedbackMsg = "<span class='failed-feedback'>Please enter all fields as required!</span>";
    } else if (!preg_match("/\d+/", $sectionNum)) { // if the user entered wrong value for section number\
        $feedbackMsg = "<span class='failed-feedback'>Enter only numbers for section number!</span>";
    } else {
        try {
            if (addSection($semId, $courseId, $sectionNum, $professorId, $roomId, $days, $dateTime)) {
                $feedbackMsg = "<span class='success-feedback'>Section is Added Successfully!</span>";
            } else { // if updateSection() returned false
                $feedbackMsg = "<span class='failed-feedback'>Error Adding Section!</span>";
            }
        } catch (Exception $exception) { // if there is a time conflict, an exception will be thrown by updateSection()
            $feedbackMsg = "<span class='failed-feedback'>Time Conflict Exists, Please Choose Another Time/Days!</span>";
        }
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Section</title>

    <!-- Adding the css files -->
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css" />

    <!-- Adding the Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>

    <!-- Adding FontAwesome Kit -->
    <script src="https://kit.fontawesome.com/163915b421.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php require("../header.php");
    require_once("../functions.php");
    // Required varialbes for adding the section
    $courses = getCourses(); // get the courses list from the database
    $professorNames = getProfessorNames();
    $buildings = getBuildings();
    $rooms = getRooms();

    ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Add Section</h1>

        <!-- 
            Needed Information to add a section:
                - Course Code List (offered by server)
                - Prof Name List(offered by server)
                - room List (offered by server)
                - building List
                - section number (generated by the system; after selecting the course)
                - date and time (validation: no date from the past) :: need time validation

                Pop up message should display the seciton number to user
         -->
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Course Code and Section Number -->
                <div class="attendance-inner-flex">
                    <label for="course-code">Course Code:</label><br><br>
                    <select class="selecter" name="course-code" id="course-code">
                        <?php
                        if ($courses != array())
                            for ($i = 0; $i < count($courses); $i++)
                                foreach ($courses[$i] as $id => $code) {
                                    echo "<option value='" . strval($id) . "'>" . $code . "</option>";
                                }

                        ?>
                    </select>
                    <br><br>
                    <!-- Section Number -->
                    <label for="section-num">Section Number:</label><br><br>
                    <input type="number" min="1" class="selecter" name="section-num" id="section-num">
                </div>

                <!-- Building and Room -->
                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="bldng">Building:</label><br><br>
                    <select onchange="getRooms(this.value)" class="selecter" name="bldng" id="bldng">
                        <option value="">Select a Building</option>
                        <?php
                        if ($buildings != array())
                            for ($i = 0; $i < count($buildings); $i++)
                                foreach ($buildings[$i] as $id => $name) {
                                    echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                }

                        ?>
                    </select>
                    <br><br><br>
                    <label for="room">Room:</label><br><br>
                    <select class="selecter" name="room" id="room">
                        <option value="">Select a Room</option>
                        <!-- The options will be optained from the database using AJAX and PHP -->
                        <!-- Refer to the script at the end of the page, after <body> -->
                    </select>
                </div>

                <!-- Professor and Date+Time -->
                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="prof-name">Professor:</label><br><br>
                    <select class="selecter" name="prof-name" id="prof-name">
                        <?php
                        if ($professorNames != array())
                            for ($i = 0; $i < count($professorNames); $i++)
                                foreach ($professorNames[$i] as $id => $name) {
                                    echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                }

                        ?>
                    </select>
                    <br><br><br>
                    <label for="datetime">Days:</label><br><br>
                    <select class="selecter" name="days" id="days">
                        <option value="UTH">UTH</option>
                        <option value="MW">MW</option>
                    </select>
                </div>

                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="datetime">Time:</label><br><br>
                    <input type="time" name="datetime" id="datetime">
                </div>
            </div>
            <input onclick="return confirm('Are you sure you want to add a section?')" type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="add-section" id="add-section" value="Add a Section!">
            <br><br>
            <?php
            if (isset($feedbackMsg)) {
                echo $feedbackMsg;
                unset($feedbackMsg);
            }
            ?>

        </form>
    </main>

    <?php require("../footer.php") ?>
</body>
<!-- Script for getting the rooms after the user selects the buildings :: Using AJAX
     Author: Omar Eldanasoury
 -->
<script>
    /**@@function getRooms()
     * sends user choice to the script to get
     * rooms of the building
     * 
     * @author Omar Eldanasoury
     */
    function getRooms(buildingId) {
        if (buildingId.length == 0) {
            return;
        }

        const request = new XMLHttpRequest();
        request.onload = showRooms;
        request.open("GET", "getRooms.php?id=" + buildingId);
        request.send();
    }

    /**@function showRooms
     * populated the options inside <select>
     * after getting the rooms
     * 
     * @author Omar Eldanasoury
     */
    function showRooms() {
        clearRooms();
        results = this.responseText.split("#");
        for (let result of results) {
            idAndRoom = result.split("@");
            if (idAndRoom[0] == '')
                continue;
            document.getElementById("room").innerHTML += "\n<option value='" + idAndRoom[0] + "'>" + idAndRoom[1] + "</option>";
        }
    }

    /**@function clearRooms
     * Clears the options to
     * populate new options when
     * user's choice changes.
     * 
     * @author Omar Eldanasoury
     */
    function clearRooms() {
        document.getElementById("room").innerHTML = "<option value=''>Select a Room</option>"
    }
</script>

</html>