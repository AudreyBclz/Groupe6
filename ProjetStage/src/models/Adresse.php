<?php
namespace App\Models;


class Adresse
{
    private $adressePrenom;
    private $adresseNom;
    private $adresse1;
    private $adresse2;
    private $adresseCP;
    private $adresseVille;
    private $pays_idpays;

    private $db;


    private $errors=[];

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return Adresse
     */
    public function setErrors($errors)
    {
        $this->errors[] = $errors;
        return $this;
    }

    public function __construct($db)
    {
        $this->db=$db;
    }

    /**
     * @return mixed
     */
    public function getAdressePrenom()
    {
        return $this->adressePrenom;
    }

    /**
     * @param mixed $adressePrenom
     * @return Adresse
     */
    public function setAdressePrenom($adressePrenom)
    {
        $this->adressePrenom = htmlspecialchars(trim($adressePrenom));
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdresseNom()
    {
        return $this->adresseNom;
    }

    /**
     * @param mixed $adresseNom
     * @return Adresse
     */
    public function setAdresseNom($adresseNom)
    {
        $this->adresseNom = htmlspecialchars(trim($adresseNom));
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdresse1()
    {
        return $this->adresse1;
    }

    /**
     * @param mixed $adresse1
     * @return Adresse
     */
    public function setAdresse1($adresse1)
    {
        if($adresse1!=='')
        {
            $this->adresse1 = htmlspecialchars(trim($adresse1));
        }
        else
        {
            $this->setErrors('Le champ adresse ne peut être vide');
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdresse2()
    {
        return $this->adresse2;
    }

    /**
     * @param mixed $adresse2
     * @return Adresse
     */
    public function setAdresse2($adresse2)
    {
        $this->adresse2 = htmlspecialchars(trim($adresse2));
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdresseCP()
    {
        return $this->adresseCP;
    }

    /**
     * @param mixed $adresseCP
     * @return Adresse
     */
    public function setAdresseCP($adresseCP)
    {
        if($adresseCP!=='')
        {
            $this->adresseCP = htmlspecialchars(trim($adresseCP));
        }
        else
        {
            $this->setErrors('Le champ code postal ne peut être vide');
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdresseVille()
    {
        return $this->adresseVille;
    }

    /**
     * @param mixed $adresseVille
     * @return Adresse
     */
    public function setAdresseVille($adresseVille)
    {
        if($adresseVille!=='')
        {
            $this->adresseVille = htmlspecialchars(trim($adresseVille));
        }
        else
        {
            $this->setErrors('Le champ ville ne peut être vide.');
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaysIdpays()
    {
        return $this->pays_idpays;
    }

    /**
     * @param mixed $pays_idpays
     * @return Adresse
     */
    public function setPaysIdpays($pays_idpays)
    {
        $this->pays_idpays = $pays_idpays;
        return $this;
    }

    public function check_adresse($pays,$val)
    {
        //On vérifie si l'adresse existe déjà si oui on récupère l'id
        $nom=$pays->getNomPays();
        if($val===0)
        {
            $sqlSelAd = 'SELECT idadresse,pays_idpays FROM adresse
                    INNER JOIN pays ON pays_idpays=idpays
                    WHERE adresse1=:ad
                    AND adresse2=:ad2
                    AND adresseCP=:cp
                    AND adresseVille=:ville
                    AND nomPays=:pays
                    AND adresseNom IS NULL
                    AND adressePrenom IS NULL';
            $reqSelAd=$this->db->prepare($sqlSelAd);
        }
        else
        {
            $sqlSelAd = 'SELECT idadresse,pays_idpays FROM adresse
                    INNER JOIN pays ON pays_idpays=idpays
                    WHERE adresse1=:ad
                    AND adresse2=:ad2
                    AND adresseCP=:cp
                    AND adresseVille=:ville
                    AND nomPays=:pays
                    AND adresseNom=:nom
                    AND adressePrenom=:prenom';
            $reqSelAd=$this->db->prepare($sqlSelAd);
            $reqSelAd->bindParam(':nom',$this->adresseNom);
            $reqSelAd->bindParam(':prenom',$this->adressePrenom);
        }
        $reqSelAd->bindParam(':ad',$this->adresse1);
        $reqSelAd->bindParam(':ad2',$this->adresse2);
        $reqSelAd->bindParam(':cp',$this->adresseCP);
        $reqSelAd->bindParam(':ville',$this->adresseVille);
        $reqSelAd->bindParam(':pays',$nom);
        $reqSelAd->execute();
        $tab_ad=array();
        while($data=$reqSelAd->fetchObject())
        {
            array_push($tab_ad,$data);
        }
        if(!empty($tab_ad))
        {
            return intval($tab_ad[0]->idadresse);
        }
        else
        {
            return '';
        }
    }

    public function insert_adresse($val)
    {
        if($val===0)
        {
            $sqlInsAd='INSERT INTO adresse (adresse1,adresse2,adresseCP,adresseVille,pays_idpays)
                    VALUES (:ad1,:ad2,:cp,:ville,:pays)';
            $reqInsAd=$this->db->prepare($sqlInsAd);
            $reqInsAd->bindParam(':ad1',$this->adresse1);
            $reqInsAd->bindParam(':ad2',$this->adresse2);
            $reqInsAd->bindParam(':cp',$this->adresseCP);
            $reqInsAd->bindParam(':ville',$this->adresseVille);
            $reqInsAd->bindParam(':pays',$this->pays_idpays);
            $reqInsAd->execute();
            return intval($this->db->lastInsertId());


        }
        else
        {
            $sqlInsAd='INSERT INTO adresse (adressePrenom,adresseNom,adresse1,adresse2,adresseCP,adresseVille,pays_idpays)
                    VALUES (:prenom,:nom,:ad1,:ad2,:cp,:ville,:pays)';
            $reqInsAd=$this->db->prepare($sqlInsAd);
            $reqInsAd->bindParam(':prenom',$this->adressePrenom);
            $reqInsAd->bindParam(':nom',$this->adresseNom);
            $reqInsAd->bindParam(':ad1',$this->adresse1);
            $reqInsAd->bindParam(':ad2',$this->adresse2);
            $reqInsAd->bindParam(':cp',$this->adresseCP);
            $reqInsAd->bindParam(':ville',$this->adresseVille);
            $reqInsAd->bindParam(':pays',$this->pays_idpays);
            $reqInsAd->execute();
            return intval($this->db->lastInsertId());

        }


    }

    public function aff_adresse()
    {
        //on récupère l'adresse de facturation pour l'afficher
        $sqlAdFacture = 'SELECT * FROM users
                    INNER JOIN adresse ON adresse_idadresse=idadresse
                    INNER JOIN pays ON pays_idpays=idpays
                   WHERE idUsers=:id';
        $reqAdFacture = $this->db->prepare($sqlAdFacture);
        $reqAdFacture->bindParam(':id', $_SESSION['iduser']);
        $reqAdFacture->execute();
        $tab_ad_fact = array();
        while ($data = $reqAdFacture->fetchObject()) {
            array_push($tab_ad_fact, $data);
        }
        return $tab_ad_fact;
    }


}
