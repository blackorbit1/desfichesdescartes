<?php

if($navigateur == "Internet Explorer" || $navigateur == "Edge"){
    if(isset($_SESSION["pseudo"])){
        logs($_SESSION["pseudo"], "Est allé sur change_de_navigateur.php");
    } else {
        logs("inconnu", "Est allé sur change_de_navigateur.php");
    }
    
    ?>
    
    <!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8" />
            <title>DesFichesDescartes</title>
            <meta name="description" content="Bienvenu sur le site DesFichesDescartes, un site totallement indépendant de l’université et de tout organisme. Vous trouvez ici toutes les fiches que nous avons en notre possession. La partie la plus complète est actuellement celle de la L2 d’informatique (car c’est la classe dans laquel nous sommes) mais les autres parties vont s’étoffer petit à petit. " />
            <link rel="icon" type="image/png" href="favicon2.png" />
    
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
            <link rel="shortcut icon" type="image/png" href="favicon2.png">
            <meta name="theme-color" content="#6cbbff">
            <meta name="keywords" content="desfichesdescartes, cours, annales, corrigés, td, tp" />
            <meta name="msapplication-TileColor" content="#6cbbff">
            <meta name="msapplication-TileImage" content="iconmetrowin10.png">
            <meta name="application-name" content="DesFichesDescartes">
            <meta property="og:title" content="DesFichesDescartes" />
            <meta property="og:description" content="Site qui contient des TD/TP/Cours/Annales/Fiches/Corrigés/.. pour toutes les matières de math=info de l'université Paris Descartes" />
            <meta property="og:image" content="iconmetrowin100.png" />
    
    
            <link rel="apple-touch-icon" href="apple-touch-icon.png" />
            <link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-57x57.png" />
            <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png" />
            <link rel="apple-touch-icon" sizes="76x76" href="apple-touch-icon-76x76.png" />
            <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png" />
            <link rel="apple-touch-icon" sizes="120x120" href="apple-touch-icon-120x120.png" />
            <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144x144.png" />
            <link rel="apple-touch-icon" sizes="152x152" href="apple-touch-icon-152x152.png" />
            <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon-180x180.png" />
        </head>
    
        
        <body style="font-family: monospace;">
            <h1>Support de Edge et Internet Explorer terminé</h1>
            <dt>Pourquoi ?</dt>
            <dd>Ces 2 navigateurs ne respectent pas les normes d'internet, et obligent les développeurs à faire des variantes ou des morceaux de site spécialement pour eux, en gros à perdre un max de temps et donc par extention réduire la qualité des sites.</dd>
            <dt>Quels navigateurs sont supportés alors ?</dt>
            <dd>Le site est développé spécialement pour Firefox, Chrome et Safari
                <br>
                <br>
                <br><img style="border-radius: 5px;" src="navigateurs.gif" alt="[zone super gif trop classe]">
                <br><span style="font-size: smaller;opacity: 0.2;">animation de Latham Arnott: <a href="https://dribbble.com/akaHomebody">https://dribbble.com/akaHomebody</a></span>
            </dd>
    
    
        </body>
    </html>
    <?php
    exit();
}

?>