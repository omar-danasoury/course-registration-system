<?php

//  Admin functions (Elyas)

function getnameData($utp)
{
    try {
        require("connection.php");
        $sql = "SELECT * FROM USERS WHERE USER_ID = $utp";
        $statement = $db->prepare($sql);
        $statement->execute();

        if ($section = $statement->fetch(PDO::FETCH_ASSOC)) {
            return $section;
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";

        $db = null;
    }
    return null;
}

function updateStatus($semName, $semStatus)
{
    try {
        require("connection.php");
        $sql = "UPDATE SEMESTER SET SEM_STATUS = ? WHERE SEM_ID = ?";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($semName, $semStatus));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";

        $db = null;
        return false;
    }

    return ($statement->rowCount() == 1);
}
function updateUser($uid, $utp, $un, $em, $pas, $coll, $maj, $gen)
{
    try {
        $college = $coll;
        $department = $maj;

        if (intval($utp) == 0) // if the user is admin
            $college = $department = null;
        else if (intval($utp) == 4)  // if the user is dean
            $department = null;

        require("connection.php");
        $sql = "UPDATE USERS SET TYPE_ID = ?, USERNAME = ?, EMAIL = ?, PASSWORD = ?, COLLEGE_ID = ?, DEP_ID = ? , GENDER = ? WHERE USER_ID = ?";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($utp, $un, $em, $pas, $college, $department, $gen, $uid));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";

        $db = null;
        return false;
    }

    return ($statement->rowCount() == 1);
}
function checkInput($input)
{
    return htmlspecialchars(stripslashes(trim($input)));
}

function getDepartmentsName($deptIds)
{
    $names = "";
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT DEP_ID, DEP_NAME FROM DEPARTMENT WHERE COLLEGE_ID = $deptIds");
        while ($allNames = $query->fetch(PDO::FETCH_NUM)) {
            $names .=  $allNames[0] . "@" . $allNames[1] . "#";
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $names;
}

function getUserNames($userIds)
{
    $names = "";
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT USER_ID, USERNAME FROM USERS WHERE TYPE_ID = $userIds");
        while ($allNames = $query->fetch(PDO::FETCH_NUM)) {
            $names .=  $allNames[0] . "@" . $allNames[1] . "#";
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $names;
}
function getTypeUsers($utp)
{
    $users = "";
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT u.USER_ID, u.USERNAME, u.EMAIL, u.COLLEGE_ID, u.DEP_ID, u.GENDER, c.COLLEGE_NAME, d.DEP_NAME 
        FROM USERS u 
        INNER JOIN COLLEGE AS c ON u.COLLEGE_ID = c.COLLEGE_ID 
        INNER JOIN DEPARTMENT AS d ON u.DEP_ID = d.DEP_ID 
        WHERE u.TYPE_ID = $utp");
        while ($userData = $query->fetch(PDO::FETCH_NUM)) {
            $users .= $userData[0] . "!" . $userData[1] . "!" . $userData[2] . "!" . $userData[7] . "!" . $userData[5] . "!" . $userData[6] .  "#";
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $users;
}

function deleteDepartment($departmentName)
{
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $db->beginTransaction();
        $sql = "DELETE FROM DEPARTMENT WHERE DEP_ID = ?";
        $statement = $db->prepare($sql);
        $statement->execute(array($departmentName));
        $db->commit();
    } catch (PDOException $ex) {
        $db->rollBack();
        // printing the error message if error happens
        echo $ex->getMessage();
        return false;
    }
    // closing connection with the database
    $db = null;
    return true;
}
function deleteProgram($programName)
{
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $db->beginTransaction();
        $sql = "DELETE FROM PROGRAM_COLLEGE WHERE PROGRAM_ID = ?";
        $statement = $db->prepare($sql);
        $statement->execute(array($programName));
        $db->commit();
    } catch (PDOException $ex) {
        $db->rollBack();
        // printing the error message if error happens
        echo $ex->getMessage();
        return false;
    }
    // closing connection with the database
    $db = null;
    return true;
}
function deleteCollege($collegeName)
{
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $db->beginTransaction();
        $sql = "DELETE FROM COLLEGE WHERE COLLEGE_ID = ?";
        $statement = $db->prepare($sql);
        $statement->execute(array($collegeName));
        $db->commit();
    } catch (PDOException $ex) {
        $db->rollBack();
        // printing the error message if error happens
        echo $ex->getMessage();
        return false;
    }
    // closing connection with the database
    $db = null;
    return true;
}
function deleteBuilding($buildings)
{
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $db->beginTransaction();
        $sql = "DELETE FROM BUILDING WHERE BUILDING_ID = ?";
        $statement = $db->prepare($sql);
        $statement->execute(array($buildings));
        $db->commit();
    } catch (PDOException $ex) {
        $db->rollBack();
        // printing the error message if error happens
        echo $ex->getMessage();
        return false;
    }
    // closing connection with the database
    $db = null;
    return true;
}

