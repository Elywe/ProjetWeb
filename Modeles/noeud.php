<?php

class noeud {

    private $identifiant;
    private $label;
    private $parent;
    private $enfants;
    private $estDansCarte;

    function __construct($argument) {
        $this->enfants = array();
        foreach ($argument as $k => $v) {
            $this->$k = $v;
        }
    }

    public function hydrate($argument) {
        foreach ($argument as $k => $v) {
            $this->$k = $v;
        }
    }

    public function getEnfants() {
        return $this->enfants;
    }

    public function ajouterEnfant($enfant) {
        $this->enfants[] = $enfant;
        $enfant->setParent($this);
    }

    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function setIdentifiant($_identifiant) {
        $this->identifiant = $_identifiant;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($_label) {
        $this->label = $_label;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent($_parent) {
        $this->parent = $_parent;
    }

    public function getEstDansCarte() {
        return $this->estDansCarte;
    }

    public function setEstDansCarte($_estDansCarte) {
        $this->estDansCarte = $_estDansCarte;
    }

    public function afficher() {
        echo "<li>" . $this->getLabel() . "<a  data-id =\"" . $this->getIdentifiant() . "\" class = 'AjouterEnfant boutonsNoeuds boutonPlus'/>+</a>";
        if ($this->getParent() != null) {
            echo "<a  data-id =\"" . $this->getIdentifiant() . "\" class = 'SupprimerNoeud boutonsNoeuds'>-</a>";
        }
        echo "<a  data-id =\"" . $this->getIdentifiant() . "\" class = 'RenommerNoeud boutonsNoeuds boutonRenommer'>r</a><ul>";
        foreach ($this->enfants as $enfant) {
            $enfant->afficher();
        }
        echo "</ul></li>";
    }
	
	public function afficherSimple() {
        echo "<li>" . $this->getLabel()."<ul>";
        foreach ($this->enfants as $enfant) {
            $enfant->afficherSimple();
        }
        echo "</ul></li>";
    }
	

}
