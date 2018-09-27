<div class="details_page" id="details_page">
    <img class="details_background" src="uploads/demo_mini.jpg">
    <div class="details_bouton_fermer" onClick="fermerDetails()">Mais virez moi cette page</div>
    <table>
        <tr>
            <td valign="top" style="padding: 10px;">
                <img src="demo_mini.jpg" alt="s'à bheug" style="border: 1px solid #e4e4e4" id="details_miniature">
                <br>
                <a href="" target="_blank" class="details_bouton_ouvrir_fic" id="details_bouton_ouvrir_fic">Ouvrir</a>
            </td>
            <td style="padding-left: 10px;width: 100%;">
                <p class="details_titre" id="details_titre">Inconnu</p>
                <p class="details_matiere" id="details_matiere">Inconnu</p>

                <p class="details_texte" id="details_texte"></p>
                
            </td>
        </tr>
    </table>
</div>
<script>
    //var param = 'l=' + $('#ref').val();
    //$('#r').load('http://www.proverbes.php',param);

    function ouvrirDetails(id_fic, nom, matiere, miniature, url){
        <?php
            if($navigateur == "Firefox"){
                ?>
                    var caseFic = document.getElementsByClassName("caseFic");
                    var i = 0;
                    for(i = 0; i < caseFic.length; i++){
                        caseFic[i].style = "transform: translate3d(0, 0, 0px);";
                    }
                <?php
            }
        ?>
        var select = document.getElementById("details_page");
        select.style.zIndex = "9999";
        select.style.opacity = "1";
        var select = document.getElementById("page");
        select.style = "filter: blur(10px) brightness(0.3);";
        var select = document.getElementById("background");
        select.style = "filter: blur(10px) brightness(0.3);";
        $.post('details.php', { id_fic: id_fic, <?php if($id_session == "hacker_du_93") print("pseudo: '". $_SESSION['pseudo'] ."', mdp: '". $_SESSION['mdp'] ."'"); ?>}, function(data) {
            $('#details_bouton_ouvrir_fic').attr('href', url)
            $('#details_titre').html(nom);
            $('#details_matiere').html(matiere);
            $('#details_miniature').attr('src', miniature);
            $('.details_background').attr('src', miniature);
            $('#details_texte').html(data);
            
            //alert(data);
        });
    }
    function fermerDetails(){
        var select = document.getElementById("details_page");
        select.style.zIndex = "0";
        select.style.opacity = "0";
        var select = document.getElementById("page");
        select.style = "filter: blur(0px);";
        var select = document.getElementById("background");
        select.style = "filter: blur(0px);";
        
    }
    <?php
        if($id_session == "hacker_du_93"){
            ?>
                function envoyerDetails(id_fic) {
                    var texte = document.getElementById("details_infos_sup").innerHTML;
                    console.log(document.querySelectorAll('#details_infos_sup')[0].childNodes)
                    var active = document.getElementById("details_afficher_checkbox").checked;
                    $.post('details.php', { id_fic: id_fic, <?php if($id_session == "hacker_du_93") print("pseudo: '". $_SESSION['pseudo'] ."', mdp: '". $_SESSION['mdp'] ."'"); ?>, texte: texte, active: active}, function(data) {
                        $('#details_texte').html(data);
                        
                        //alert(data);
                    });
                }
            <?php
        }
    ?>
    //ouvrirDetails(145, "htdr", "Le CBI", "video.gif");

</script>