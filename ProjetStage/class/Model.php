<?php


namespace Core;


class Model
{
    private $db;

    private $table;
    private $champs=[];

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param mixed $db
     * @return Model
     */
    public function setDb($db)
    {
        $this->db = $db;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     * @return Model
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return array
     */
    public function getChamps()
    {
        return $this->champs;
    }

    /**
     * @param array $champs
     * @return Model
     */
    public function setChamps($champs)
    {
        $this->champs = $champs;
        return $this;
    }

    public function __construct($db)
    {
        $this->db=$db;
    }

    public function select_champ($champs,$valeur)
    {
        $sql='SELECT * FROM '.$this->getTable().
               ' WHERE '.$champs[0].'=:nomchamp';
        $req=$this->db->prepare($sql);
        $req->bindParam(':nomchamp',$valeur);
        $req->execute();
        $tab=array();
        while ($data=$req->fetchObject())
        {
            array_push($tab,$data);
        }
        return $tab;
    }
}