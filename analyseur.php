<?php /*
///// --- --- Interface pour tester la fonction --- --- /////

<form method="post" action="">
    <input type="text" name="chaine">.pdf 
    <select name="annee">
        <option value="2000">2000</option>
        <option value="2001">2001</option>
        <option value="2002">2002</option>
        <option value="2003">2003</option>
        <option value="2004">2004</option>
        <option value="2005">2005</option>
        <option value="2006">2006</option>
        <option value="2007">2007</option>
        <option value="2008">2008</option>
        <option value="2009">2009</option>
        <option value="2010">2010</option>
        <option value="2011">2011</option>
        <option value="2012">2012</option>
        <option value="2013">2013</option>
        <option value="2014">2014</option>
        <option value="2015">2015</option>
        <option value="2016">2016</option>
        <option value="2017">2017</option>
        <option value="2018">2018</option>
    </select>
    <select name="type">
        <option value="cours" <?php if(isset($_POST["type"]) and $_POST["type"] == "cours") print("selected"); ?>>cours</option>
        <option value="td" <?php if(isset($_POST["type"]) and $_POST["type"] == "td") print("selected"); ?>>td</option>
        <option value="tp" <?php if(isset($_POST["type"]) and $_POST["type"] == "tp") print("selected"); ?>>tp</option>
        <option value="annale" <?php if(isset($_POST["type"]) and $_POST["type"] == "annale") print("selected"); ?>>annale</option>
    </select>
    <input type="submit" value="ok">
</form>
*/?>
<?php

// \s       ==> espace blanc
// \d       ==> chiffre
//  .       ==> tout
//  ^       ==> dire que c'est le début de chaine
//  $       ==> dire que c'est la fin de chaine
// {x}      ==> dire que ça se repete x fois
// [1-548]  ==> de 1 à 548
// [-. ]    ==> il peut y avoir un tiret, un point ou un espace

/*

Pour détecter les CM:



*/


