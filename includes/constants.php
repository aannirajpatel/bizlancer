<?php
define("USER_CANDIDATE",0);
define("USER_COMPANY",1);
function getUserTypeFromTable($con, $uid){
    $getUserTypeQuery = mysqli_query($con, "SELECT type FROM user WHERE uid=$uid");
    $getUserTypeData = mysqli_fetch_array($getUserTypeQuery);
    return $getUserTypeData['type'];
}
//COMPANY TYPE CONSTANTS
define("COMPANY_OTHER",0);
define("COMPANY_SOFTWARE",1);
define("COMPANY_HARDWARE",2);
define("COMPANY_MECHANICAL",3);
define("COMPANY_HR_MANAGEMENT",4);
$categoryArray = array(0=>"Other",1=>"Software",2=>"Hardware",3=>"Mechanical",4=>"HR / Management");
//PAYMENT TYPE CONSTANTS
define("PAY_PER_YEAR",0);
define("PAY_PER_MONTH",1);
define("PAY_PER_WEEK",2);
define("PAY_PER_DAY",3);
define("PAY_PER_HOUR",4);
$payScaleArray = array(0=>"Year",1=>"Month",2=>"Week",3=>"Day",4=>"Hour");
//JOB TYPE CONSTANTS
define("JOB_TYPE_FULLTIME",0);
define("JOB_TYPE_PARTTIME",1);
define("JOB_TYPE_FREELANCER",2);
define("JOB_TYPE_INTERNSHIP",3);
$jobTypeArray = array(0=>"Full Time",1=>"Part Time",2=>"Freelance",3=>"Internship");
$jobTypeDesignArray = array(0=>"full-time",1=>"part-time",2=>"part-time",3=>"full-time");
//APPLICANT TYPE CONSTANTS
define("CANDIDATE_APPLICANT",0);
define("CANDIDATE_SHORTLIST",1);
define("CANDIDATE_HIRED",2);
define("CANDIDATE_REJECTED",3);
define("CANDIDATE_WITHDRAWN",4);
define("JOB_LISTING_DELETED",5);
$statusArray = array("Applied","Shortlisted","Hired","Rejected","Withdrawn","Listing Deleted");