<?php


namespace App\models;


class db
{
   public $db;

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param mixed $db
     * @return db
     */
    public function setDb($db)
    {
        $this->db = $db;
        return $this;
    }

    public function __construct()
    {
        try
        {
            $this->db = new \PDO('mysql:host='.LOCALHOST.';dbname='.DBNAME.';charset=utf8',DBID,DBMDP);
        }
        catch(\Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
}