<?php

class reservation extends user{

    private $date_arrivee=null;
    private $date_depart=null;
    private $emplacement=null;
    private $equipement=null;
    private $borne=null;
    private $club=null;
    private $activites=null;
    private $nb_emplacements=null;
    private $nb_jours=1;
    private $prix=null;

    //Fonctions pour la définition des variables

    public function setDate($arrivee,$depart)
    {
        $this->date_arrivee =$arrivee;
        $this->date_depart =$depart;
    }

    public function setNbJours()
    {
        //On transforme les 2 dates en timestamp pour faire la différence
        //On divise par 86 400 ()= 60*60*24 s) pour avoir des jours
        $this->nb_jours = ((strtotime($this->date_depart)-strtotime($this->date_arrivee))/86400); // 86 400 = 60*60*24
    }

    public function setEmplacement($emplacement)
    {
        $this->emplacement=$emplacement;
    }

    public function setEquipement($equipement)
    {
        $this->equipement =$equipement;
    }

    public function setOptions($borne,$club,$activites)
    {
        $this->borne =$borne;
        $this->club =$club;
        $this->activites =$activites;
    }

    public function setNbEmplacements()
    {
        $this->connect();
        $id_equipement=$this->equipement;
        $nb_emplacements=$this->execute("SELECT nb_emplacements FROM EQUIPEMENTS WHERE id=\"$id_equipement\"");
        $this->close();
        $this->nb_emplacements=intval($nb_emplacements[0][0]);
    }

    public function setPrix()
    {
        //Récupération des prix sur la BDD
        $this->connect();
        $prix_emplacement=$this->execute("SELECT prix FROM PRIX WHERE nom=\"Emplacement\"");
        $prix_borne=$this->execute("SELECT prix FROM PRIX WHERE nom=\"Borne\"");
        $prix_club=$this->execute("SELECT prix FROM PRIX WHERE nom=\"Club\"");
        $prix_activites=$this->execute("SELECT prix FROM PRIX WHERE nom=\"Activites\"");
        $this->close();
        $prix_emplacement=intval($prix_emplacement[0][0]);
        $prix_borne=intval($prix_borne[0][0]);
        $prix_club=intval($prix_club[0][0]);
        $prix_activites=intval($prix_activites[0][0]);

        //Calcul du prix journalier
        $prix_jour=($this->nb_emplacements)*$prix_emplacement+$this->borne*$prix_borne+$this->club*$prix_club+$this->activites*$prix_activites;

        //Calcul du prix pour la réservation
        $this->prix=$prix_jour*$this->nb_jours;
        return $this->prix;
    }

    //Fonctions pour l'affichage

    public function getDateArrivee($var=null)
    {
        if($var=="str")
        {
            return date("d/m/Y",strtotime($this->date_arrivee));
        }
        else
        {
            return $this->date_arrivee;
        }
    }

    public function getDateDepart($var=null)
    {
        if($var=="str")
        {
            return date("d/m/Y",strtotime($this->date_depart));
        }
        else
        {
            return $this->date_depart;
        }
    }

    public function getNbJours()
    {

        return $this->nb_jours;
    }

    public function getEmplacement($var=null)
    {
        if($var=="str")
        {
            $this->connect();
            $emplacement=$this->execute("SELECT * FROM EMPLACEMENTS WHERE id=$this->emplacement");
            return $emplacement[0][1];
        }
        else
        {
            return $this->emplacement;
        }
    }

    public function getNbEmplacements()
    {
        return $this->nb_emplacements;
    }

    public function getEquipement($var=null)
    {
        if($var=="str")
        {
            $this->connect();
            $equipement=$this->execute("SELECT * FROM EQUIPEMENTS WHERE id=$this->equipement");
            return $equipement[0][1];
        }
        else
        {
            return $this->equipement;
        }
    }

    public function getBorne($var=null)
    {
        if($var=="str")
        {
            if($this->borne==1) return "<p>Accès à la borne électrique</p>";
        }
        else
        {
            return $this->borne;
        }
    }


    public function getClub($var=null)
    {
        if($var=="str")
        {
            if($this->club==1) return "<p>Accès au Disco-Club 'Les girelles dansantes'</p>";
        }
        else
        {
            return $this->club;
        }
    }


    public function getActivites($var=null)
    {
        if($var=="str")
        {
            if($this->activites==1) return "<p>Accès aux activités Yoga, Frisbee et Ski Nautique</p>";
        }
        else
        {
            return $this->activites;
        }
    }

    public function getPrix()
    {
        return $this->prix;
    }
}

    ?>
