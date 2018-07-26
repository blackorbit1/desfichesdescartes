<?php
include_once("bdd.php");
include_once("logs.php");
$id_session = "hacker_du_92";

function formatBytes($bytes, $precision = 2) { 
    $units = array('bytes', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 

if(isset($_POST["id_fic"])){
    if(isset($_POST["pseudo"]) && isset($_POST["mdp"]) && isset($_POST["texte"]) && isset($_POST["active"])){
        $req = $bdd->prepare('SELECT id FROM ventilateur WHERE old_u_u_s_e_r = ? and old_m_m_d_p__ = ?'); // Envoi de la requete à la base de données
        $req->execute(array($_POST["pseudo"], $_POST["mdp"]));
        $donnees = $req->fetch();
        $id_session = $donnees["id"];

        //print_r($_POST);
        //print((bool) $_POST["active"]);

        if($id_session == "hacker_du_93"){
            $texte = preg_replace("#\n(.*)#iu", "$1", ($_POST["texte"]));
            //str_replace('<br />', "\n", $texte); 

            //$texte = preg_replace("#^(?:<br>|<br />)*([^<>][a-zA-Z0-9]+)#iusU", "$1", nl2br($_POST["texte"]));
            //$texte = preg_replace("#^(?:<br>|<br />|[ \s\r\t\n])*([^<>]([a-zA-Z0-9]))#iusU", "$1", nl2br($texte));
            
            $texte = preg_replace("#<div>(.+)</div>#iuU", "<br>$1", ($texte));
            $req = $bdd->prepare('UPDATE fichiers SET details = :texte, details_active = :active  WHERE id = :id_fic');
            if($req->execute(array(
                'texte' => $texte,
                'active' => ($_POST["active"] == "true")?1:0,
                'id_fic' => $_POST["id_fic"],
            ))){
                ?><div class="deleted" style="text-align: center; border-radius: 0px;background-color: rgba(9, 255, 0, 0.61);">La modification a été un succes liot'nhan</div><br/><?php
                logs($_POST["pseudo"], "Modification/Ajout de détails. active = ". $_POST["active"]. " /// id fichier = ". $_POST["id_fic"] ." /// texte = ". $texte);
            } else {
                ?><div class="deleted" style="text-align: center; border-radius: 0px;">noooo ça bug de partout ! (signalez svp)</div><br/><?php
            }

        } else {
            logs($_POST["pseudo"], "Ou une personne non admin a tenté d'envoyer / supprimer des détails.active = ". $_POST["active"]. " /// id fichier = ". $_POST["id_fic"] ." /// texte = ". $texte);
        }

        
    }
    $req = $bdd->prepare('SELECT id, nom, nom_fichier_old, taille_fichier, date_envoi, niveau, annee, type, corrige, details, details_active FROM fichiers WHERE id = ?'); // Envoi de la requete à la base de données
    $req->execute(array((int) $_POST["id_fic"]));
    $donnees = $req->fetch();
    if($donnees["niveau"] == "L1_math_info"){
        $niveau = "L1";
    } elseif($donnees["niveau"] == "L2_math_info"){
        $niveau = "L2";
    } elseif($donnees["niveau"] == "L3_math_info") {
        $niveau = "L3";
    } else {
        $niveau = "inconnu";
    }
    $texte = nl2br(($donnees["details"]));
    

    ?>
    <p class="details_texte_zone_propriete">
        <span class="details_texte_propriete">Nom original : </span><?php print($donnees["nom_fichier_old"]); ?><br>
        <span class="details_texte_propriete">Date d'envoi : </span><?php print($donnees["date_envoi"]); ?><br>
        <span class="details_texte_propriete">Taille : </span><?php print(formatBytes($donnees["taille_fichier"])); ?><br>
        <br>
        <?php /*<span class="details_texte_propriete">Niveau : </span><?php print($niveau); ?><br>*/ ?>
        <span class="details_texte_propriete">Année : </span><?php print($donnees["annee"]); ?><br>
        <span class="details_texte_propriete">Type : </span><?php print($donnees["type"]); ?><br>
        <span class="details_texte_propriete">Corrigé : </span><?php print($donnees["corrige"]?"oui":"non"); ?><br>
        <br>
    </p>
    <?php
    //print($donnees["details_active"]);
    $details_active = $donnees["details_active"]; 

    if(isset($_POST["pseudo"]) && isset($_POST["mdp"])){
        $req = $bdd->prepare('SELECT id FROM ventilateur WHERE old_u_u_s_e_r = ? and old_m_m_d_p__ = ?'); // Envoi de la requete à la base de données
        $req->execute(array($_POST["pseudo"], $_POST["mdp"]));
        $donnees = $req->fetch();
        $id_session = $donnees["id"];
    }
    if($id_session == "hacker_du_93"){
        ?>
            <p id="details_infos_sup" class="details_texte_zone_infos_sup_admin" contenteditable="true">
                <?php print($texte); ?>
            </p>
            <input type="checkbox" name="details_afficher_checkbox" id="details_afficher_checkbox" <?php if($details_active) print("checked"); ?>/><label style="color: red;" for="details_afficher_checkbox">Afficher</label>
            <div class="details_envoyer" onClick="envoyerDetails('<?php print($_POST["id_fic"]); ?>')">Envoyer</div>
        <?php
    } elseif($texte != "" && $details_active){
        function convertisseurLiensImages($post) {
            $MY_MARKER="²²²²²²"; // Define the marker here
        
            /**
             * Converti les images
             */
            $pattern = '/(https?:\/\/[a-z0-9\-\.\/\_]+\.(?:jpe?g|png|gif|webp|apng))/Ui';
            $replace = '<img src="²²²²²²$1²²²²²²">'; // Use it here...
            $postImages = preg_replace($pattern,$replace,$post);

            //print(htmlentities($postImages));

            //print("<br>----------<br>");
        
            /**
             * Converti les urls
             */
            $pattern = '/(?<!²²²²²²)(https?:\/\/[a-z0-9\-\.\/\_]+)(?:\S|$)(?!²²²²²²)/i';//...here
            $replace = '<a href="$1">$1</a><';
            $postUrl = preg_replace($pattern,$replace, $postImages);

            //print(htmlentities($postUrl));

            /**
             * Vire les marqueurs
             */
            $postUrl = str_replace('²²²²²²', '', $postUrl);
        
            return $postUrl;
        }
        //$texte = preg_replace('/(?:https?|ftp):\/\/(?:[\w~%?=,:;+\#@.\/-]|&amp;)+(?<!\.png)/m', '<a target="_blank" class="lienactif" href="$0">$0</a>', $texte);
        $texte = convertisseurLiensImages($texte);
        $texte = preg_replace('/(\S+@\S+\.\S+)/','<a class="mail" href="mailto:$0">$0</a>',$texte)
        ?>
            <p id="details_infos_sup" class="details_texte_zone_infos_sup">
                <?php print($texte); ?>
            </p>
        <?php
    }
    
    
}

?>

<?php /*
<p class="details_texte" id="details_texte">
    <span class="details_texte_propriete">Nom original : </span><span id="details_nom_original">Test</span><br>
    <span class="details_texte_propriete">Date de mise en ligne : </span><span id="details_date_mise_ligne">Test</span><br>
    <span class="details_texte_propriete">Taille : </span><span id="details_taille"></span><br>
    <br>
    <span class="details_texte_propriete">Niveau : </span><span id="details_niveau">Test</span><br>
    <span class="details_texte_propriete">Année : </span><span id="details_annee">Test</span><br>
    <span class="details_texte_propriete">Type : </span><span id="details_type">Test</span><br>
    <span class="details_texte_propriete">Corrigé : </span><span id="details_corrige">Test</span><br>
    <br>
    <span id="details_infos_sup">TestTestTest</span>
</p>
*/ ?>