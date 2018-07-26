<?php
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("logs.php");

if (1){
    $action = "A tenté d'acceder à la page d'ajout d'avis de recherche (obsolete)";
    logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
    header("Location: index.php");
    exit; //ou die, c'est pareil
}

if ($id_session == "hacker_du_93"){
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="feedbacks2.css" >
        <link rel="stylesheet" href="indexold.css" >
        <link rel="icon" type="image/png" href="favicon2.png" />
        <meta name="theme-color" content="#6cbbff">
        <meta name="msapplication-TileColor" content="#6cbbff">
        <meta name="msapplication-TileImage" content="iconmetrowin10.png">
        <meta name="application-name" content="DFDC Avis recherche">
        <title>Avis de recherche</title>
        <meta name="description" content="Janisek aime le bordel" />
    </head>

    <body>
        <background></background>
        <div class="sousPage">
            <?php include_once("bande_session.php"); if($id_session == "hacker_du_93") print("<br style='line-height: 24px;'/>") ?>
            <a class="nomSite" href="index.php"><img src="logo.png"></a>
            <div class="page">
                <div class="surPageBlanche haut">
                    <p class="proposerFiche" style="font-size: 25px;">
                        Lancer un avis de recherche
                    </p>
                </div>
                <div <?php if(get_browsername() == "Safari"){ print('class="surPageTransparenteSaf bas"'); } else print('class="surPageTransparente bas"')  ?>>                    
                    <br/>
                    <?php
                    if(isset($_POST) and array_key_exists("message", $_POST)){
                        //print("<pre>"); print_r($_POST); print("<pre>");
                        //print($screen_dim);

                        $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
                        $req = $bdd->prepare('INSERT INTO avis_recherche(auteur, importance, message, date) VALUES(:auteur, :importance, :message, NOW())');
                        $req->execute(array(
                            "auteur" => $_SESSION['pseudo'],
                            "importance" => htmlspecialchars($_POST['importance']),
                            "message" => htmlspecialchars($_POST['message'])
                        ));
                        $req->closeCursor();
                        ?><div class='success'>Avis de recherche lancé !</div><br/><?php
                    }
                    ?>
                    <br/>
                    <form action="" method="post" enctype="multipart/form-data">
                        <textarea class="bouton" style="resize: none; font: 15px arial, sans-serif;" name="message" rows=10 cols=100 placeholder=""></textarea><br />
                        <select name="importance">
                            <option value="0">On s'en fout</option>
                            <option value="1">Ca serait l'ideal</option>
                            <option value="2">Si vous avez le temps</option>
                            <option value="3">important</option>
                            <option value="4">Très important</option>
                            <option value="5">Critique</option>
                        </select>
                        <br/>
                        <br/>
                        <br/>
                        <input class="bouton" type="submit" value="Envoyer" />
                    </form>


                    
                    
                </div>
            </div>
        </div>

    </body>
</html>

<?php } else {
    $action = "Une personne non administrateur a tenté d'acceder à la page d'avis de recherche";
    $bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("utilisateur" , NOW(), "'. htmlentities($_SERVER["REMOTE_ADDR"], ENT_QUOTES) .'", "'. $navigateur .'" , "'. $action .'")');
    
    header('Location: /index.php');
}
?>
