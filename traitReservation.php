<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <?php

    /******************************************************
     * Ici, le code vient ajouter dans la table utilisation
     * en base de données une réservation en fonction des
     * demandes effectuées sur le formulaire 
     */
    if (!isset($_SESSION['NAME']))
    {
        header('Location:index.php');
        exit();
    }
    else
    {
        if($_POST['heureDeb']>$_POST['heureFin'])
        {
            header("Location:reservation.php?param=".$_GET['param']);
            exit();
        }
        else if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['date']) && isset($_POST['heureFin']) && isset($_POST['heureDeb']) )
        {
            
            try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=campusweb;charset=utf8', 'root', 'root');
                $req=$bdd->prepare('INSERT INTO utilisation(debut,fin,type,numIdBoard,idMat ) VALUES(:debut,:fin,:type,:numIdBoard,:idMat)');  
                $req->execute(array(
                'debut' => $_POST['date']." ".$_POST['heureDeb'].":00:00",
                'fin' => $_POST['date']." ".$_POST['heureFin'].":00:00",
                'type' => 0,
                'numIdBoard'=>$_SESSION['ID'],
                'idMat'=>$_GET['param']
                )) or die (print_r($req->errorInfo()));
                

                header('Location:accueil.php');
                exit();
                
            }
            catch (Exception $e)
            {
                die('Erreur : ' . $e->getMessage());
            }
        }
    }   
    //$_SESSION['ID']
    //INSERT INTO `utilisation` (`idUtilisation`, `debut`, `fin`, `type`, `numIdBoard`, `idMat`) VALUES (NULL, '2020-06-14 16:00:00', '2020-06-14 18:00:00', '0', '2014107', 'rasp1');
    ?>

</body>
</html>