function deleteSemester($semesters)
{
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $db->beginTransaction();
        $sql = "DELETE FROM SEMESTER WHERE SEM_ID = ?";
        $statement = $db->prepare($sql);
        $statement->execute(array($semesters));
        $db->commit();
    } catch (PDOException $ex) {
        $db->rollBack();
        // printing the error message if error happens
        echo $ex->getMessage();
        return false;
    }
    // closing connection with the database
    $db = null;
    return true;
}
function deleteRoom($rooms)
{
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $db->beginTransaction();
        $sql = "DELETE FROM ROOM WHERE ROOM_ID = ?";
        $statement = $db->prepare($sql);
        $statement->execute(array($rooms));
        $db->commit();
    } catch (PDOException $ex) {
        $db->rollBack();
        // printing the error message if error happens
        echo $ex->getMessage();
        return false;
    }
    // closing connection with the database
    $db = null;
    return true;
}

function hasSemesterConflict($semN)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT * FROM SEMESTER WHERE SEM_NAME LIKE?");
        $query->execute(array($semN));
        if ($result = $query->fetch(PDO::FETCH_NUM)) { // if there is a time conflict
            $db = null; // closing the connection
            return "conflict";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return "none"; // otherwise, there is no conflict
}

/**
 * Adds a semester to the system
 * 
 * @author Omar Eldanasoury
 * @author Elyas Raed
 * @param mixed $semName Semester Name
 * @param mixed $appealStartDate start date of appeal period
 * @param mixed $appealEndDate end date of appeal period
 * @param mixed $regStartDate start date of registration period
 * @param mixed $regEndDate end date of registration period
 */
function addSemester($semName, $appealStartDate, $appealEndDate, $regStartDate, $regEndDate)
{
    // checking for semester conflict
    $semesterConflict = hasSemesterConflict($semName);
    if ($semesterConflict == 'conflict')
        throw new Exception();;

    require("connection.php");
    try {
        $sql = "INSERT INTO SEMESTER VALUES(null, ?, 0, 0, ?, ?, ?, ?);";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($semName, $appealStartDate, $appealEndDate, $regStartDate, $regEndDate));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";
        $db = null;
        return false;
    }

    return $statement->rowCount() == 1;
}

function hasProgramConflict($programN)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT * FROM PROGRAM_COLLEGE WHERE PROGRAM_NAME LIKE?");
        $query->execute(array($programN));
        if ($result = $query->fetch(PDO::FETCH_NUM)) {
            $db = null; // closing the connection
            return "conflict";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return "none"; // otherwise, there is no conflict
}

function addProgram($collegeId, $pname)
{
    // checking for program conflict
    $programConflict = hasProgramConflict($pname);
    if ($programConflict == 'conflict')
        throw new Exception();;

    require("connection.php");
    try {
        $sql = "INSERT INTO PROGRAM_COLLEGE VALUES(null, ?, ?);";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($collegeId, $pname));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";

        $db = null;
        return false;
    }

    if ($statement->rowCount() != 1)
        return false;
    // echo "row count: " . $statement->rowCount();
    return true;
}

function hasDepartmentConflict($departmentN)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT * FROM DEPARTMENT WHERE DEP_NAME LIKE?");
        $query->execute(array($departmentN));
        if ($result = $query->fetch(PDO::FETCH_NUM)) {
            $db = null; // closing the connection
            return "conflict";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return "none"; // otherwise, there is no conflict
}

