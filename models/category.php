<?php
include_once(dirname(__DIR__) . '/common/helper.php');
include_once('user.php');

class Category 
{

    public $category_id;
    public $category_name;

    function getCategoryList()
    {
      $q = "SELECT * FROM category order by category_name asc;";
      $r = ExecuteQuery($q);
      $rowcount = $r->num_rows;
      return $r;
    }

    function createCategory($category_name)
    {
      $q = "insert into category (category_name) values('".$category_name."');";
      $r = ExecuteNonQuery($q);
      return $r;
    }
}