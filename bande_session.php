<?php if($id_session == "hacker_du_93"){ ?>
<br>
<div class="arrondi barreAdmin">
    <div <?php if(get_browsername() == "Safari"){ print('class="barreadmSaf"'); } else print('class="barreadm"')  ?> style="float: left;line-height: 25px;">
        <?php 
        if($user_session == "blackorbit"){
            print("<strong style='color: red'>Owner : </strong>");
        } elseif($super_admin == 1){
            print("Super-admin: ");
        } else {
            print("Administrateur: ");}?> <?php print($user_session) 
        ?> 
    </div>

    <?php
    if($super_admin == 1){
        print('
            <form action="leacp.php" method="post" style="float:left;" >
                <input type="submit" value="Admin panel" style="margin-left: 400px; background-color: #0000004d;border-color: #fff0;color: white; line-height: 19px;"/>
            </form>

            <form action="validation.php" method="post" style="float:left;" >
                <input type="submit" value="Validation" style="margin-left: 10px; background-color: #0000004d;border-color: #fff0;color: white; line-height: 19px;"/>
            </form>
        ');
    } else {
        print('
            <form action="validation.php" method="post" style="float:left;" >
                <input type="submit" value="Validation" style="margin-left: 502px; background-color: #0000004d;border-color: #fff0;color: white; line-height: 19px;"/>
            </form>
        ');
    }
    ?>


    <form action="feedbacks2.php" method="post" style="float:left;" >
        <input type="submit" value="Feedbacks" style="margin-left: 10px; background-color: #0000004d;border-color: #fff0;color: white; line-height: 19px;"/>
    </form>

    <form action="" method="post" >
        <input type="hidden" name="Deconnexion" value="" />
        <input type="submit" value="Deconnexion" style="float:left; margin-left: 58px; background-color: #00000080;border-color: #fff0;color: white; line-height: 19px;"/>
    </form>
    
</div>
<?php } ?>



