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
    <h1 style="margin-top:3%; text-align:center"><span class="badge badge-danger"> <?php echo $_SESSION['NAME']; ?>, bienvenue sur le site de réservation et d'emprunt de CampusID</span></h1>
    <h2 style="text-align:center"><span class="badge badge-danger" style="margin-top:4%;margin-bottom:4%">Voici le matériel disponible à l'utilisation</span></h2>
    <?php
        $i = 0;
        $j = 0;
        if (!isset($_SESSION['NAME']))//Si l'utilisateur n'est pas connecté, alors il retournera sur la page de connexion
        {
            header('Location:index.php');
            exit();
        }
        else
        {
            try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=campusweb;charset=utf8', 'root','root');
                $req=$bdd->query('SELECT * FROM materiel');//Connexion à la base de donnée et récupération de toute la table materiel
                while($mat = $req -> fetch())
                {
                    echo "<div class='container' style='border:1px solid black; padding:15px'>
                          <div class='row'>
                          <div class='col' style='border-right:1px solid black;'><img src = 'img/".$mat['idMat'].".jpg' height='300' width='300'></div>
                          <div class='col'><h4><span class='badge badge-dark'>".$mat['nomMat']."</span><br><br>".$mat['descMat']."</h4></div>
                          <div class='w-100'></div>";
                    
                    if($mat['typeUtilisation'] == 1)
                    {
                        echo "<div class='col' style = 'margin-top:2%'><button onclick=\"window.location.href = 'emprunt.php?param=".$mat['idMat']."'\" class='col-lg-3 btn btn-danger' style = 'width:150px'>Emprunt</button></div>";
                    }
                    else if($mat['typeUtilisation'] == 2)
                    {
                        echo "<div class='col' style = 'margin-top:2%'><button onclick=\"window.location.href = 'reservation.php?param=".$mat['idMat']."'\" class='col-lg-3 btn btn-danger'>Reservation</button></div>";
                    }
                    else
                    {
                        echo "<div class='col' style = 'margin-top:2%'><button onclick=\"window.location.href = 'emprunt.php?param=".$mat['idMat']."'\" class='col-lg-3 btn btn-danger'>Emprunt</button>
                              <button onclick=\"window.location.href = 'reservation.php?param=".$mat['idMat']."'\" class='col-lg-3 btn btn-danger'>Reservation</button></div>";
                    }
                    //Toute les lignes de code ci dessus permettent d'afficher automatiquement le matériel disponible à l'utilisation 
                    $req2=$bdd->prepare('SELECT * FROM utilisation WHERE idMat = :idMat');//Ici on vient séléctionner dans utilisation le matériel ayant le même idMat afin d'afficher les dates déjà occuppées
                            $req2->execute(array(
                                'idMat' => $mat['idMat']
                                )) or die (print_r($req->errorInfo()));  
                            echo "<div class='col' style='margin-top:2%'><h5><span class='badge badge-danger'>";
                            while($use = $req2 -> fetch())
                            {
                                if ($use['type']==1)
                                {
                                    echo "Réservé du ".$use['debut']." jusqu'au ".$use['fin']."<br>";
                                }
                                else
                                {
                                    echo "Emprunté du ".$use['debut']." jusqu'au ".$use['fin']."<br>";
                                }
                            }
                    echo "</h5></span></div></div></div>";
                }
            }

            catch (Exception $e)
            {
                die('Erreur : ' . $e->getMessage());
            }
        }
    ?>
    

</body>
</html>