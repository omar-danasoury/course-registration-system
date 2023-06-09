<?php

/**
 * Add Room Page
 * Allows the admin user to 
 * add rooms to the system
 * 
 * @author Elyas Raed
 * @author Omar Eldanasoury
 */
session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

// only admin should access the page
if (!str_contains($_SESSION["userType"], "admin"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");

if (isset($_POST["add-room"])) {
    require_once("../functions2.php");

    // Adding the room
    $roomnum = $_POST["room-number"];
    $buildingId = $_POST["bldng"];
    $capacity = $_POST["capacity"];

    // Validate/ check for empty values
    if (
        empty($roomnum)
        or empty($buildingId)
        or empty($capacity)
    ) {
        $feedbackMsg = "<span class='failed-feedback'>Please enter all fields as required!</span>";
    } else {
        try {
            if (addRoom($buildingId, $roomnum, $capacity)) {
                $feedbackMsg = "<span class='success-feedback'>Room is Added Successfully!</span>";
            } else {
                $feedbackMsg = "<span class='failed-feedback'>Error Adding Room, Please Try Again Later!</span>";
            }
        } catch (Exception $exception) { // send error if room already exists
            $feedbackMsg = "<span class='failed-feedback'>Room Already Exists, Please Choose a New Room Number!</span>";
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
    <title>Add Room</title>

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
    // Required varialbes for adding the room
    $buildings = getBuildings(); //get the buildings list from the database
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Add Room</h1>

        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Adding Room Number -->
                <div class="attendance-inner-flex">
                    <label for="room-number">Room Number:</label><br><br>
                    <input type="number" min="1001" class="selecter" name="room-number" id="room-number">
                    </select>
                    <br><br>

                </div>

                <!-- Adding Building and Capacity -->
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
                </div>

            </div>
            <div class="attendance-inner-flex">
                <label for="capacity">Capacity:</label><br><br>
                <input type="number" min="15" max="9999" class="selecter" name="capacity" id="capacity">
            </div>

            <input onclick="return confirm('Are you sure you want to add a room?')" type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="add-room" id="add-room" value="Add a Room">
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