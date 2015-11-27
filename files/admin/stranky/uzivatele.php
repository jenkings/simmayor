<div id="data">
    <?php
        echo $adminplayers->uzivatele_prehled();
    ?>
</div>
<div id="data">
    <?php
        echo $adminplayers->uzivatele_menu();
    ?>
</div>
<div id="text">
    <hr>
    <h3>Sekce uživatelé:</h3>
    <?php
        if(!isset($_GET['sekce']) OR $_GET['sekce'] == ""){
        $_GET['sekce'] = 1;
        }


    echo $adminplayers->uzivatele_sekce($_GET['sekce'],$_POST);
    ?>
</div>

