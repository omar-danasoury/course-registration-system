<?php
require_once("functions.php");

/**
 * Returns the list of services
 * that should be shown to professors.
 * 
 * @author Omar Eldanasoury
 * @return array<string> Professor's list of services
 */
function getProfessorList()
{
    return array(
        // TODO: Fill the paths of these pages
        "Manage Grades" => "professor/manage-grades.php",
        "Manage Appealing Requests" => "professor/appealing-requests.php",
        "View Section" => 'professor/view-section.php',
    );
}

/**
 * Returns the list of services
 * that should be shown to students.
 * 
 * @author Omar Eldanasoury
 * @return array<string> Student's list of services
 */
function getStudentList()
{
    return array(
        // TODO: Fill the paths of these pages
        "Course Registration" => "student/course-registration.php",
        "View Course Schedule" => "student/",
        "View Course Prerequisites" => 'student/view-prerequisites.php',
        "View Grades" => 'student/',
        "View Transcript" => 'student/',
        "Simulate GPA" => 'student/',
        "Request Summer Seat" => 'student/',
        "Add Appealing Request" => 'student/appealing-request.php',
        "View Appealing Requests" => 'student/view-appealing-requests.php',
        "Pay Courses Fees" => 'student/pay-fees.php',
    );
}

/**
 * Returns the list of services
 * that should be shown to admins.
 * 
 * @author Omar Eldanasoury
 * @return array<string> Admin's list of services
 */
function getAdminList()
{
    return array(
        // TODO: Fill the paths of these pages
        "Add Users" => "admin/",
        "View Users" => 'admin/',
        "Update Users" => 'admin/', // this is the same as managing the profile of users
        "Delete Users" => "admin/",
        // *********
        "Add Buildings" => 'admin/',
        "Delete Buildings" => 'admin/',

        "Add Room" => 'admin/',
        "Delete Room" => 'admin/',

        "Generate Reports" => 'admin/',
        "View Summer Seats" => 'admin/',

        "Add Semesters" => 'admin/',
        "View Semesters" => 'admin/',
        "Edit Semesters" => 'admin/',
        "Delete Semesters" => 'admin/',

        "Add Course" => 'admin/',
        "View Course" => 'admin/',
        "Edit Course" => 'admin/',
        "Delete Course" => 'admin/',

        "Add Section" => 'admin/add-section.php',
        "View Section" => 'admin/view-section.php',
        "Update Section" => 'admin/update-section.php',
        "Delete Section" => 'admin/delete-section.php',
    );
}

/**
 * Returns the list of services
 * that should be shown to head
 * of departmentusers.
 * 
 * @author Omar Eldanasoury
 * @return array<string> HOD's list of services
 */
function getHodList()
{
    // TODO: Fill the paths of these pages
    return array(
        "View Seat Requests" => "dean-hod/",
        "View Students" => "dean-hod/",
        "Close Section" => 'dean-hod/',
        "Edit Course Details" => 'dean-hod/',
        "Generate Reports" => 'dean-hod/'
    );
}

/**
 * Returns the list of services
 * that should be shown to dean
 * users.
 * 
 * @author Omar Eldanasoury
 * @return array<string> Dean's list of services
 * 
 */
function getDeanList()
{
    return array(
        // TODO: Fill the paths of these pages
        "View Seat Requests" => "dean-hod/",
        "View Students" => "dean-hod/",
        "View Staff" => 'dean-hod/',
        "Edit Course Details" => 'dean-hod/',
        "Generate Reports" => 'dean-hod/'
    );
}

/**
 * returns the list of servies
 * based on the type of the current
 * logged in user
 * 
 * @author Omar Eldanasoury
 * @return array<string> User's List as an array of string
 */
function getUserServicesList($userType)
{
    if ($userType == 'student')
        return getStudentList();
    else if ($userType == 'admin')
        return getAdminList();
    else if (($userType == 'head of department'))
        return getHodList();
    else if ($userType == 'professor')
        return getProfessorList();
    else
        return getDeanList();
}
