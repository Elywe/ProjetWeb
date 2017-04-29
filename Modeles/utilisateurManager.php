<?php

include_once("utilisateur.php");

class utilisateurManager {

    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
    }

    public function getList() {
        $liste = array();
        $query = $this->db->query('SELECT * FROM utilisateur');
        while ($donnees = $query->fetch(PDO::FETCH_ASSOC)) {
            $liste[] = new utilisateur($donnees);
        }
        return $liste;
    }

    public function ajouter($utilisateur) {
        $query = $this->db->prepare('INSERT INTO utilisateur (identifiant, pseudo, mdp) values (:identifiant, :pseudo, :mdp)');
        $query->bindValue(':identifiant', null, PDO::PARAM_INT);
        $query->bindValue(':pseudo', $utilisateur->getPseudo());
        $query->bindValue(':mdp', $utilisateur->getMdp());
        $query->execute();
        $utilisateur->setIdentifiant($this->db->lastInsertId());
    }
	
	/*public function getlogin()
	{
		if(isset($_POST['pseudoConnec']) && isset($_POST['passConnec'])){
			$sql = $this->db->query("SELECT * FROM utilisateur where pseudo='".$_POST['pseudoConnec']."' and mdp='".$_POST['passConnec']."'");
			if($sql->fetch()){
				return 'Connecte';
			}else{
				return 'Utilisateur non reconnu';
			}
		}
	}*/
	public function getlogin($pseudo,$mdp)
	{
		$sql = $this->db->query("SELECT identifiant,pseudo,mdp FROM utilisateur where pseudo='".$pseudo."' and mdp='".$mdp."'");
			if($donnees = $sql->fetch(PDO::FETCH_ASSOC)){
				$_SESSION['identifiant']=$donnees['identifiant'];
				$_SESSION['pseudo']=$donnees['pseudo'];  //ouverture de la session de l'utilisateur à la connexion
				$_SESSION['mdp']=$mdp;
				return 'Connecte';
			}else{
				return 'Utilisateur non reconnu';
			}
		
	}
	

    public function update($utilisateur) {
		$query = $this->db->query("UPDATE utilisateur SET mdp='".$utilisateur->getMdp()."' WHERE identifiant=".$utilisateur->getIdentifiant());
		$_SESSION['identifiant']=$utilisateur->getIdentifiant();
		$_SESSION['pseudo']=$utilisateur->getPseudo();  //ouverture de la session de l'utilisateur à la connexion
		$_SESSION['mdp']=$utilisateur->getMdp();
    }

    public function supprimer($idUtilisateur) {
        $query = $this->db->prepare('DELETE FROM utilisateur WHERE identifiant=:id');
        $query->bindValue(':id', $idUtilisateur, PDO::PARAM_INT);
        $query->execute();
    }

}
