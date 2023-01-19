<?php
include_once(dirname(__DIR__) . '/common/helper.php');

class Location 
{

    public $location_id;
    public $location_name;

    function getlocationList()
    {
      $q = "SELECT * FROM location order by location_name asc;";
      $r = ExecuteQuery($q);
      $rowcount = $r->num_rows;
      return $r;
    }
}