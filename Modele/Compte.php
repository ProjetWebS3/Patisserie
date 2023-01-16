<?php

class Compte {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function submitAction($pseudo, $mail, $password, $admin){

        $query = $this->db->query("SELECT * FROM Compte WHERE Email = '$mail'");
        $result = $query->fetchAll();

        if(count($result) > 0) {           
            var_dump("L'adresse mail existe déja");   
        } else {         
            $query = $this->db->prepare("INSERT INTO Compte (id_compte, Pseudo, Email, Password, Admin) VALUES (:id_compte, :pseudo, :email, :password, :admin);");
            $query->bindValue(':id_compte', '', PDO::PARAM_INT);
            $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
            $query->bindValue(':email', $mail, PDO::PARAM_STR);
            $query->bindValue(':password', $password, PDO::PARAM_STR);
            $query->bindValue(':admin', $admin, PDO::PARAM_BOOL);
            $query->execute();
        }

    }

    public function getCompteAction($mail, $password){
        $query = $this->db->query("SELECT Password FROM Compte WHERE Email = '$mail'");
        $result = $query->fetchAll();
        
        if ($result[0]["Password"] == $password) {
            var_dump("Vous êtes connecté");
        } else {
            print_r("Mauvais mot de passe ");
            print_r("<br>");
            print_r("le mot de passe était : ");
            print_r($result[0]["Password"]);
            print_r("<br>");
            print_r("le mot de passe entré était : ");
            print_r($password);
            print_r("<br>");
        }
    }

}
