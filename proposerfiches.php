

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
                <optgroup label="M1 info">
                    <option value="MMC1E11">Prog avancée C++</option>
                    <option value="MMC1E12">Complexité algo</option>
                    <option value="MMC1E13">Réseaux TCP/IP</option>
                    <option value="MMC1E14">Admin Sys Unix/Linux</option>
                    <option value="MMC1E15">UML Design Patterns</option>
                    <option value="MMC1E21">Découverte des parcours</option>
                    <option value="MMC1E23">Anglais</option>
                    <option value="MML1E31">Optimisation</option>
                    <option value="MMC1E25">Prog logique</option>
                    <option value="MMC1E31">Trait. Signal Image</option>
                    <option value="MMC1E32">Init analyse données</option>
                    <option value="MMC1E33">Optimisation  IA</option>
                    <option value="MMC1E34">Intro reco. formes</option>
                    <option value="MMC1E35">Repr. connais. raiso.</option>
                    <option value="MMC1E36">Sécu sys info & comm</option>
                    <option value="MMC2E11">Internet WEB SOA</option>
                    <option value="MMC2E12">BDD avancées</option>
                    <option value="MMC2E13">Appli J2EE, EJB, JMS</option>
                    <option value="MMC2E21">Projet</option>
                    <option value="MMC2E22">Management projet</option>
                    <option value="MMC2E23">Droit info & prop indu</option>
                    <option value="MMC2E31">Agents intelligents</option>
                    <option value="MMC2E32">Apprentissage auto</option>
                    <option value="MMC2E33">Analyse & fouille de données</option>
                    <option value="MMC2E34">Conception réseaux</option>
                    <option value="MMC2E35">Analyse d'images</option>
                    <option value="MMC2E36">Raisonnement non monotone</option>
                    <option value="MMC2E37">Réseaux & sys multimédia</option>
                    <option value="MMK2E26">Théorie de l'information</option>
                </optgroup>
                <optgroup label="M2 info">
                    <option value="MME3E14">Admin sécu réseaux et sys</option>
                    <option value="MMF3E33">Aide à la décision</option>
                    <option value="MMF3E11">Analyse images (bases)</option>
                    <option value="MMF3E13">Analyse images (complém.)</option>
                    <option value="SRS13">Anglais</option>
                    <option value="MMC3MA">Anglais com. entreprise</option>
                    <option value="MMD3E13">Apprentissage orienté agent</option>
                    <option value="MMD3E31">Apprentissage non supervisé</option>
                    <option value="MMD3E32">Apprentissage supervisé</option>
                    <option value="MMD3E25">Argumentation computa.</option>
                    <option value="MMF3E62">Atelier Cap Emploi</option>
                    <option value="SRS17">Conception soluces</option>
                    <option value="MMIA352">Conférences séminaires</option>
                    <option value="MLJ5U6C">Conférences pro</option>
                    <option value="MLJ5U6C">Construction projet</option>
                    <option value="MMF3E53">Contenu droit responsa.</option>
                    <option value="MMD3E35">Data mining et applis.</option>
                    <option value="MME3E27">Détect. méchants dans réseaux</option>
                    <option value="SRS18">Dev & mise en oeuvre</option>
                    <option value="MMF3E35">Doss. médical & interopé.</option>
                    <option value="SRS16">Élab. cahier des charges</option>
                    <option value="MMF3E34">Estimation, détection</option>
                    <option value="MMF3E73">Etude de texte</option>
                    <option value="MME3E13">Fondmnt. sécu & crypto</option>
                    <option value="MMF3E12">Géométrie algorithmique</option>
                    <option value="MMJ3MJ">Imagerie 3D</option>
                    <option value="MMJ3MK">Imagerie Biomédicale</option>
                    <option value="MME3E28">Ingé réseaux & e-santé</option>
                    <option value="MME3E11">Internet & admin TCP/IP</option>
                    <option value="MMF3E21">Numérisation des documents</option>
                    <option value="MMD3E21">Lang. de com agent & dialogue</option>
                    <option value="MMIP18">Langue</option>
                    <option value="MMD3E22">Logique computationnelle</option>
                    <option value="MMIA353">Méthodo. de la recherche</option>
                    <option value="MMD3E33">Modèles de mélanges</option>
                    <option value="MMD3E34">Modèles de mélanges par bloc</option>
                    <option value="MMD3E23">Négociation automatisée</option>
                    <option value="MMF3E32">Ontologie & web sémantique</option>
                    <option value="MMF3E24">Parole</option>
                    <option value="MMD3E24">Planif mono + multi agents</option>
                    <option value="MME3U4">Projet de développement</option>
                    <option value="MMF3E31">Réseaux blabla objets</option>
                    <option value="MMD3E26">Satisfaction des contraintes</option>
                    <option value="MME3E25">Sécurité DRSFEOC</option>
                    <option value="MME3E26">Sécurité DRDMEDSIEN(CC)</option>
                    <option value="MME3E33">Séminaires et veille techno</option>
                    <option value="MMF3E43">Services web</option>
                    <option value="MMF3E22">Séquences vidéo</option>
                    <option value="MMF3E23">Texte</option>
                    <option value="MMD3E14">Théorie de la décision</option>
                    <option value="MMF3E72">Travail bibliographique</option>
                    <option value="MMF3E41">Veille stratégique & Sécu mobile</option>
                    <option value="MMD3E36">Visualisation</option>
                    <option value="MMD4U1">STAGE</option>
                </optgroup>
                <optgroup label="M1 maths">
                    <option value="MML1E12">Tests</option>
                    <option value="MML1E11">Estimation</option>
                    <option value="MLK5UAO">Analyse de données 1</option>
                    <option value="MMK1E13">Analyse de Fourier</option>
                    <option value="MMK1E12">Analyse fonctionnelle</option>
                    <option value="MML1E21">Programmation</option>
                    <option value="MLL3U3O">BDD</option>
                    <option value="MML3E32">Epidémiologie</option>
                    <option value="DETERM1">Propagation d’épidémies 1</option>
                    <option value="MML1E51">Anglais</option>
                    <option value="MMK1E11">Proba avancées</option>
                    <option value="MML1E31">Optimisation</option>
                    <option value="MML1E34">Modé dét & application à la bio</option>
                    <option value="MMK2E26">Théorie de l'information</option>
                    <option value="MML1E32">Classification</option>
                    <option value="MMK2E23">Modèles linéaires</option>
                    <option value="MMK2E22">Séries temporelles</option>
                    <option value="BigData">Big Data</option>
                    <option value="MML2E14">Analyse de données 2</option>
                    <option value="MML3E15">Stat pr génétique & génomique</option>
                    <option value="DETERM2">Propagation d’épidémies 2</option>
                    <option value="MML2E21">Etude de cas</option>
                    <option value="MMK2E11">Statistiques</option>
                    <option value="MMK2E21">Chaînes de Markov</option>
                    <option value="MMK2E13">Méthodes vari. et EDP</option>
                    <option value="MMK2E12">Distri. & théo. échantillonnage</option>
                    <option value="MMK2E14">Optimisation sous contrainte</option>
                    <option value="MMK2E25">Bases pour traitement d'image</option>
                    <option value="MML3E51">Atelier Cap Emploi</option>
                    <option value="MMK2U3">Projet tutoré</option>
                </optgroup>
                <optgroup label="M2 maths">
                    <option value="AppGDim">Apprentissage gd. dimension</option>
                    <option value="MML3E23">Algo stochastiques</option>
                    <option value="MML3E11">Stats non paramétrique</option>
                    <option value="MML3E52">SAS</option>
                    <option value="Recueil">Recueil données WEB</option>
                    <option value="MML3E12">Survie !!!</option>
                    <option value="DETERM3">Propagation d’épidémies 3</option>
                    <option value="MMIMEco1">Eco, théorie des jeux</option>
                    <option value="MMIMEco2">Eco, incitations</option>
                    <option value="MML3U4">Projet tutoré IMSV</option>
                    <option value="OptiDet">Opti déterministe</option>
                    <option value="MML1E32">Classification</option>
                    <option value="MMK3E11">Modé dét & application à la bio</option>
                    <option value="MVTB">Brownien & Stochastique</option>
                    <option value="POISSON">Poissoniens et Markoviens</option>
                    <option value="MMK3E54">Imagerie biomédicale</option>
                    <option value="VISION">Vision par ordi et géo</option>
                    <option value="PBINV">Problèmes inverses</option>
                    <option value="PERCEP">Perception, acquisition et analyse d'images</option>
                    <option value="MML4U1">STAGE</option>
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