function addDepartment($dname, $collegeId)
{
    // checking for time conflict
    $departmentConflict = hasDepartmentConflict($dname);
    if ($departmentConflict == 'conflict')
        throw new Exception();;

    require("connection.php");
    try {
        $sql = "INSERT INTO DEPARTMENT VALUES(null, ?, ?, null);";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($dname, $collegeId));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";

        $db = null;
        return false;
    }

    if ($statement->rowCount() != 1)
        return false;
    // echo "row count: " . $statement->rowCount();
    return true;
}
function hasCollegeConflict($collegeN)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT * FROM COLLEGE WHERE COLLEGE_NAME LIKE?");
        $query->execute(array($collegeN));
        if ($result = $query->fetch(PDO::FETCH_NUM)) {
            $db = null; // closing the connection
            return "conflict";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return "none"; // otherwise, there is no conflict
}
function addCollege($collegeName)
{
    // checking for college conflict
    $roomConflict = hasCollegeConflict($collegeName);
    if ($roomConflict == 'conflict')
        throw new Exception();;

    require("connection.php");
    try {
        $sql = "INSERT INTO COLLEGE VALUES(null, ?);";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($collegeName));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";
        $db = null;
        return false;
    }

    if ($statement->rowCount() != 1)
        return false;
    // echo "row count: " . $statement->rowCount();
    return true;
}

function hasBuildingConflict($buildingN)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT * FROM BUILDING WHERE BUILDING_NAME LIKE?");
        $query->execute(array($buildingN));
        if ($result = $query->fetch(PDO::FETCH_NUM)) {
            $db = null; // closing the connection
            return "conflict";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return "none"; // otherwise, there is no conflict
}

function addBuilding($buildingName)
{
    // checking for building conflict
    $buildingConflict = hasBuildingConflict($buildingName);
    if ($buildingConflict == 'conflict')
        throw new Exception();;

    require("connection.php");
    try {
        $sql = "INSERT INTO BUILDING VALUES(null, ?);";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($buildingName));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";

        $db = null;
        return false;
    }

    return $statement->rowCount() == 1;
}

function hasRoomConflict($buildingD, $roomName)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT * FROM ROOM WHERE BUILDING_ID LIKE ? AND ROOM_NAME = ?;");
        $query->execute(array($buildingD, $roomName));
        if ($result = $query->fetch(PDO::FETCH_NUM)) {
            $db = null; // closing the connection
            return "conflict";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return "none"; // otherwise, there is no conflict
}
function addRoom($buildingId, $roomnum, $capacity)
{
    // checking for room conflict
    $roomConflict = hasRoomConflict($buildingId, $roomnum);
    if ($roomConflict == 'conflict')
        throw new Exception();;

    require("connection.php");
    try {
        $sql = "INSERT INTO ROOM VALUES(null, ?, ?, ?);";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($buildingId, $roomnum, $capacity));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";

        $db = null;
        return false;
    }

    if ($statement->rowCount() != 1)
        return false;
    // echo "row count: " . $statement->rowCount();
    return true;
}

function hasNameConflict($namelist)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT USER_ID, USERNAME FROM USERS WHERE USERNAME LIKE ?");
        $query->execute(array($namelist));
        if ($result = $query->fetch(PDO::FETCH_NUM)) {
            $db = null; // closing the connection
            return "conflict";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return "none"; // otherwise, there is no conflict
}

function hasEmailConflict($emaillist)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT USER_ID, EMAIL FROM USERS WHERE EMAIL LIKE ?");
        $query->execute(array($emaillist));
        if ($result = $query->fetch(PDO::FETCH_NUM)) { // if there is a time conflict
            $db = null; // closing the connection
            return "conflict";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return "none"; // otherwise, there is no conflict
}
function addUser($utp, $un, $em, $pas, $coll, $maj, $gen, $programId = null)
{
    // checking for name conflict
    $nameConflict = hasNameConflict($un);
    if ($nameConflict == 'conflict')
        throw new Exception();

    // checking for email conflict
    $emailConflict = hasEmailConflict($em);
    if ($emailConflict == 'conflict')
        throw new Exception();;

    $college = $coll;
    $department = $maj;

    if (intval($utp) == 0) // if the user is admin
        $college = $department = null;
    else if (intval($utp) == 4)  // if the user is dean
        $department = null;

    require("connection.php");
    try {

        $sql = "INSERT INTO USERS VALUES(null, ?, ?, ?, ?, ?, ?, ?);";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($utp, $un, $em, password_hash($pas, PASSWORD_DEFAULT), $college, $department, $gen));
        $db->commit();


        if (intval($utp) == 5) { // if the user is a head of department
            $hodId = getUserIdByEmail($em);
            $sql = "UPDATE DEPARTMENT SET HOD_ID = ? WHERE DEP_ID = ?;";
            $db->beginTransaction();
            $statement = $db->prepare($sql);
            $statement->execute(array($hodId, $department));
            $db->commit();
        }

        if (intval($utp) == 3) { // if the user is a student
            $studentId = getUserIdByEmail($em);
            $currentYear = date("Y");
            $sql = "INSERT INTO STUDENT_INFO VALUES(?,0,?,0,?);";
            $db->beginTransaction();
            $statement = $db->prepare($sql);
            $statement->execute(array($studentId, $programId, $currentYear));
            $db->commit();
        }
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";

        $db = null;
        return false;
    }


    return $statement->rowCount() == 1;
}

