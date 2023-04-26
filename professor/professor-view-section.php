<?php

// session_start(); // for the header
// if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
//     header("location: signin.php");

// if (isset($_POST["view-section"])) {
//     try {
//         require("connection.php");
//         $sql = "INSERT INTO RESERVATIONS VALUES (null, ?, ?, ?, ?, NOW())";
//         $db->beginTransaction();
//         $statement = $db->prepare($sql);
//         $statement->execute(array($tripId, $_SESSION["activeUser"][0], 0, null));

//         if ($statement->rowCount() != 1) {
//             header("location: home.php?reserved=false");
//         } else {
//             header("location: home.php?reserved=true");
//         }
//     } catch (PDOException $e) {
//         $db->rollBack();
//         // header("location: home.php?reserved=notfalse");
//         echo "Error: " . $e->getMessage();
//     }

//     $db = null;

//     echo $statement->rowCount();
// }



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Section</title>

    <!-- Adding the css files -->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css" />

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

    <?php require("header.php") ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">View Section</h1>

        <form <?php // echo "action='process-payment.php?tid=$id'" 
                ?> method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex">
                <div class="attendance-inner-flex">
                    <label for="course-code">Course Code:</label><br><br>
                    <select class="selecter" name="course-code" id="course-code">
                        <option value="ITCS489">ITCS489</option>
                        <option value="ITCS389">ITCS389</option>

                    </select>
                </div>

                <div class="attendance-inner-flex" style="margin-left: 2em;">
                    <label for="section-number">Section Number:</label><br><br>
                    <select class="selecter" name="section-number" id="section-number">
                        <option value="01">01</option>
                        <option value="02">02</option>

                    </select>
                </div>
            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="view-secton" id="view-section" value="Get Students List!">
            <?php
            // if (isset($_GET["err"])) {
            //     $err = $_GET["err"];
            //     echo "<p style='color: white; font-weight: 600;'>$err</p>";
            // }
            ?>

        </form>


        <div class="catalogue-main">

            <form action="">
                <table>
                    <thead>
                        <tr>
                            <th class="th-color">Student ID</th>
                            <th class="th-color">Student Name</th>
                            <th class="th-color">Absense Rate</th>
                            <th class="th-color">Grade</th>
                            <th class="th-color">Appeal Request?</th>



                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>20200000</td>
                            <td>Name</td>
                            <td>1.4%</td>
                            <td>A-</td>
                            <td>No</td>
                        </tr>
                        <tr>
                            <td>20200000</td>
                            <td>Name</td>
                            <td>1.4%</td>
                            <td>A-</td>
                            <td>No</td>
                        </tr>

                        <!--  Here we add the dynamic content from the database -->
                    </tbody>
                </table>
            </form>

            <?php
            // try {
            //     $tid = $_GET["tid"];
            //     require("connection.php");
            //     $rows = $db->query("SELECT * FROM TRIPS WHERE TRIPID = $tid");
            //     $db = null;
            // } catch (PDOException $ex) {
            //     echo "Error: " . $ex->getMessage();
            // }
            ?>

            <div class="trip-container payment-trip">
                <?php
                // if ($row = $rows->fetch()) {
                //     $id = $row[0];
                //     $title = $row[1];
                //     $from = $row[2];
                //     $to = $row[3];
                //     $price = $row[4];
                //     $imagePath = $row[6];
                //     $location = $row[5]
                // }
                ?>
            </div>
        </div>

    </main>

    <?php require("footer.php") ?>
</body>

</html>