

<div class="proposerfiches" id="proposerfiches">

    <form action="receptionfic.php" method="post" id="upload" enctype="multipart/form-data"> 
        <div class="boutonFermer" onClick="revenir()">X</div>             
        <br/>
        <div class="selecFic arrondi">
        <input id="fichiers" name="fichier[]" type="file" multiple/><br /><br />

        <p style="font-size: 12px;">
            

            <!--<input type="text" name="matiere" placeholder="matière"/>-->

            <select name="matiere">
                <option value="prerentree">Pré-rentrée / info générales</option>
                <optgroup label="Licence 1">
                    <option value="MLJ1E21O" selected>CBI</option>
                    <option value="MLJ2E42O">C2I</option>
                    <option value="MLJ2E41O">Anglais 1</option>
                    <option value="MLJ1E22O">Intro Prog</option>
                    <!--<option value="MLJ1U2O">Prog 1</option>-->
                    <option value="MLJ2E21O">Prog 2</option>
                    <option value="MLJ1U1O">Maths 1</option>
                    <option value="MLJ2U1O">Maths 2</option>
                    <option value="MLJ1UYF">Projet Arith Z/nZ</option>
                    <option value="MLJ1U6C">Bio 1</option>
                    <option value="MLJ2U6C">Bio 2</option>
                    <option value="MLJ1U4O">Methodologie</option>
                    <option value="MLJ2U4O">Culture générale</option>
                    <option value="MLJ2E22O">Num. et log</option>
                    <option value="MLJ1U7C">Eco 1</option>
                    <option value="MLJ2U7C">Eco 2</option>
                    <option value="MLJ1U8C">Physique 1</option>
                    <option value="MLJ2U8C">Physique 2</option>
                    <option value="MLJ1U9C">Socio 1</option>
                    <option value="MLJ2U9C">Socio 2</option>
                    <!--<option value="MLJ1UZF">Projet de Prog 1</option>-->
                    <option value="MLJ2UZF">Projet de Prog 2</option>
                    <option value="MLJ2UYF">Approx. num. Inté.</option>
                </optgroup>
                <optgroup label="Licence 2">
                    <option value="MLJ3E52O">PPE</option>
                    <option value="MLJ3E51O">Anglais 2</option>
                    <option value="MLJ3U6C">Bio 3</option>
                    <option value="MLJ4U6C">Bio 4</option>
                    <option value="MLJ4U6CI">Bio 4 - géné. molécul.</option>
                    <option value="MLJ3U7C">Eco 3</option>
                    <option value="MLJ4U7C">Eco 4</option>
                    <option value="MLJ3U8C">Physique 3</option>
                    <option value="MLJ4U8C">Physique 4</option>
                    <option value="MLK3U1O">Algebre 3</option>
                    <option value="MLK4U1O">Algebre 4</option>
                    <option value="MLK3U2O">Analyse 3</option>
                    <option value="MLK4U2O">Analyse 4</option>
                    <option value="MLK4U4O">Analyse ingé. 1</option>
                    <option value="MLK3BF1">Normes sur RD</option>
                    <option value="MLK3UYF">Normes sur RD +</option>
                    <option value="MLK3U3O">Intro aux probas</option>
                    <option value="MLL3U4O">Probas pour l'info 1</option>
                    <option value="MLL3U3O">BDD</option>
                    <option value="MLL3UAC">Archi</option>
                    <option value="MLL3U1O">Algo</option>
                    <option value="MLL3U2O">Prog impérative</option>
                    <option value="MLL4U1O">POO</option>
                    <option value="MLL4U2O">Projet</option>
                    <option value="MLL4U3O">Systex</option>
                    <option value="MLK4U3O">Env. calc. scienti.</option>
                    <option value="MLL4UBC">Théorie langages</option>
                    <option value="MLL4UAC">Théorie orga.</option>
                    <option value="MLL4UCC">SICG</option>
                    <option value="MLL4UDC">WEB</option>
                    <option value="MLL4UZF">Entreprenariat 1</option>
                    <option value="MLK4UCC">Complé. Math oral</option>
                    <option value="MLK4UYF">Projet: esp. suites</option>
                </optgroup>
                <optgroup label="Licence 3">
                    <option value="MLK5U1T1">Topo. et Calc. diff.</option>
                    <option value="MLK5U2O">Mesure et intégration</option>
                    <option value="MLJ5U6C">Bio 5</option>
                    <option value="MLJ6U6CI">Bio 6</option>
                    <option value="MLJ6UHC">Bio-Informatique</option>
                    <option value="MLK5U71O">Eco 5 - incertain</option>
                    <option value="MLK5U72O">Eco 5 - dyna et croiss</option>
                    <option value="MLK6U71C">Eco 6 - internatio.</option>
                    <option value="MLK6U72C">Eco 6 - publique</option>
                    <option value="MLJ5U8C">Physique 5</option>
                    <option value="MLJ6U8C">Physique 6</option>
                    <!--<option value="MLK5U1O">Algebre 5 - Topologie</option>
                    <option value="MLK5U1O">Algebre 5 - Mes. & inté.</option>-->
                    <option value="MLK6UGC">Algebre 6</option>
                    <option value="MLK5UEC">Struc algébriques</option>
                    <option value="MLK5UAO">Analyse 5</option>
                    <option value="MLK6UEC">Analyse 6</option>
                    <option value="MLK5U4O">Analyse ingé. 2</option>
                    <option value="MLK5UYF">Esp. de Banache</option>
                    <option value="MLK5U5O">Esp. eucl. opti.</option>
                    <option value="MLK6U1O">Esp. de Hilbert</option>
                    <option value="MLK6U3O">Trans. Fourier</option>
                    <option value="MLK5UCO">Maths appliqués</option>
                    <option value="MLK5UFC">Maths et modéli.</option>
                    <option value="MMLL5U4O">Maths pour l'info</option>
                    <option value="MLL6U4C">Trait. num. données</option>
                    <option value="MLK6U2O">Méthodes num</option>
                    <option value="MLK6U5O">Logiciels stats</option>
                    <option value="MLK6U4O">Stats inféren.</option>
                    <option value="MLK6UFC">Sys dynamiques</option>
                    <option value="MLL6UDC">Sys num com</option>
                    <option value="MLK5U3O">Probas 5</option>
                    <option value="MLL5U3O">Algo avancé</option>
                    <option value="MLL5U1O">Génie logiciel</option>
                    <option value="MLL5U2O">POO avancée</option>
                    <option value="MLL5U5O">Reseaux</option>
                    <option value="MLL6UCC">Reseaux avancés</option>
                    <option value="MLL5UAC">Prog Unix</option>
                    <option value="MLL5UBC">BDD avancée</option>
                    <option value="MLL6U3C">IA</option>
                    <option value="MLL5UCO">ASCI</option>
                    <option value="MLL6UBC">Image</option>
                    <option value="MLL4U2O">Projet</option><!--MLL6E13O-->
                    <option value="MLL6U2O">Stage</option>
                    <option value="MLL6UEC">Gest fin + cont gest</option>
                    <option value="MLL6U5C">Ana. eco. strat. entrep.</option>
                    <option value="MLL6U1O">Préprofessionnalisation</option>
                    <option value="MLL5UDO">Gestion entreprise</option>
                    <option value="MLL6E11O">Communication</option>
                    <option value="MLL6E12O">Anglais 3</option>
                </optgroup>
                
            </select>

            <select name="annee">
                <?php
                    for($i = 2000; $i<=((int) date("Y")); $i++){
                        print('<option value="'. $i .'">'. $i .'</option>');
                    }
                ?>
            </select>


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

                <!--Corrigé: <input type="checkbox" name="corrige"/>-->
            
                <label for="corrige">Corrigé: </label><input type="checkbox" name="corrige" id="corrige" />
        </p>

        </div>
            
        <progress value="0" class="barreChargement" id="barreChargement" onchange="termine()"></progress>

        <br/>
        <!--<input class="bouton" type="button" id="submit" value="Envoyer" />-->
        <input class="bouton" id="sub" type="submit" value="Envoyer" class="submit" />

    </form>

    <!--
    <form enctype=multipart/form-data>
        <input name=fichier type=file />
        <input type=button value=Envoyer le fichier />
    </form>
