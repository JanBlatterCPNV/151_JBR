<?php
/**
 * 151_2019_startproject - userManagement.php
 * User: Jan.BLATTER
 * Date: 07.02.2020
 */

require "dbConnector.php";


function CheckLogin($formL)
{
    $password = $formL['password'];                 // le password du formulaire --> dans la variable password
    $email = $formL['username'];                    // username du formulaire --> dans la variable email


    $requete = "SELECT userEmailAddress, userHashPsw FROM users where userEmailAddress ='$email';";      // La commande MySQL , vérifie si l'email existe
    $result = executeQuery($requete);

    if ($result) {
      if(password_verify($password, $result[0]['userHashPsw'])){

                              // si le compte existe , vérifie le password haché
        $_SESSION['e-mail'] = $formL['username'];

        $test = CheckAdmin($email);
        if ($test == 1){
            $_SESSION['admin'] = "admin";
        }
        else{
            $_SESSION['admin'] = "client";
        }
        return true;
    } else {
        return false;
    }
}else{ return false;
    }
}


function CheckRegister($formR)
{
    $email = $formR['usernameRegister'];                // le nom du formulaire est dans email
    $pseudo = $formR['pseudo'];
    $username =$formR['usernameRegister'];
    $requeteR = "SELECT userEmailAddress, pseudo FROM users WHERE userEmailAddress ='" .$username. "';";   // requête , vérifie si l'usernameregister existe déjà
    $queryResult = executeQuery($requeteR);

    if ($queryResult) {
        return false;
    } else {
        if ($formR['passwordRegister'] == $formR['passwordVerify']) {    // si le password du formulaire register est identique  avec la confirmation du mdp, hash le mdp.
            $pwdHash = password_hash($formR['passwordRegister'], PASSWORD_DEFAULT);
            $requeteAdd = "INSERT INTO snows.users (userEmailAddress, userHashPsw, pseudo, userType) VALUES ('$email', '$pwdHash','$pseudo',NULL);";       // ajoute le compte dans la base de donnée
            executeQuery($requeteAdd);

            $_SESSION['e-mail'] = $formR['usernameRegister'];  //ouvre la session dès que la personne créé un compte.

            echo "Compte créé.";
            return true;
        } else {
            return false;
        }
    }
}

Function CheckAdmin($email){
    $CheckAdmin = "Select userType from users where userEmailAddress = '$email'";
    $result = executeQuery($CheckAdmin);

    if ($result[0]['userType'] == 1){
        return 1;
    }
    else{
    return 0;
    }


}


