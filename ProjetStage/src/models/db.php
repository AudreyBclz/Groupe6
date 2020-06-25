<?php


namespace App\models;


class db
{
    private $db;

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
            $db = new \PDO('mysql:host='.LOCALHOST.';dbname='.DBNAME.';charset=utf8',DBID,DBMDP);
            $this->setDb($db);
        }
        catch(\Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
}