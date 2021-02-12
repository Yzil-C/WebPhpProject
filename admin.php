<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusWeb - Accueil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
<body>
    <img src="img/logo.png" style="margin-left:37%">
    <h1 style="margin-top:3%; text-align:center"><span class="badge badge-danger"> <?php echo $_SESSION['NAME']; ?>, bienvenue sur la gestion du site de réservation et d'emprunt de CampusID</span></h1>
    <h2 style="margin-top:4%;text-align:center;margin-bottom:4%"><span class="badge badge-danger">Voici les utilisations en cours ou à venir</h2>
    <?php

        if ($_SESSION['NUM']==2)
        {
            if(!isset($_SESSION['NAME']))
            {
                header('Location:index.php');//Si l'utilisateur n'est pas connecter il est redirigé sur la page de connexion
                exit();
            }
            else
            {
                header('Location:accueil.php');//Si l'utilisateur n'est pas connecter en tant qu'admin, il est rediriger sur la page accueil.php
                exit();
            }
        }
        else
            {
                try
                {
                    $bdd = new PDO('mysql:host=localhost;dbname=campusweb;charset=utf8', 'root','root');
                    /**********************************************************************************
                     * Tout ce code permet de réafficher les utilisations courantes, futures ou passées
                     * pour que l'admin puisse les gérer.
                     * Il a le choix entre supprimer la réservation car elle n'est pas faisable ou 
                     * renvoyer un rappel sou la forme d'un mail (Fonctionnalité non présente dans
                     * le programme)
                     *********************************************************************************/
                    $req=$bdd->query('SELECT * FROM utilisation INNER JOIN membre ON utilisation.numIdBoard = membre.numIdBoard');  
                    while($res = $req -> fetch())
                    {
                        echo "<div class='container' style='border:1px solid black; padding:15px'>
                              <div class='row'>
                              <div class='col' style='border-right:1px solid black;'><img src = 'img/".$res['idMat'].".jpg' height='300' width='300'></div>
                              <div class='col'><h4><span class='badge badge-dark'>".$res['prenom']." ".$res['nom'].", Numéro : ".$res['numIdBoard']." </span><br><br></h4>";
                              if ($res['type']==0)
                              {
                                  echo "<h5>Reservé du ".$res['debut']." au ".$res['fin']."</h5>";
                              }
                              else
                              {
                                  echo "<h5>Emprunté du ".$res['debut']." au ".$res['fin']."</h5>";
                              }

                              echo "</div><div class='w-100'></div>";

                              echo "<div class='col' style = 'margin-top:2%'><button onclick=\"window.location.href = 'suppr.php?param=".$res['idUtilisation']."'\" class='col-lg-4 btn btn-danger'>Supprimer</button>
                              <button onclick=\"window.location.href = 'admin.php'\" class='col-lg-4 btn btn-danger'>Envoyer un Rappel</button></div>
                              <div class='col'></div></div></div>";
                    }
                }
                catch (Exception $e)
                {
                    die('Erreur : ' . $e->getMessage());
                }
            }

                ?>
    <!--<button onclick="window.location.href = 'reservation.php'" class="col-lg-2 btn btn-danger">Réservation</button>
    <button onclick="window.location.href = 'emprunt.php'" class="col-lg-2 btn btn-danger">Emprunt</button>-->

</body>
</html>