<?php
/***************************
 * *************************
 * Cette page vient chercher
 * dans la BDD le matériel 
 * qui est à supprimer
 * et le supprime puis 
 * renvoie sur la page
 * admin.php
 *********************/
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=campusweb;charset=utf8', 'root','root');
        $req=$bdd->prepare('DELETE FROM utilisation WHERE utilisation.idUtilisation = :idUtilisation');
        $req->execute(array(
            'idUtilisation' => $_GET['param']
            )) or die (print_r($req->errorInfo()));  


        header('Location:admin.php');
        exit();
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
?>