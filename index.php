<?php
/******************************
 * ****************************
 * Projet CampusID B1 2020
 * Corentin Lizy
 * Site d'emprunt et de 
 * réservation pour campusID
 * ***************************
 * **************************/
session_start();//On démarre une session pour la connexion de l'utilisateur
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusWeb - Authentification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
<body>
<?php
    if (isset($_POST['num']) && isset($_POST['password']))//On vérifie si le nom d'utilisateur et le mot de passe est bien défini pour la connexion
    {
        try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=campusweb;charset=utf8', 'root','root'); //On essaye de rentrer dans la base de données
            $req=$bdd->query('SELECT * FROM membre');//On sélectionne dans la base de données toute les colonnes de la table membre
            while($connexion = $req -> fetch())
            {
                if($connexion['numIdBoard']==$_POST['num'] && $connexion['mdp']==md5($_POST['password']))
                {
                    $req2 = "SELECT * FROM membre WHERE numIdBoard = ".$_POST['num']."";//Si un identifiant et un mot de passe correspondent on selectionne dans la table membre celui qui à le numéro d'idBoard correspondant
                    $req3=$bdd->query($req2);
                    $set_parameter=$req3->fetch();
                    $_SESSION['NAME']=$set_parameter['prenom'].' '.$set_parameter['nom'];//On rentre dans les paramètres de session les différentes variables inscrites dans la table
                    $_SESSION['ID']=$set_parameter['numIdBoard'];
                    $_SESSION['NUM']=$set_parameter['Role'];
                    if($set_parameter['Role']== 0 || $set_parameter['Role'] == 1)//Le rôle 0 est le rôle admin et 1 est le rôle de Laure.
                    {
                        header('Location:admin.php');//Si c'est un admin ou Laure il accède à la page admin.php
                        exit();
                    }
                    else
                    {
                        header('Location:accueil.php');//Sinon accueil.php
                        exit();
                    }

                }
            }
            echo "<h3 style='margin-top:3%; margin-left: 37%; margin-bottom:3%'><span class='badge badge-danger'> Mauvais nom d'utilisateur ou mot de passe veuillez réessayer</h3>";//Si aucun couple identifiant/mdp ne correspond alors on affiche ce message.
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());//Dans le cas où la connexion à la base ne fonctionne pas on affiche une erreur.
        }
    }
    
?>
    <img src="img/logo.png" style="margin-left:39%">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])//Cela signifie que le traitement du formulaire en php est dans le même fichier ?>" method="post" style="margin-left:8%;padding:5%">

    <div class="container">
        <div class="form-row" style="margin-left:33%">
            <div class="form-group col-md-6">
                <label>Numéro IDBoard</label>
                <input type="text" id="num" name="num" placeholder="2015125" class="form-control">
            </div>
        </div>
        <div class="form-row" style="margin-left:33%">

            <div class="form-group col-md-6">
                <label>Mot de Passe</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
        </div>

            <div>
                <button type="submit" name="submit" style="margin-left:41%; margin-bottom:2%; margin-top:2%" class="col-lg-2 btn btn-danger">Se Connecter</button>
            </div>
    </div>

    </form>
</body>
</html>