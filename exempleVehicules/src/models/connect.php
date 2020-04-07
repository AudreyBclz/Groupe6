<?php

function connect(){
    try
    {
        $db = new PDO('mysql:host='.LOCALHOST.';dbname='.DBNAME.';charset=utf8', DBID, DBMDP);
        return $db;
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
}
