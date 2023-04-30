<?php

/**
 * Functions that retrieve data from
 * the database about the user, and
 * does input sanitization on user 
 * input.
 * 
 * @author Omar Eldanasoury
 */


/**
 * @name checkInput
 * Performs input sanitization on user input
 * to prevent injection attacks. It encodes
 * special characters, removes slaches,
 * and removes extra spaces. 
 * 
 * @author Omar Eldanasoury
 * @param $input user Input as text
 * @return string sanitized secure text to process.
 */
function checkInput($input)
{
    return htmlspecialchars(stripslashes(trim($input)));
}

/**
 * Retrieves the user name from
 * the database.
 * 
 * @author Omar Eldanasoury
 * @param int $userId
 * @return string the actual user name from the system database.
 */
function getUserName($userId)
{
    $username = null;
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT USERNAME FROM USERS WHERE USER_ID = $userId");
        if ($query->rowCount() != 0 and $name = $query->fetch(PDO::FETCH_NUM)) {
            $username = $name[0]; // getting the name if the query was successful
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $username;
}

/**
 * Retrieves the major name from
 * the database. if the user is not admin.
 * 
 * @author Omar Eldanasoury
 * @param int $userId
 * @param string $userType
 * @return string the actual user name from the system database, otherwise null if the use is admin.
 */
function getMajorName($userId, $userType)
{
    $major = null;
    $query = "";
    if ($userType == "student") { // only student users has major, other users do not
        try {
            // establishing connection
            require("connection.php");
            // setting and running the query
            $query = $db->query("SELECT PC.PROGRAM_NAME FROM STUDENT_INFO AS SI, PROGRAM_COLLEGE AS PC WHERE SI.STUDENT_ID = $userId AND SI.PROG_ID = PC.PROGRAM_ID");
            if ($program = $query->fetch(PDO::FETCH_NUM)) {
                $major = "hey";
                $major = $program[0]; // getting the major if the query was successful
            }
        } catch (PDOException $ex) {
            // printing the error message if error happens
            echo $ex->getMessage();
        }
        // closing connection with the database
        $db = null;
    }
    return $major;
}

/**
 * Retrieves the semester name from
 * the database.  
 * 
 * @author Omar Eldanasoury
 * @param $semId semester id in the database (from the session).
 * @return string the actual semester name from the system database.
 */

function getSemesterName($semId)
{
    $semName = "";
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = "SELECT SEM_NAME FROM SEMESTER WHERE SEM_STATUS = 'IN_PROGRESS'";
        $rows = $db->prepare($query);
        $rows->execute();
        $semName = "testoo";
        if ($sem = $rows->fetch(PDO::FETCH_NUM)) {
            $semName = $sem[0]; // getting the name if the query was successful
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
        $semName = "TestTest";
    }
    // closing connection with the database
    $db = null;
    return $semName;
}

/**
 * Retrieves the type of the user
 * as a text string.  
 * 
 * @author Omar Eldanasoury
 * @param int $userTypeId the id that represents the type of the user inside the database.
 * @return string the actual desctribtion of the user type and title inside the system.
 */
function getUserTypeAsText($userTypeId)
{
    $type = null;
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT USER_TYPE FROM USER_TYPE WHERE TYPE_ID = $userTypeId");
        if ($result = $query->fetch(PDO::FETCH_NUM)) {
            $type = $result[0]; // getting the name if the query was successful
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
        echo $result[0];
    }
    // closing connection with the database
    $db = null;
    return $type;
}

/**
 * Retrieves the college name from
 * the database.
 * 
 * @author Omar Eldanasoury
 * @param int $userId
 * @param string $userType
 * @return string the actual user name from the system database, otherwise null if the use is admin.
 */
function getCollegeName($userId, $userType)
{
    $collegeName = null;
    if ($userType != 'admin') {
        try {
            // establishing connection
            require("connection.php");
            // setting and running the query
            $query = $db->query("SELECT COLLEGE_NAME FROM COLLEGE AS C, USERS AS U WHERE C.COLLEGE_ID = U.COLLEGE_ID AND USER_ID = $userId");
            if ($result = $query->fetch(PDO::FETCH_NUM)) {
                $collegeName = $result[0]; // getting the name if the query was successful
            }
        } catch (PDOException $ex) {
            // printing the error message if error happens
            echo $ex->getMessage();
        }
        // closing connection with the database
        $db = null;
    }
    return $collegeName;
}

/**
 * Retrieves the department name
 * of the user from the database.
 * 
 * @author Omar Eldanasoury
 * @param int $userId
 * @param string $userType
 * @return string the actual user name from the system database, otherwise null if the use is admin.
 */
function getDepartmentName($userId, $userType)
{
    $depName = null;
    if ($userType != 'admin') {
        try {
            // establishing connection
            require("connection.php");
            // setting and running the query
            $query = $db->query("SELECT DEP_NAME FROM DEPARTMENT AS D, USERS AS U WHERE D.DEP_ID = U.DEP_ID AND USER_ID = $userId");
            if ($result = $query->fetch(PDO::FETCH_NUM)) {
                $depName = $result[0]; // getting the name if the query was successful
            }
        } catch (PDOException $ex) {
            // printing the error message if error happens
            echo $ex->getMessage();
        }
        // closing connection with the database
        $db = null;
    }
    return $depName;
}

/**
 * Returns a list of all the courses
 * available in the database
 * 
 * @author Omar Eldanasoury
 * @return array course id, and course code = as an associative array
 */
function getCourses()
{
    $courses = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT COURSE_CODE FROM COURSE");
        if ($allCourses = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $courses = $allCourses;
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;

    return $courses;
}

/**
 * Retrieves all the names
 * of professors from the system
 * 
 * @author Omar Eldanasoury
 * @return array of names
 */
function getProfessorNames()
{
    $names = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT USERNAME FROM USERS WHERE USERS.TYPE_ID = 1");
        if ($allNames = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $names = $allNames;
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;

    return $names;
}

/**
 * Retrieves all the buildings
 * from the system
 * 
 * @author Omar Eldanasoury
 * @return array of names
 */
function getBuildings()
{
    $buildings = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT BUILDING_NAME FROM BUILDING");
        if ($allBldngs = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $buildings = $allBldngs;
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;

    return $buildings;
}

// /**
//  * Returns a list of all the courses
//  * available in the database
//  * 
//  * @author Omar Eldanasoury
//  * @return array course id, and course code = as an associative array
//  */
// function getCourseCodes()
// {
//     $codes = array(null => null);
//     try {
//         // establishing connection
//         require("connection.php");
//         // setting and running the query
//         $query = $db->query("SELECT COURSE_CODE FROM COURSE");
//         if ($allCodes = $query->fetch(PDO::FETCH_ASSOC)) {
//             // getting the list of courses if the query was successful
//             $codes = $allCodes;
//         }
//     } catch (PDOException $ex) {
//         // printing the error message if error happens
//         echo $ex->getMessage();
//     }
//     // closing connection with the database
//     $db = null;

//     return $codes;
// }

// /**
//  * Returns a list of all the courses
//  * available in the database
//  * 
//  * @author Omar Eldanasoury
//  * @return array course id, and course code = as an associative array
//  */
// function getCourseIds()
// {
//     $ids = array();
//     try {
//         // establishing connection
//         require("connection.php");
//         // setting and running the query
//         $query = $db->query("SELECT COURSE_ID FROM COURSE");
//         if ($allIds = $query->fetch(PDO::FETCH_ASSOC)) {
//             // getting the list of courses if the query was successful
//             $ids = $allIds;
//         }
//     } catch (PDOException $ex) {
//         // printing the error message if error happens
//         echo $ex->getMessage();
//     }
//     // closing connection with the database
//     $db = null;

//     return $ids;
// }
