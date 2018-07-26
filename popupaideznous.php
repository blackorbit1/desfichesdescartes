<?php
//print_r($_COOKIE);

if($individuDemandeCookie == true){ // // // Si le mec, la meuf, non binaire, foetus non différentié, ou périodiquement H/F accepte sans état d'âme les cookies
    ?>
    <div class="popup_que_tt_le_monde_veut_fermer" id="popuphelphelp">
        <img src="besoin_de_vous.jpg" alt="maaaaiiiiis édénou svp" style="border-radius: 5px;" />
        <div class="virerpopupaideznous" onClick="fermerPopupHelp()">Ok c’est trop bien je vais m’empresser de partager un max de trucs parce que c’est trop bien !</div>
    </div>
    <script>
        function fermerPopupHelp() {
            var popuphelp = document.getElementById("popuphelphelp");
            if(popuphelp.style.zIndex == "9999"){
                //var select = document.getElementById("popuphelphelp");
                popuphelp.style.zIndex = "0";
                popuphelp.style.opacity = "0";
                var select = document.getElementById("page");
                select.style = "filter: blur(0px);";
                var select = document.getElementById("background");
                select.style = "filter: blur(0px);";
            }
        }
    </script>
    <?php
}

?>