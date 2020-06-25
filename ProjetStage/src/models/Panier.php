<?php
namespace App\Models;

use Core\Model;

class Panier extends Model
{
    private $users_idUsers;
    private $cafe_idcafe;
    private $quantite;
    private $adresse_idadresse;


    public function __construct($db)
    {
        $this->setDb($db);
        $this->setTable("panier");
        $this->setChamps(['']);
    }

    /**
     * @return mixed
     */
    public function getUsersIdUsers()
    {
        return $this->users_idUsers;
    }

    /**
     * @param mixed $users_idUsers
     * @return Panier
     */
    public function setUsersIdUsers($users_idUsers)
    {
        $this->users_idUsers = $users_idUsers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCafeIdcafe()
    {
        return $this->cafe_idcafe;
    }

    /**
     * @param mixed $cafe_idcafe
     * @return Panier
     */
    public function setCafeIdcafe($cafe_idcafe)
    {
        $this->cafe_idcafe = $cafe_idcafe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param mixed $quantite
     * @return Panier
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
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
     * @return Panier
     */
    public function setAdresseIdadresse($adresse_idadresse)
    {
        $this->adresse_idadresse = $adresse_idadresse;
        return $this;
    }

    public function delete_article()
    {
        $sqlDel = 'DELETE FROM panier
            WHERE cafe_idcafe=' . $this->cafe_idcafe;
        $reqDel = $this->getDb()->prepare($sqlDel);
        $reqDel->execute();
        echo '<div class="alert-danger p-2 text-center">Produit supprimé</div>';

    }

    public function nb_article()
    {
        //on récupère le nombre d'article
        $cpteArticle = 'SELECT COUNT(*) as nbarticle FROM panier
                  WHERE users_idUsers=:id';
        $reqcpteArticle = $this->getDb()->prepare($cpteArticle);
        $reqcpteArticle->bindParam(':id', $_SESSION['iduser']);
        $reqcpteArticle->execute();
        $tab_compte = array();
        while ($data = $reqcpteArticle->fetchObject()) {
            array_push($tab_compte, $data);
        }
        return intval($tab_compte[0]->nbarticle);
    }

    public function update_panier_page_panier($nbArticle)
    {
        for ($ind = 1; $ind <= $nbArticle; $ind++) {
            //si le $_POST quantité.ind est là cela veut dire que l'on veut modifier la quantité de café qui a l'id $_Post[id_.ind]
            if (isset($_POST['quantite_' . $ind])) {

                //on récupère les infos du café avec notamment le stock
                $sqlSelArticle = 'SELECT * FROM panier
                            INNER JOIN cafe ON cafe_idcafe=idcafe
                            WHERE users_idUsers=:id
                            AND cafe_idcafe=:id_c';
                $reqSelArticle = $this->getDb()->prepare($sqlSelArticle);
                $reqSelArticle->bindParam(':id', $_SESSION['iduser']);
                $reqSelArticle->bindParam('id_c', $_POST['id_' . $ind]);
                $reqSelArticle->execute();
                $tab_article = array();
                while ($data = $reqSelArticle->fetchObject()) {
                    array_push($tab_article, $data);
                }
                if ($_POST['quantite_' . $ind] > $tab_article[0]->stockCafe) {
                    echo '<div class="alert-warning p-2 text-center">Quantité supérieur au stock du produit</div>';

                } else {
                    //si le stock est suffisant on fait l'Update
                    $sqlUpPan = 'UPDATE panier SET
                       quantite=:qte
                       WHERE users_idUsers=:id
                       AND cafe_idcafe=:id_c';
                    $reqUpPan = $this->getDb()->prepare($sqlUpPan);
                    $reqUpPan->bindParam(':qte', $_POST['quantite_' . $ind]);
                    $reqUpPan->bindParam(':id', $_SESSION['iduser']);
                    $reqUpPan->bindParam('id_c', $_POST['id_' . $ind]);
                    $reqUpPan->execute();
                }
            }
        }
    }

    public function aff_panier()
    {
        //on récupère le panier de l'utilisateur avec les infos des cafés pour pouvoir les afficher
        $sqlSelPan = 'SELECT * FROM panier
                            INNER JOIN cafe ON cafe_idcafe=idcafe
                            INNER JOIN adresse ON adresse_idadresse=idadresse
                            INNER JOIN users ON users_idUsers=idUsers
                            WHERE users_idUsers =:id';
        $reqSelPan = $this->getDb()->prepare($sqlSelPan);
        $reqSelPan->bindParam(':id', $_SESSION['iduser']);
        $reqSelPan->execute();
        $tab_pan = array();
        $pxtotal = 0;
        $i = 0;
        while ($data = $reqSelPan->fetchObject()) {
            array_push($tab_pan, $data);
        }
        return $tab_pan;
    }

    public function update_panier_page_voir($tab_cafe)
    {
        //on affiche une erreur si la quantité que l'on veut ajouter est supérieur au stock
        if ($tab_cafe[0]->stockCafe < $_GET['quantite'])
        {
            echo '<div class="alert-warning p-2 text-center">Quantité supérieur au stock du produit</div>';
        } elseif (isset($_SESSION['nom']))
        {

            //on vérifie s'il y a déjà de ce café dans le panier
            $sqlSelPanier = 'SELECT * FROM panier
                        INNER JOIN cafe ON cafe_idcafe=idcafe
                        WHERE  users_idUsers=:id
                        AND cafe_idcafe=:id_c';
            $reqSelPanier = $this->getDb()->prepare($sqlSelPanier);
            $reqSelPanier->bindParam('id', $_SESSION['iduser']);
            $reqSelPanier->bindParam(':id_c', $_GET['id']);
            $reqSelPanier->execute();
            $tab_panier = array();
            while ($data = $reqSelPanier->fetchObject()) {
                array_push($tab_panier, $data);
            }
            if (!empty($tab_panier))
            {
                $qte = intval($tab_panier[0]->quantite);
                $stock = intval($tab_panier[0]->stockCafe);

                //on vérifie si la quantité que l'on ajoute + celle du panier n'est pas supérieur au stock
                if (($qte + $_GET['quantite'] > $stock))
                {
                    echo '<div class="alert-warning p-2 text-center">Vous ne pouvez pas acheter autant de cet article</div>';
                } else
                {
                    // si non on update le panier
                    $sqlUpPan = 'UPDATE panier
                        SET quantite=:quant
                        WHERE users_idUsers=:id
                        AND cafe_idcafe=:id_c';
                    $reqUpPan = $this->getDb()->prepare($sqlUpPan);
                    $quantite = $qte + $_GET['quantite'];
                    $reqUpPan->bindParam(':quant', $quantite);
                    $reqUpPan->bindParam(':id', $_SESSION['iduser']);
                    $reqUpPan->bindParam(':id_c', $_GET['id']);
                    $reqUpPan->execute();
                    echo '<div class="alert-info p-2 text-center">Article(s) ajouté(s) à votre panier</div>';
                }
            }
            else
            {
                return false;
            }
        }
    }

    public function insert_panier($idAd)
    {
        // on insère le nouveau produit dans le panier
        $sqlInsPan = 'INSERT INTO panier (users_idUsers,cafe_idcafe,quantite,adresse_idadresse)
                        VALUES (:id_u,:id_c,:qte,:ad)';
        $reqInsPan = $this->getDb()->prepare($sqlInsPan);
        $reqInsPan->bindParam('id_u', $_SESSION['iduser']);
        $reqInsPan->bindParam('id_c', $_GET['id']);
        $reqInsPan->bindParam(':qte', $_GET['quantite']);
        $reqInsPan->bindParam(':ad', $idAd);
        if($reqInsPan->execute())
        {
            $_SESSION['has-cart']=1;
        }

    }
}