function convertisseur(string $chaine, string $annee, string $type){
    //$annee = " (" . $annee . ")";
    $match[1] = "";
    $resultat = "vide";
    if(preg_match("#(pu+ti+n+|ptdr+|merde[eu]*|[_ ]l+[oeu]+l+[_. ]|^l+[oeu]+l+[_. ]|co[u]?nn+a+rd|[_ ]bi+t+e+[_. ]|^bi+t+e+[_. ]|encul[ée]+|[_ ]pu+te.|^pu+te.|[_ ]po+rn.|cou+i+ll+e|^fdp+.pdf|^nique[_ ]|salo+pe[^t]|pé+d+é+|^m+d+r+[_. ]|[\*]{3,50})#iu", $chaine, $match)){
        return("[spam probable]");
    }
    if($type == "cours"){           /// /// /// === COURS === /// /// ///
        $annee = "(" . $annee . ")";
        if(preg_match("#(cm|s[ée]ance[s]?)[-. _]{0,5}([0-1]?[0-9])#iu", $chaine, $match)){
            $resultat = "CM". (int) $match[2];
        } elseif(preg_match("#^([0-1]?[0-9])[-. _]#iu", $chaine, $match)){
            $resultat = "CM". (int) $match[1];
        } elseif(preg_match("#r[ée]sum[ée][-. _]{0,5}cour[s]?[-. _]{0,5}([0-1]?[0-9])#iu", $chaine, $match)){
            $resultat = "Résumé cours ". (int) $match[1];
        } elseif(preg_match("#cour[s]?[-. _]{0,5}([0-1]?[0-9])#i", $chaine, $match)){
            $resultat = "Cours ". (int) $match[1];
        } elseif(preg_match("#cour[s]?[-. _]{0,5}(entier|t[ôo]tal|complet|int[ée]gral[e]?|global[e]?)#iu", $chaine, $match)){
            $resultat = "Cours ". $match[1];
        } elseif(preg_match("#(ch|chap|chapitre)[-. _]{0,5}([0-1]?[0-9])#iu", $chaine, $match)) {
            $resultat = "Chapitre ". (int) $match[2];
        } elseif(preg_match("#(poly|polycopié[e]?|polycopie[e]?)[-. _]{0,5}(2?0?[0-1]?[0-9])#iu", $chaine, $match)) {
            $resultat = "Poly ". (int) $match[2];
        } elseif(preg_match("#(poly|polycopié[e]?|polycopie[e]?)[-. _a-zA-Z]{0,50}(20[0-2][0-9])#iu", $chaine, $match)) {
            $resultat = "Poly ". $match[2];
        } elseif(preg_match("#(poly|polycopié[e]?|polycopie[e]?)[-. _a-zA-Z]{0,50}([0-3]?[0-9])#iu", $chaine, $match)) {
            $temp = (strlen($match[2]) > 1)?("". $match[2]):("0". $match[2]);
            $resultat = "Poly (20". $temp .")";
            $annee = "";
        }  
    } elseif($type == "td"){           /// /// /// === TD === /// /// ///
        $annee = "(" . $annee . ")";
        if(preg_match("#(cour[s]?|s[ée]ance[s]?|[ée]nonc[ée]+)[-. _]{0,5}([0-1]?[0-9])#iu", $chaine, $match)){
            $resultat = ucfirst(strtolower($match[1])) ." ". (int) $match[2];
        } elseif(preg_match("#(?:td|dirig[ée][e]?|feuille|poly|polycopié[e]?|polycopie[e]?)[-. _a-zA-Z]{0,50}([0-1]?[0-9])#iu", $chaine, $match)){
            $resultat = "TD". (int) $match[1];
        } elseif(preg_match("#ed[-. _]{0,5}([0-9])#iu", $chaine, $match)){
            $resultat = "ED". (int) $match[1];
        } elseif(preg_match("#^([0-1]?[0-9])[-. _]#iu", $chaine, $match)){
            $resultat = "TD". $match[1];
        }
    } elseif($type == "tp"){           /// /// /// === TP === /// /// ///
        $annee = "(" . $annee . ")";
        if(preg_match("#(cour[s]?|s[ée]ance[s]?|[ée]nonc[ée]+)[-. _]{0,5}([0-1]?[0-9])#iu", $chaine, $match)){
            $resultat = ucfirst(strtolower($match[1])) ." ". (int) $match[2];
        } elseif(preg_match("#(?:tp|dirig[ée][e]?|feuille|poly|polycopié[e]?|polycopie[e]?)[-. _a-zA-Z]{0,50}([0-1]?[0-9])#iu", $chaine, $match)){
            $resultat = "TP". (int) $match[1];
        } elseif(preg_match("#ed[-. _]{0,5}([0-9])#iu", $chaine, $match)){
            $resultat = "ED". (int) $match[1];
        } elseif(preg_match("#^([0-1]?[0-9])[-. _]#iu", $chaine, $match)){
            $resultat = "TP". $match[1];
        }
    } elseif($type == "annale"){        /// /// /// === ANNALES === /// /// ///
        // #(cc|contr[ôo]le?|)[-. _a-zA-Z]{0,50}([0-9])[-. _a-zA-Z]#iu


        /// /// ======>>> Determination du type d'annale (CC, Partiel, Examen, etc)
        if(preg_match("#(?:cc|contr[ôo]le?)#iu", $chaine, $match)){
            $resultat = "CC";
            if(preg_match(" #(?:cc|contr[ôo]le?)[-. _]{0,15}(0?[0-9])[^0-9]#iu", $chaine, $match)){
                $resultat = $resultat . (int) $match[1];
            }
        } elseif(preg_match("#(?:partiel[l]?[e]?)#iu", $chaine, $match)){
            $resultat = "Partiel";
            if(preg_match(" #(?:partiel[l]?[e]?)[-. _]{0,15}(0?[0-9])[^0-9]#iu", $chaine, $match)){
                $resultat = $resultat . " ". (int) $match[1];
            }
        } elseif(preg_match("#(?:Exam[e]?[n]?|sess?ions?[-. _]?1)#iu", $chaine, $match)){
            $resultat = "Examen";
        } elseif(preg_match("#(?:Ratt?rap?age?|ses[s]?ions?[-. _]?2)#iu", $chaine, $match)){
            $resultat = "Rattrapage";
        } else {
            return "";
        }
        

    }

                                         /// /// /// === INTERVALES === /// /// ///

    $temp = ((substr(isset($match[1])?$match[1]:"1", 0, 1) == '0') || (substr(isset($match[2])?$match[2]:"1", 0, 1) == '0'))?"[01]":"";
    //print($temp);
    $temp = ((substr(isset($match[1])?$match[1]:"0", 0, 1) == '1') || (substr(isset($match[2])?$match[2]:"0", 0, 1) == '1'))?"1":$temp;
    //print("<br>substr match[1]:". (int) (substr(isset($match[2])?$match[2]:"1", 0, 1) == '1'));
    //print_r($match);
    //print($temp);
    //$temp = "";
    if(preg_match("#((?:(?:[ ]?et[ ]?|[ ]?,[ ]?)". $temp ."1?[0-9])+)#iu", $chaine, $match)){
        $resultat = $resultat . "". $match[1];
        //print("<br>1e if<br>");
    } elseif(preg_match("#[0-9]([-](à|a|et)[-]|[.](à|a|et)[.]|[ ](à|a|et)[ ]|[_](à|a|et)[_])(". $temp ."1?[0-9])#iu", $chaine, $match)){
        $resultat = $resultat . " ". $match[2] . $match[3] . $match[4] . $match[5]. " ". (int) $match[6];
        //print("<br>2e if<br>");
    } elseif(preg_match("#[0-9](?:à|a|et)(". $temp ."1?[0-9])#iu", $chaine, $match)){
        $resultat = $resultat . " à ". (int) $match[1];
        //print("<br>3e if<br>");
    } elseif(preg_match("#((?:(?:[ ]?et[ ]?|[ ]?,[ ]?)". $temp ."1?[0-9])+)#iu", $chaine, $match)){
        $resultat = $resultat . "". $match[1];
        //print("<br>4e if<br>");
    }
    /*
    if(preg_match("#(cor[r]?ig[ée]{0,2}|(cor[r]?ection)|correc|[-. _a-zA-Z0-9]corr[^a-zA-Z])#iu", $chaine, $match)){
        $temp = false;
        //$temp = array_key_exists("2", $match);
        print_r($match);
        $resultat = $resultat . " " . false?"corrrrrrrrection":"corrigé";
    }
    */

    /// /// ======>>> Determination de l'année

    if(preg_match("#(?>!20[012][0-9][-. _a-zA-Z]?20[012][0-9])(20[012][0-9])#iu", $chaine, $match)){
        $annee = $match[1];
    }
    
    
    /*
    $resultat = preg_match("#cm[-. _]{0,5}([0-1]?[0-9])#i", $chaine, $match)?("CM". $match[1]):$resultat;
    $resultat = preg_match("#td[-. _]{0,5}([0-1]?[0-9])#i", $chaine, $match)?("TD". $match[1]):$resultat;
    */
    if($resultat == "vide"){
        /* TRAITEMENT DEFAUT DE TRAITEMENT */
        return "";
    } else {
        return $resultat . " " . $annee ;
    }
}

/*

if(isset($_POST["chaine"])){
    print($_POST["chaine"] . ".pdf <strong>à l'année</strong> " . $_POST["annee"] . " <strong>donne : </strong>". convertisseur($_POST["chaine"] . ".pdf", $_POST["annee"], $_POST["type"]));
}
*/
?>