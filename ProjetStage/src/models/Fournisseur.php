<?php


namespace App\models;


class Fournisseur
{
    private $idfournisseur;
    private $nomFournisseur;

    private $db;

    /**
     * @return mixed
     */
    public function getIdfournisseur()
    {
        return $this->idfournisseur;
    }

    /**
     * @param mixed $idfournisseur
     * @return Fournisseur
     */
    public function setIdfournisseur($idfournisseur)
    {
        $this->idfournisseur = $idfournisseur;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomFournisseur()
    {
        return $this->nomFournisseur;
    }

    /**
     * @param mixed $nomFournisseur
     * @return Fournisseur
     */
    public function setNomFournisseur($nomFournisseur)
    {
        $this->nomFournisseur = $nomFournisseur;
        return $this;
    }

    public function __construct($db)
    {
        $this->db=$db;
    }

    public function select_fournisseur()
    {
        //on récupère la liste des fournisseurs
        $sqlSelFourn='SELECT * FROM fournisseur';
        $reqSelFourn= $this->db->prepare($sqlSelFourn);
        $reqSelFourn->execute();
        $tab_fourn=array();
        while($data=$reqSelFourn->fetchObject())
        {
            array_push($tab_fourn,$data);
        }
        return$tab_fourn;
    }
}