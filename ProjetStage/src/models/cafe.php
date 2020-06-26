<?php
namespace App\models;

use Core\Model;

class cafe extends Model
{
    private $nomCafe;
    private $typeCafe;
    private $decafCafe;
    private $bioCafe;
    private $prixCafe;
    private $resumeCafe;
    private $descCafe;
    private $photoCafe;
    private $date_creaCafe;
    private $date_modifCafe;
    private $selectCafe;
    private $nbventeCafe;
    private $stockCafe;
    private $pays_idpays;
    private $fournisseur_idfournisseur;


    public function __construct($db)
    {
        $this->setDb($db);
        $this->setTable("cafe");

    }
    /**
     * @return mixed
     */
    public function getNomCafe()
    {
        return $this->nomCafe;
    }

    /**
     * @param mixed $nomCafe
     * @return cafe
     */
    public function setNomCafe($nomCafe)
    {
        $this->nomCafe = htmlspecialchars(trim($nomCafe));
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeCafe()
    {
        return $this->typeCafe;
    }

    /**
     * @param mixed $typeCafe
     * @return cafe
     */
    public function setTypeCafe($typeCafe)
    {
        $this->typeCafe = $typeCafe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDecafCafe()
    {
        return $this->decafCafe;
    }

    /**
     * @param mixed $decafCafe
     * @return cafe
     */
    public function setDecafCafe($decafCafe)
    {
        $this->decafCafe = $decafCafe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBioCafe()
    {
        return $this->bioCafe;
    }

    /**
     * @param mixed $bioCafe
     * @return cafe
     */
    public function setBioCafe($bioCafe)
    {
        $this->bioCafe = $bioCafe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrixCafe()
    {
        return $this->prixCafe;
    }

    /**
     * @param mixed $prixCafe
     * @return cafe
     */
    public function setPrixCafe($prixCafe)
    {
        $this->prixCafe = htmlspecialchars(trim($prixCafe));
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResumeCafe()
    {
        return $this->resumeCafe;
    }

    /**
     * @param mixed $resumeCafe
     * @return cafe
     */
    public function setResumeCafe($resumeCafe)
    {
        $this->resumeCafe = htmlspecialchars(trim($resumeCafe));
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescCafe()
    {
        return $this->descCafe;
    }

    /**
     * @param mixed $descCafe
     * @return cafe
     */
    public function setDescCafe($descCafe)
    {
        $this->descCafe = htmlspecialchars(trim($descCafe));
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhotoCafe()
    {
        return $this->photoCafe;
    }

    /**
     * @param mixed $photoCafe
     * @return cafe
     */
    public function setPhotoCafe($photoCafe)
    {
        $this->photoCafe = $photoCafe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateCreaCafe()
    {
        return $this->date_creaCafe;
    }

    /**
     * @param mixed $date_creaCafe
     * @return cafe
     */
    public function setDateCreaCafe($date_creaCafe)
    {
        $this->date_creaCafe = $date_creaCafe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateModifCafe()
    {
        return $this->date_modifCafe;
    }

    /**
     * @param mixed $date_modifCafe
     * @return cafe
     */
    public function setDateModifCafe($date_modifCafe)
    {
        $this->date_modifCafe = $date_modifCafe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSelectCafe()
    {
        return $this->selectCafe;
    }

    /**
     * @param mixed $selectCafe
     * @return cafe
     */
    public function setSelectCafe($selectCafe)
    {
        $this->selectCafe = $selectCafe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNbventeCafe()
    {
        return $this->nbventeCafe;
    }

    /**
     * @param mixed $nbventeCafe
     * @return cafe
     */
    public function setNbventeCafe($nbventeCafe)
    {
        $this->nbventeCafe = $nbventeCafe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStockCafe()
    {
        return $this->stockCafe;
    }

    /**
     * @param mixed $stockCafe
     * @return cafe
     */
    public function setStockCafe($stockCafe)
    {
        $this->stockCafe = $stockCafe;
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
     * @return cafe
     */
    public function setPaysIdpays($pays_idpays)
    {
        $this->pays_idpays = $pays_idpays;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFournisseurIdfournisseur()
    {
        return $this->fournisseur_idfournisseur;
    }

    /**
     * @param mixed $fournisseur_idfournisseur
     * @return cafe
     */
    public function setFournisseurIdfournisseur($fournisseur_idfournisseur)
    {
        $this->fournisseur_idfournisseur = $fournisseur_idfournisseur;
        return $this;
    }

    public function insert(){
        $sqlInsertCafe='INSERT INTO cafe (nomCafe,typeCafe,decafCafe,bioCafe,prixCafe,resumeCafe,descCafe,photoCafe,date_creaCafe,selectCafe,stockCafe,pays_idpays,fournisseur_idfournisseur)
                            VALUES(:nom,:type_c,:deca,:bio,:prix,:resume,:descr,:photo,NOW(),:select_c,:stock,:id_p,:id_f)';
        $reqInsertCafe=$this->getDb()->prepare($sqlInsertCafe);
        $reqInsertCafe->bindParam(':nom',$this->nomCafe);
        $reqInsertCafe->bindParam(':type_c',$this->typeCafe);
        $reqInsertCafe->bindParam(':deca',$this->decafCafe);
        $reqInsertCafe->bindParam(':bio',$this->bioCafe);
        $reqInsertCafe->bindParam(':prix',$this->prixCafe);
        $reqInsertCafe->bindParam(':resume',$this->resumeCafe);
        $reqInsertCafe->bindParam(':descr',$this->descCafe);
        $reqInsertCafe->bindParam(':photo',$this->photoCafe);
        $reqInsertCafe->bindParam(':select_c',$this->selectCafe);
        $reqInsertCafe->bindParam(':stock',$this->stockCafe);
        $reqInsertCafe->bindParam(':id_p',$this->pays_idpays);
        $reqInsertCafe->bindParam(':id_f',$this->fournisseur_idfournisseur);
        $reqInsertCafe->execute();
    }
    public function exist()
    {
        //On vérifie si le café existe déjà
        $sqlSelect='SELECT idcafe FROM cafe
                WHERE nomCafe = :nom';
        $reqSelect=$this->getDb()->prepare($sqlSelect);
        $reqSelect->bindParam(':nom',$this->nomCafe);
        $reqSelect->execute();
        $tab_cafe=array();
        while($data=$reqSelect->fetchObject())
        {
            array_push($tab_cafe,$data);
        }
        if(!empty($tab_cafe))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function tri($triage,$indice)
    {
        //création des requêtes sql
        if ($triage === "NomA-Z") {
            $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 ORDER BY nomCafe
                 LIMIT ' . $indice . ',3';
            $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe';
        } elseif ($triage === "NomZ-A") {
            $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 ORDER BY nomCafe DESC
                 LIMIT ' . $indice . ',3';
            $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe';
        } elseif ($triage === "pays") {
            $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 ORDER BY nomPays
                 LIMIT ' . $indice . ',3';
            $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe';
        } elseif ($triage === "decafeine") {
            $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE decafCafe=1
                 LIMIT ' . $indice . ',3';
            $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE decafCafe=1';
        } elseif ($triage === "nondeca") {
            $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE decafCafe IS NULL
                 LIMIT ' . $indice . ',3';
            $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE decafCafe IS NULL';
        } elseif ($triage === "Bio") {
            $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE bioCafe=1
                 LIMIT ' . $indice . ',3';
            $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE bioCafe=1';
        } elseif ($triage === "nonbio") {
            $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE bioCafe IS NULL 
                 LIMIT ' . $indice . ',3';
            $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE bioCafe IS NULL';
        } elseif ($triage === "grain") {
            $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE typeCafe="En grain"
                 LIMIT ' . $indice . ',3';
            $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE typeCafe="En grain"';
        } elseif ($triage === "moulu") {
            $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE typeCafe="Moulu"
                 LIMIT ' . $indice . ',3';
            $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE typeCafe="Moulu"';
        }elseif ($triage === "+vendus")
        {
            $sqlaff='SELECT * FROM cafe
                     INNER JOIN pays ON pays_idpays=idpays
                     ORDER BY nbventeCafe DESC LIMIT ' .$indice . ',3';
            $sqlcpte=3;
        }elseif ($triage === "selected")
        {
            $sqlaff='SELECT * FROM cafe
                     INNER JOIN pays ON pays_idpays=idpays
                     WHERE selectCafe=1';
            $sqlcpte='SELECT COUNT(*) AS nbCafe FROM cafe
                      WHERE selectCafe=1';
        }
        else {
            $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 LIMIT ' . $indice . ',3';
            $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe';
        }
        return array($sqlaff,$sqlcpte);
    }

    public function nb_page($sql)
    {
        //récupération du nombre de café pour savoir le nombre de page à afficher
        $reqcpte=$this->getDb()->prepare($sql);
        $reqcpte->execute();
        $cpte=array();
        while($data=$reqcpte->fetchObject())
        {
            array_push($cpte,$data);
        }
        $nbre=$cpte[0]->nbCafe;
        return ceil($nbre/3);
    }

    public function recup_cafe($sql)
    {
        //récupération des cafés à afficher
        $reqaff=$this->getDb()->prepare($sql);
        $reqaff->execute();
        $tab_cafe=array();
        while($data=$reqaff->fetchObject())
        {
            array_push($tab_cafe,$data);
        }
        return $tab_cafe;
    }

    public static function aff($tab,$tri)
    {
        foreach ($tab as $cafe)
        {
            $file=explode('/',$_SERVER['REQUEST_URI']);
            $file=explode('?',$file[2]);
            if($cafe->typeCafe==='En grain')
            {
                $suffixe=' le sachet d\'1 kg';
            }
            else
                {
                    $suffixe=' le paquet de 250g';
                }
            ?>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12<?php if($tri!=="tous"){echo' mb-3';} ?>">
                <div class="card h-100 panneau">
                    <?php if($cafe->stockCafe==0){echo'<img src="public/img/epuise.png" class="card-img-top h-50">' ;
                    }else{ ?><img src="public/img/<?= $cafe->photoCafe ?>" class="card-img-top h-50" alt="..."><?php ;} ?>
                    <div class="card-body bg-marron2 d-flex flex-column justify-content-between">
                        <div>
                            <h4 class="card-title"><?= $cafe->nomCafe ?></h4>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-bold"><?= $cafe->typeCafe ?></h6>
                            <span class="card-text text-light font-weight-bold"><?= $cafe->nomPays ?></span>
                        </div>
                        <p class="card-text"><?= $cafe->resumeCafe ?></p>
                        <div class="d-flex justify-content-between">
                            <form method="get" action="detail" class="form-inline">
                                <input type="number" value="<?= $cafe->idcafe ?>" name="id" readonly="readonly" class="d-none"/>
                                <input type="text" value="nosproduits" name="page" class="d-none"/>
                                <button class="btn btn-sm btn-primary mr-1" type="submit"> Voir <i class="fa fa-plus" aria-hidden="true"></i> </button>
                            </form>
                            <?php if(isset($_SESSION['role']) && $_SESSION['role']==="admin")
                                { ?>
                                    <form method="get" action="modification" class="form-inline">
                                        <input type="number" value="<?= $cafe->idcafe ?>" name="id" readonly="readonly" class="d-none"/>
                                        <input type="text" value="nosproduits" name="page" class="d-none"/>
                                        <button class="btn btn-sm btn-warning mr-1" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier</button>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p><span class="font-weight-bold"><?= $cafe->prixCafe ?>€</span><?= $suffixe ?></p>
                        </div>
                    </div>
            </div>
                    <?php }
    }

    public function aff_un_cafe()
    {
        //on récupère les infos du café
        $sqlSelCaf='SELECT * FROM cafe
            INNER JOIN pays ON pays_idpays=idpays
            WHERE idcafe=:id';
        $reqSelCaf=$this->getDb()->prepare($sqlSelCaf);
        $reqSelCaf->bindParam(':id',$_GET['id']);
        $reqSelCaf->execute();
        $tab_cafe=array();
        while($data=$reqSelCaf->fetchObject())
        {
            array_push($tab_cafe,$data);
        }
        if($tab_cafe[0]->typeCafe==='En grain')
        {
            $suffixe=' le sachet d\'1 kg';
        }
        else
        {
            $suffixe=' le paquet de 250g';
        }
        return array($suffixe,$tab_cafe);

    }

    public function update_cafe()
    {
        //on met à jour le café
        $sqlUp = 'UPDATE cafe SET
            stockCafe=:stock,
            fournisseur_idfournisseur=:fourn,
            nomCafe=:nom,
            typeCafe=:type_c,
            decafCafe=:deca,
            bioCafe=:bio,
            prixCafe=:prix,
            resumeCafe=:resume,
            descCafe=:descr,
            photoCafe=:photo,
            date_modifCafe= NOW(),
            selectCafe=:select_c,
            pays_idpays=:id_p
            WHERE idcafe=:id_c';
        $reqUp=$this->getDb()->prepare($sqlUp);
        $reqUp->bindParam(':stock', $this->stockCafe);
        $reqUp->bindParam(':fourn', $this->fournisseur_idfournisseur);
        $reqUp->bindParam(':nom', $this->nomCafe);
        $reqUp->bindParam(':type_c', $this->typeCafe);
        $reqUp->bindParam(':deca', $this->decafCafe);
        $reqUp->bindParam(':bio', $this->bioCafe);
        $reqUp->bindParam(':prix', $this->prixCafe);
        $reqUp->bindParam(':resume', $this->resumeCafe);
        $reqUp->bindParam(':descr', $this->descCafe);
        $reqUp->bindParam(':photo', $this->photoCafe);
        $reqUp->bindParam('select_c', $this->selectCafe);
        $reqUp->bindParam(':id_p', $this->pays_idpays);
        $reqUp->bindParam(':id_c', $_POST["id_c"]);
        $reqUp->execute();
        $log= new \Core\Log();
        $log->write($_SESSION['prenom'].' '.$_SESSION['nom'].' a modifié le café  '.$_POST['nomCafe'].' dont l\'ID est : '.$_POST['id_c']);
    }
}