-->
    
    

    <form action="mailto:desfichesdescartes@gmail.com" method="post" enctype="multipart/form-data" style=" float: right;">
        <input class="bouton" type="submit" value=" ? " id="mail"/>
    </form>

    <p id="logs" style="font-size: smaller;color: #ffffff80;">

    </p>


    <script>
        $("#upload").on('submit', (function(e) {
            e.preventDefault();
            //e.stopPropagation();
            //stopPropagation();
            $.ajax({
                url: "receptionfic.php",
                type: "POST",
                xhr: function() { // xhr qui traite la barre de progression
                    myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // vérifie si l'upload existe
                        myXhr.upload.addEventListener('progress', afficherAvancement, false); // Pour ajouter l'évènement progress sur l'upload de fichier
                    }
                    return myXhr;
                },
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType : 'html',
                success: function(code_html, statut){
                    $("#logs").html(code_html);
                    var mail = document.getElementById("mail");
                    mail.style.opacity = "0";
                    var bouton = document.getElementById("sub");
                    console.log(bouton);
                    bouton.setAttribute("value", "Terminé");
                    bouton.setAttribute("onClick", "recharger()");
                    //bouton.setAttribute("type", "submit");
                    bouton.setAttribute("id", "aaaaaaa");
                },
            });
            //return false; 
        }));

        function afficherAvancement(e) {
            if (e.lengthComputable) {
                $('progress').attr({
                    value: e.loaded,
                    max: e.total
                });
            }
            if (e.loaded == e.total) {
                var bouton = document.getElementById("sub");
                console.log(bouton);
                bouton.setAttribute("value", "Finalisation...");
            }
        }

        function recharger() {
            //window.location.reload(true);
            //window.location.href="index.php";
            history.go(0);
        }

        
    </script>
    



    

</div>