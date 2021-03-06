<?php

class connexion {

    public function defaut() {
        $donnees["titre"] = "Connexion";
        include_once('Modeles/carteManager.php');
        afficherVues("Vues/vueConnexion.php", $donnees);
    }

    public function coUtil() {
        include_once('Modeles/utilisateurManager.php');
        $manager = new utilisateurManager();
        if (isset($_POST['ValCo'])) {
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $mdp = htmlspecialchars($_POST['mdp']);
			$res = $manager->getlogin($pseudo, $mdp);
            if ($res == 'Connecte') {
                include_once('Controleurs/mesCartes.php');
                $cartes = new mesCartes();
                $cartes->defaut();
            } else {
                $donnees["titre"] = "Connexion";
                $donnees['erreur'] = $res;
                afficherVues("Vues/vueConnexion.php", $donnees);
            }
        }
    }

    public function deco() {
        session_destroy();
        Header('Location: index.php?section=Connexion');
    }

    public function ajoutUtilisateur() {
        include_once('Modeles/utilisateurManager.php');
        $manaUtil = new utilisateurManager();
        if (isset($_POST['ValInsc'])) {
            unset($_POST['ValInsc']);
            foreach ($_POST as $key => $value) {
                $_POST[$key] = htmlspecialchars($value);
			}
			$_POST['mdp']= password_hash($_POST['mdp'], PASSWORD_DEFAULT);
			$util = new utilisateur($_POST);
            $manaUtil->ajouter($util);
        }
        include_once('Controleurs/mesCartes.php');
        $cartes = new mesCartes();
        $cartes->defaut();
    }

}
