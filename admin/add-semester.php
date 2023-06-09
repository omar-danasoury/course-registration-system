<?php

/**
 * Add Semester Page
 * Allows the admin user to 
 * add semesters to the system
 * 
 * @author Omar Eldanasoury
 * @author Elyas Raed
 */
session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

// only admin should access the page
if (!str_contains($_SESSION["userType"], "admin"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");

if (isset($_POST["add-semester"])) {
    require_once("../functions2.php");

    // Getting input
    $semName = $_POST["sem-name"];
    $appealStartDate = $_POST["start-date"];
    $appealEndDate = $_POST["end-date"];
    $registrationStartDate = $_POST["start-reg"];
    $registrationEndDate = $_POST["end-reg"];

    /**
     * Here we convert the users input dates
     * to a specific format, and then compare
     * it to the current date which we generated
     * using the same format. The format is unified
     * to make it easy to compare them in the input 
     * validation process.
     * 
     * @author Omar Eldanasoury
     */
    date_default_timezone_set(@date_default_timezone_get() ?: 'AST'); // setiting the timezone to be as the user's timezone
    $currentDate = date("Y-m-d"); // get current date in specified format

    // convert user's input dates to time stamps
    $startDateTimeStamp = strtotime($appealStartDate);
    $endDateTimeStamp = strtotime($appealEndDate);

    // finally, converting the dates the the specified format;
    // this makes it easier to compare the dates in the follwing
    // input validation for input validaiton purposes
    $formattedStartDate = date("Y-m-d", $startDateTimeStamp);
    $formattedEndDate = date("Y-m-d", $endDateTimeStamp);


    // now perforing the same but for registration dates
    $registrationStartDateTimeStamp = strtotime($registrationStartDate);
    $registrationEndDateTimeStamp = strtotime($registrationEndDate);

    $formattedRegistrationStartDate = date("Y-m-d", $registrationStartDateTimeStamp);
    $formattedRegistrationEndDate = date("Y-m-d", $registrationEndDateTimeStamp);

    // Validate/ check for empty values
    if (
        empty($semName)
        or empty($appealStartDate)
        or empty($appealEndDate)
        or empty($registrationStartDate)
        or empty($registrationEndDate)

    ) {
        $feedbackMsg = "<span class='failed-feedback'>Please enter all fields as required!</span>";
    } else if (!preg_match("/^20[2-9][0-9]\/20[2-9][0-9]\-[1|2|S]$/", $semName)) { // validating the semester name
        $feedbackMsg = "<span class='failed-feedback'>Enter a valid semester name!</span>";
    } else if ($formattedStartDate < $currentDate or $formattedEndDate < $currentDate or $formattedRegistrationStartDate < $currentDate or $formattedRegistrationEndDate < $currentDate) { // if start-date or end-date are less than today
        $feedbackMsg = "<span class='failed-feedback'>Dates should not be less than today!</span>";
    } else if ($appealStartDate > $appealEndDate) { // if start-date is less than or equal to end-date
        $feedbackMsg = "<span class='failed-feedback'>Appeal Period's Start date should not be less than end-date!</span>";
    } else if ($registrationStartDate > $registrationEndDate) { // if start-date is less than or equal to end-date of regirstration period
        $feedbackMsg = "<span class='failed-feedback'>Registration's Start date should not be less than end-date!</span>";
    } else if (!($registrationStartDate < $appealStartDate and $registrationEndDate < $appealEndDate)) { // appeal period should be after the registration period
        $feedbackMsg = "<span class='failed-feedback'>Appeal period shall not be before the registration period!</span>";
    } else {
        try {
            if (addSemester($semName, $appealStartDate, $appealEndDate, $registrationStartDate, $registrationEndDate)) {
                $feedbackMsg = "<span class='success-feedback'>Semester is Added Successfully!</span>";
            } else {
                $feedbackMsg = "<span class='failed-feedback'>Error Adding Semester!</span>";
            }
        } catch (Exception $exception) { // if there is a semester conflict
            $feedbackMsg = "<span class='failed-feedback'>Semester Already Exists, Please Choose a New Semester!</span>";
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
    <title>Add Semester</title>

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
    require_once("../functions2.php");
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Add Semester</h1>

        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Adding Semester Name -->
                <div class="attendance-inner-flex">
                    <label for="sem-name">Semester Name:</label><br><br>
                    <input type="text" class="selecter" name="sem-name" id="sem-name">
                    </select>
                    <br><br>

                </div>

                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="start-reg">Start of Registration Date:</label><br><br>
                    <input type="date" name="start-reg" id="start-reg">
                    <br><br><br>
                    <label for="end-reg">End of Registration Date:</label><br><br>
                    <input type="date" class="selecter" name="end-reg" id="end-reg">
                </div>

                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="start-date">Start of Appeal Requests Date:</label><br><br>
                    <input type="date" name="start-date" id="start-date">
                    <br><br><br>
                    <label for="end-date">End of Appeal Requests Date:</label><br><br>
                    <input type="date" class="selecter" name="end-date" id="end-date">
                </div>
            </div>

            <input onclick="return confirm('Are you sure you want to add a semester?')" type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="add-semester" id="add-semester" value="Add a Semester">
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

</html>