<?php
require('config.php');

function ExecuteNonQuery($query)  //to get number of rows affected after executing query
{
    $dbc = createConnection();
    $result = $dbc->query($query);
    $rowcount = $dbc->affected_rows;
    $dbc->close();
    return $rowcount;
    exit();
};


function ExecuteQuery($query)  //to get list  of rows after executing query
{
    $dbc = createConnection();
    $result = $dbc->query($query);
    $dbc->close();
    return $result;
    exit();
};

function ExecuteScalar($query)  //to get  last inserted primary key 
{
    $dbc = createConnection();
    $r = $dbc->query($query);
    $id = $dbc->insert_id;
    $dbc->close();
    return $id;
    exit();
};
