<?php
namespace App\Models;

use Core\Model;

class User extends Model
{
    private $idusers;
    private $nomUsers;
    private $prenomUsers;
    private $mailUsers;
    private $passUsers;
    private $roleUsers;
    private $adresse_idadresse;
    private $confMailUsers;
    private $confMdpUsers;

    private $errors=[];

    function __construct($db)
    {
        $this->setDb($db);
        $this->setTable("users");
        $this->setChamps(['idUsers']);
    }

    /**
     * @return mixed
     */
    public function getConfMailUsers()
    {
        return $this->confMailUsers;
    }

    /**
     * @param mixed $confMailUsers
     * @return User
     */
    public function setConfMailUsers($confMailUsers)
    {
        if($confMailUsers!=='')
        {
            if(htmlspecialchars(trim($confMailUsers))!==$this->mailUsers)
            {
                $this->setErrors('Erreur lors de la confirmation du mail');
            }
            else
            {
                $this->confMailUsers = htmlspecialchars(trim($confMailUsers));
            }
        }
        else
        {
            $this->setErrors('Le champ confirmation email ne peut être vide.');
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfMdpUsers()
    {
        return $this->confMdpUsers;
    }

    /**
     * @param mixed $confMdpUsers
     * @return User
     */
    public function setConfMdpUsers($confMdpUsers)
    {
        if($confMdpUsers!=='')
        {
            $this->confMdpUsers = htmlspecialchars(trim($confMdpUsers));
        }
        else
        {
            $this->setErrors('Le champ confirmation de mot de passe ne peut être vide.');
        }
        return $this;
    }


    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return User
     */
    public function setErrors($errors)
    {
        $this->errors[] = $errors;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdusers()
    {
        return $this->idusers;
    }

    /**
     * @param mixed $idusers
     * @return User
     */

    public function setIdusers($idusers)
    {
        $this->idusers = $idusers;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getNomUsers()
    {
        return $this->nomUsers;
    }

    /**
     * @param mixed $nomUsers
     * @return User
     */
    public function setNomUsers($nomUsers)
    {
        if($nomUsers!=='')
        {
            $this->nomUsers = htmlspecialchars(trim($nomUsers));
        }else
            {
                $this->setErrors('Le champ nom ne peut être vide.');
            }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrenomUsers()
    {
        return $this->prenomUsers;
    }

    /**
     * @param mixed $prenomUsers
     * @return User
     */
    public function setPrenomUsers($prenomUsers)
    {
        if($prenomUsers!=='')
        {
            $this->prenomUsers = htmlspecialchars(trim($prenomUsers));
        }else
            {
                $this->setErrors('Le champ prénom ne peut pas être vide');
            }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailUsers()
    {
        return $this->mailUsers;
    }

    /**
     * @param mixed $mailUsers
     * @return User
     */
    public function setMailUsers($mailUsers)
    {
        $test_mail="#^[a-zA-Z0-9]{1}[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-z]{2,6}$#";
        if($mailUsers!=='')
        {
            if(!preg_match($test_mail,htmlspecialchars(trim($mailUsers))))
            {
                $this->setErrors('Le format de l\'adresse mail est non valide.');
            }
            else
            {
                $this->mailUsers = htmlspecialchars(trim($mailUsers));
            }
        }else{
            $this->setErrors('Le champ mail ne peut pas être vide');
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassUsers()
    {
        return $this->passUsers;
    }

    /**
     * @param mixed $passUsers
     * @return User
     */
    public function setPassUsers($passUsers)
    {
        $test_mdp="#[A-Z]{1}#";
        if($passUsers!=='')
        {
            if(!preg_match($test_mdp,$passUsers))
            {
                $this->setErrors('Le mot de passe doit contenir une majuscule');
            }
            elseif (strlen($passUsers)<8)
            {
                $this->setErrors('Mot de passe trop court, il faut 8 caractères minimum');
            }
            elseif($passUsers!==$this->confMdpUsers)
            {
                $this->setErrors('Erreur lors de la confirmation du mot de passe');
            }
            else
            {
                $this->passUsers = password_hash(htmlspecialchars(trim($passUsers)),PASSWORD_BCRYPT);
            }
        }else
        {
            $this->setErrors('Le champ mot de passe ne peut pas être vide');
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoleUsers()
    {
        return $this->roleUsers;
    }

    /**
     * @param mixed $roleUsers
     * @return User
     */
    public function setRoleUsers($roleUsers)
    {
        $this->roleUsers = $roleUsers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdresseIdadresse()
    {
        return $this->adresse_idadresse;
    }

    /**
     * @param mixed $adresse_idadresse
     * @return User
     */
    public function setAdresseIdadresse($adresse_idadresse)
    {
        $this->adresse_idadresse = $adresse_idadresse;
        return $this;
    }

    public function check_user()
    {
        //On vérifie si le mail apparaît en DB
        $sqlSelMail_co='SELECT * FROM users
                    WHERE mailUsers=:mail';
        $reqSelMail_co=$this->getDb()->prepare($sqlSelMail_co);
        $reqSelMail_co->bindParam(':mail',$this->mailUsers);
        $reqSelMail_co->execute();
        $tab_mail_co=array();
        while($data=$reqSelMail_co->fetchObject())
        {
            array_push($tab_mail_co,$data);
        }
        if(empty($tab_mail_co))
        {
            return '';
        }
        else
        {
            $this->setNomUsers($tab_mail_co[0]->nomUsers);
            $this->setPrenomUsers($tab_mail_co[0]->prenomUsers);
            $this->setIdusers($tab_mail_co[0]->idUsers);
            $this->setRoleUsers($tab_mail_co[0]->roleUsers);
            $this->passUsers=$tab_mail_co[0]->passUsers;

           return $tab_mail_co[0]->passUsers;
        }
    }

    public function match_pass($pass)
    {
        //On vérifie si le mot de passe correspond avec celui enregistré
        return password_verify($pass,$this->passUsers);
    }

    public function insert_user($pass)
    {
        $sqlInsUser="INSERT INTO users (nomUsers,prenomUsers,mailUsers,passUsers,roleUsers,adresse_idadresse)
                     VALUES (:nom,:prenom,:mail,:pass,:role,:ad)";
        $reqInsUser=$this->getDb()->prepare($sqlInsUser);
        $reqInsUser->bindParam(':nom',$this->nomUsers);
        $reqInsUser->bindParam(':prenom',$this->prenomUsers);
        $reqInsUser->bindParam(':mail',$this->mailUsers);
        $reqInsUser->bindParam(':pass',$pass);
        $reqInsUser->bindParam(':role',$this->roleUsers);
        $reqInsUser->bindParam(':ad',$this->adresse_idadresse);
        $reqInsUser->execute();
        return intval($this->getDb()->lastInsertID());
    }

    public function update_user()
    {
        $sqlUpUser='UPDATE users SET
                nomUsers=:nom,
                adresse_idadresse=:id_a
                WHERE idUsers=:id_u';
        $reqUpUser=$this->getDb()->prepare($sqlUpUser);
        $reqUpUser->bindParam(':nom',$this->nomUsers);
        $reqUpUser->bindParam(':id_a',$this->adresse_idadresse);
        $reqUpUser->bindParam(':id_u',$_SESSION['iduser']);
        $reqUpUser->execute();
        $_SESSION['nom']=$this->nomUsers;
    }

}
