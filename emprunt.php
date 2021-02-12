<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusWeb - Emprunt</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
<body>


    <img src="img/logo.png" style="margin-left:39%">
    
    <form action=<?php echo "traitEmprunt.php?param=".$_GET['param']//Le formulaire est envoyé sur la page traitEmprunt.php ?> method="post" style="margin-left:8%;padding:5%">
    <?php//Ici tout le code est un formulaire pour demander un emprunt?>
    <div class="container">
        <div class="form-row" style="margin-left:33%">
            <div class="form-group col-md-6">
                <label>Matériel à emprunter</label>
                <?php echo "<img src=\"img/".$_GET['param'].".jpg\" height='300px' width='300px'>"; ?>
            </div>
        </div>
        <div class="form-row" style="margin-left:33%">
            <div class="form-group col-md-6">
                <label>Rappel des dates déjà occuppées</label>
                <?php

                    if (!isset($_SESSION['NAME']))
                    {
                        header('Location:index.php');
                        exit();
                    }
                    else
                    {
                        try
                        {
                            $bdd = new PDO('mysql:host=localhost;dbname=campusweb;charset=utf8', 'root','root');
                            $req=$bdd->prepare('SELECT * FROM utilisation WHERE idMat = :idMat');
                            $req->execute(array(
                                'idMat' => $_GET['param']
                                )) or die (print_r($req->errorInfo()));  
                            while($mat = $req -> fetch()) //Ici on réaffiche les dates d'utilisation
                            {
                                if ($mat['type']==1)
                                {
                                    echo "<p style='border:1px solid black'>Réservé du ".$mat['debut']." jusqu'au ".$mat['fin']."</p>";
                                }
                                else
                                {
                                    echo "<p style='border:1px solid black'>Emprunté du ".$mat['debut']." jusqu'au ".$mat['fin']."</p>";
                                }
                                
                            }
                        }
                        catch (Exception $e)
                        {
                            die('Erreur : ' . $e->getMessage());
                        }
                    }

                ?>
            </div>
        </div>
        <div class="form-row" style="margin-left:33%">

            <div class="form-group col-md-6">
                <label>Date de récupération du matériel</label>
                <input type="text" id="dateDeb" name="dateDeb" placeholder="aaaa-mm-jj" class="form-control">
            </div>
        </div>
        <div class="form-row" style="margin-left:33%">
            <div class="form-group col-md-6">
                <label>Heure de la récupération du matériel</label>
                <select class="form-control" name="heureDeb">
                    <option value="9">9H</option>
                    <option value="10">10H</option>
                    <option value="11">11H</option>
                    <option value="12">12H</option>
                    <option value="13">13H</option>
                    <option value="14">14H</option>
                    <option value="15">15H</option>
                    <option value="16">16H</option>
                    <option value="17">17H</option>
                </select>
            </div>
        </div>
        <div class="form-row" style="margin-left:33%">
        <div class="form-group col-md-6">
            <label>Date de rendu du matériel</label>
            <input type="text" id="dateFin" name="dateFin" placeholder="aaaa-mm-jj" class="form-control">
        </div>
        </div>
        <div class="form-row" style="margin-left:33%">
            <div class="form-group col-md-6">
                <label>Heure de rendu du matériel</label>
                <select class="form-control" name="heureFin">   
                    <option value="9">9H</option>
                    <option value="10">10H</option>
                    <option value="11">11H</option>
                    <option value="12">12H</option>
                    <option value="13">13H</option>
                    <option value="14">14H</option>
                    <option value="15">15H</option>
                    <option value="16">16H</option>
                    <option value="17">17H</option>
                    <option value="18">18H</option>
                </select>
            </div>
        </div>

        <div>
            <button type="submit" name="submit" style="margin-left:41%; margin-bottom:2%; margin-top:2%" class="col-lg-2 btn btn-danger">Demander l'emprunt</button>
        </div>

        <a href="accueil.php" style="margin-left:39%; color:red">Cliquez ici pour revenir à l'accueil</a>
    </div>

    </form>
</body>
</html>