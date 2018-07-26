<?php
//include_once("test_session.php");
//include_once("navigateur.php");
//include_once("bdd.php");
?>

<div class="page_fichier_externe" id="page_fichier_externe">
    <h2 class="t_admin">Ajouter un fichier sans l'uploader sur le site</h2>
    <p style="text-align: center; color: red; font-size: smaller;">Cette fonction n'est à utiliser que dans des cas très particuliers, demandez l'avis des autres dans #admin-dfdc avant de l'utiliser !</p>
    <br>
    <div class="details_bouton_fermer" onClick="fermerFichierExterne()">Mais virez moi cette page</div>

    URL: 
    <input style="width: 500px;" type="text" name="url" placeholder="URL complète (avec le http://)" />
    <br/>

    Nom: 
    <input style="width: 400px;" type="text" name="nom" placeholder="Exemple: Cours 10 (2008) SAX, XML" />
    <br/>
    

    Année: 
    <select name="annee" id="preselection" onchange="hide()">
        <?php
            for($i = 2000; $i<=((int) date("Y")); $i++){
                print('<option value="'. $i .'">'. $i .'</option>');
            }
        ?>
    </select>
    

    <br/>
    Type: 
    <select name="type">
        <option value="annale">annale</option>
        <option value="cours">cours</option>
        <option value="TD">TD</option>
        <option value="TP">TP</option>
        <option value="fiche">fiche</option>
        <option value="tuto">tuto</option>
        <option value="exempleTravail">exemple de travail</option>
        <option value="autre">autre</option>
    </select>
    <br>
    Corrigé: <input type="checkbox" name="corrige" id="corrige"/>
    <br>

    
    Matière:
    <select name="matiere">
        <option value="prerentree">Pré-rentrée / info générales</option>
        <?php
            
            $reqMat = $bdd->query("SELECT code, nom, niveau FROM matiere");


            while ($donnees_L1 = $reqMat->fetch()){
                $cochee = "";
                if($donnees_L1["code"] == $donnees["matiere"]){
                    $selectionne = ' selected';
                } else {
                    $selectionne = '';
                }
                print('<option value="'. $donnees_L1["code"] .'"  '. $selectionne .'/>' . $donnees_L1["nom"] . "</option>");
            } 
        ?>
        
    </select>

    <br><br><br><div class="boutonValider" onClick="envoyerFichierExterne()">Valider</div>
    <?php /*
    $url = 'http://mediabox.parisdescartes.fr/medias/NDYyNzA%3D/169538564Video01.mp4';
    print("<pre>");
    print_r(get_headers($url));
    print("</pre>");
    $match = "";
    preg_match("#(\d+)#iu", get_headers($url)[4], $match);
    $match = (int) $match[1];
    print($match);
    print("<br>");
    $lenomdecefichier = "";
    preg_match("#(\w+\.\w+)$#iu", $url, $lenomdecefichier);
    $lenomdecefichier = $lenomdecefichier[1];
    print($lenomdecefichier);
    */?>

    <div id="resultat" ></div>


</div>

<script>
    //var param = 'l=' + $('#ref').val();
    //$('#r').load('http://www.exemple.php',param);

    function ouvrirFichierExterne(){
        var select = document.getElementById("page_fichier_externe");
        select.style.zIndex = "9999";
        select.style.opacity = "1";
        var select = document.getElementById("page");
        select.style = "filter: blur(10px) brightness(0.3);";
        var select = document.getElementById("background");
        select.style = "filter: blur(10px) brightness(0.3);";
    }
    function envoyerFichierExterne(url, nom, annee, type, corrige, matiere){
        $('#resultat').html('<img src="loader.gif" alt="Chargement ..." style="margin:  auto;display:  block;height: 30%;width: 30%;"/>');
        $.post('fichier_externe.php', { url: $( "input[name=url]" ).val(), 
                                            nom: $( "input[name=nom]" ).val(), 
                                            annee: $( "select[name=annee]" ).val(), 
                                            type: $( "select[name=type]" ).val(), 
                                            corrige: $( "input[name=corrige]" ).val(), 
                                            matiere: $( "select[name=matiere]" ).val(), 
                                            <?php print("pseudo: '". $_SESSION['pseudo'] ."', mdp: '". $_SESSION['mdp'] ."'"); ?>}, function(data) {
            $('#resultat').html(data);
            
            //alert(data);
        });
    }
    function fermerFichierExterne(){
        var select = document.getElementById("page_fichier_externe");
        select.style.zIndex = "0";
        select.style.opacity = "0";
        var select = document.getElementById("page");
        select.style = "filter: blur(0px);";
        var select = document.getElementById("background");
        select.style = "filter: blur(0px);";
        
    }
    //ouvrirDetails(145, "htdr", "Le CBI", "video.gif");

</script>