/**
 * Returns all programs inside the system
 * 
 * @author Omar Eldanaosury 
 */
function getPrograms()
{
    $programs = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT PROGRAM_ID, PROGRAM_NAME FROM PROGRAM_COLLEGE ORDER BY PROGRAM_ID");
        while ($allPrograms = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $program = array($allPrograms[0] => $allPrograms[1]);
            array_push($programs, $program);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $programs;
}
/**
 * Deletes a user from the database
 * 
 * @author Omar Eldanasoury
 * @author Elyas Raed
 * @param mixed $userEmail
 * @return bool true if deletion was successful, otherwise false
 */
function deleteUser($userEmail)
{
    if (!doesEmailExists($userEmail))
        throw new Exception();
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $db->beginTransaction();
        $sql = "DELETE FROM USERS WHERE EMAIL = ?";
        $statement = $db->prepare($sql);
        $statement->execute(array($userEmail));
        $db->commit();
    } catch (PDOException $ex) {
        $db->rollBack();
        // printing the error message if error happens
        echo $ex->getMessage();
        return false;
    }
    // closing connection with the database
    $db = null;
    return true;
}
function getUserEmail()
{
    $useremail = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT USER_ID, EMAIL FROM USERS ORDER BY TYPE_ID");
        while ($allUserEmails = $query->fetch(PDO::FETCH_NUM)) {
            $useremails = array($allUserEmails[0] => $allUserEmails[1]);
            array_push($useremail, $useremails);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $useremail;
}

function getHod()
{
    $hod = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT USER_ID, USERNAME FROM USERS WHERE TYPE_ID = 5");
        while ($allHods = $query->fetch(PDO::FETCH_NUM)) {
            $hods = array($allHods[0] => $allHods[1]);
            array_push($hod, $hods);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $hod;
}
function getUserName()
{
    $username = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT USER_ID, USERNAME FROM USERS ORDER BY TYPE_ID");
        while ($allUserNames = $query->fetch(PDO::FETCH_NUM)) {
            $usernames = array($allUserNames[0] => $allUserNames[1]);
            array_push($username, $usernames);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $username;
}
function getDepartmentName()
{
    $depName = array();
    // if ($userType != 'admin') {
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT DEP_ID, DEP_NAME FROM DEPARTMENT ORDER BY DEP_ID");
        while ($allDepartments = $query->fetch(PDO::FETCH_NUM)) {
            $depNames = array($allDepartments[0] => $allDepartments[1]);
            array_push($depName, $depNames);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    // }
    return $depName;
}

function getProgramName()
{
    $programName = array();
    // if ($userType != 'admin') {
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT PROGRAM_ID, PROGRAM_NAME FROM PROGRAM_COLLEGE ORDER BY PROGRAM_ID");
        while ($allPrograms = $query->fetch(PDO::FETCH_NUM)) {
            $programs = array($allPrograms[0] => $allPrograms[1]);
            array_push($programName, $programs);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    // }
    return $programName;
}
function getCollegeName()
{
    $collegeName = array();
    // if ($userType != 'admin') {
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT COLLEGE_ID, COLLEGE_NAME FROM COLLEGE ORDER BY COLLEGE_ID");
        while ($allColleges = $query->fetch(PDO::FETCH_NUM)) {
            $colleges = array($allColleges[0] => $allColleges[1]);
            array_push($collegeName, $colleges);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    // }
    return $collegeName;
}
function getUserTypeAsText()
{
    $type = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT TYPE_ID, USER_TYPE FROM USER_TYPE ORDER BY TYPE_ID");
        while ($allUsers = $query->fetch(PDO::FETCH_NUM)) {
            $types = array($allUsers[0] => $allUsers[1]);
            array_push($type, $types);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $type;
}
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

function getCourses()
{
    $courses = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT COURSE_ID, COURSE_CODE FROM COURSE ORDER BY COURSE_ID");
        while ($allCourses = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $course = array($allCourses[0] => $allCourses[1]);
            array_push($courses, $course);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $courses;
}
function getProfessorNames()
{
    $names = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT USER_ID, USERNAME FROM USERS WHERE TYPE_ID = 1");
        while ($allNames = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $name = array($allNames[0] => $allNames[1]);
            array_push($names, $name);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $names;
}

function getBuildings()
{
    $buildings = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT * FROM BUILDING");
        while ($allBldngs = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $bldng = array($allBldngs[0] => $allBldngs[1]);
            array_push($buildings, $bldng);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $buildings;
}

function getSemesters()
{
    $semesters = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT SEM_ID, SEM_NAME FROM SEMESTER ORDER BY SEM_NAME");
        while ($allSemesters = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $semester = array($allSemesters[0] => $allSemesters[1]);
            array_push($semesters, $semester);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $semesters;
}

function getRooms()
{
    $rooms = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT ROOM_ID, ROOM_NAME FROM ROOM");
        while ($allRooms = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $room = array($allRooms[0] => $allRooms[1]);
            array_push($rooms, $room);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $rooms;
}

function getBuildingRooms($buildingId)
{
    $rooms = "";
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT ROOM_ID, ROOM_NAME FROM ROOM WHERE BUILDING_ID = $buildingId");
        while ($allRooms = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $rooms .= $allRooms[0] . "@" . $allRooms[1] . "#";
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $rooms;
}


/**
 * Returns the users' id
 * and name inside an array
 * @author Omar Eldanasoury
 * @param mixed $collegeId the id of the college
 * @return string of id and user name.
 */
function getCollegeHODs($collegeId)
{
    $hods = "";
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT USER_ID, USERNAME FROM USERS WHERE TYPE_ID = 5 AND COLLEGE_ID = $collegeId");
        while ($user = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $hods .= $user[0] . "@" .  $user[1] . "#";
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $hods;
}

/**
 * Returns the programs of a certain college
 * in a string to support AJAX
 * 
 * @author Omar Eldanasoury
 * 
 */
function getCollegeProgramsToString($collegeId)
{
    $programs = "";
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        // gets all courses related to the department
        $query = $db->query("SELECT PROGRAM_ID, PROGRAM_NAME FROM PROGRAM_COLLEGE WHERE COLLEGE_ID = $collegeId;");
        while ($allPrograms = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $programs .= $allPrograms[0] . "@" . $allPrograms[1] . "#";
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $programs;
}

/**
 * Gets the id of the current semester
 * from the database
 * 
 * @author Omar Eldanasoury
 * @return mixed the id of the semester, or null if there is an error
 */
function getCurrentSemesterId()
{
    $currentSemesterId = null;
    require("connection.php");
    try {
        $query = $db->query("SELECT SEM_ID FROM SEMESTER WHERE SEM_STATUS = 1;");
        if ($sem = $query->fetch(PDO::FETCH_NUM)) {
            $currentSemesterId =  $sem[0];
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return $currentSemesterId;
}

/**
 * Returns all semester information
 * from the system
 * 
 * @author Omar Eldanasoury
 * @param $semesterId the id of the section
 * @return mixed an array of the section data, and returns null if the section does not exist in the system 
 */
function getSemesterData($semesterId)
{
    try {
        require("connection.php");
        $sql = "SELECT * FROM SEMESTER WHERE SEM_ID = $semesterId";
        $statement = $db->prepare($sql);
        $statement->execute();

        if ($semester = $statement->fetch(PDO::FETCH_ASSOC)) {
            return $semester;
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";

        $db = null;
    }
    return null;
}

/**
 * Returns true if the email
 * already exists in the db,
 * false otherwise.
 * 
 * @author Omar Eldanasoury
 * @param mixed $email the user's email
 * @return bool true if the email already exists in the db, otherwise false
 */
function doesEmailExists($email)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT USER_ID FROM USERS WHERE EMAIL LIKE ?");
        $query->execute(array($email));
        if ($result = $query->fetch(PDO::FETCH_NUM)) { // if there is a time conflict
            $db = null; // closing the connection
            return true;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return false;
}

/**
 * Returns user id by having their email
 * 
 * @author Omar Eldanasoury
 * @param mixed $email user email
 * @return mixed user id
 */
function getUserIdByEmail($email)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT USER_ID FROM USERS WHERE EMAIL LIKE ?");
        $query->execute(array($email));
        if ($result = $query->fetch(PDO::FETCH_NUM)) { // if there is a time conflict
            $db = null; // closing the connection
            return $result[0];
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return null;
}
