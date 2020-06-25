<?php
namespace App\Models;




use Core\Model;

class pays extends Model
{
    private $nomPays;


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
     * @return pays
     */
    public function setErrors($errors)
    {
        $this->errors[] = $errors;
        return $this;
    }

    function __construct($db)
    {
        $this->setDb($db);
        $this->setTable("pays");
        $this->setChamps(['nomPays','idpays']);
    }

    /**
     * @return mixed
     */
    public function getNomPays()
    {
        return $this->nomPays;
    }

    /**
     * @param mixed $nomPays
     * @return pays
     */
    public function setNomPays($nomPays)
    {
        if($nomPays!=='')
        {
            $this->nomPays = htmlspecialchars(trim($nomPays));
        }
        else
        {
            $this->setErrors('Le champ pays ne peut être vide.');
        }

        return $this;
    }

    public function insert_pays(){
        //s'il n'existe pas on insère le pays en db et on récupère l'id
        $sqlInsertPays = 'INSERT INTO pays (nomPays) VALUES(:pays_p)';
        $reqInsertPays = $this->getDb()->prepare($sqlInsertPays);
        $reqInsertPays->bindParam(':pays_p', $this->nomPays);
        $reqInsertPays->execute();
        return intval($this->getDb()->lastInsertId());

    }
}
