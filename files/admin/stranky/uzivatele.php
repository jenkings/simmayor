<div id="data">
    <?php
        echo $adminplayers->uzivatelePrehled();
    ?>
</div>
<div id="data">
    <?php
        echo $adminplayers->uzivateleMenu();
    ?>
</div>
<div id="text">
    <hr>
    <h3>Sekce uživatelé:</h3>
    <?php
        if(!isset($_GET['sekce']) OR $_GET['sekce'] == ""){
            $_GET['sekce'] = 1;
        }

        if(!isset($_GET['paginace']) OR $_GET['paginace']<=0){
            $_GET['paginace'] = 0;
        }

        if(!isset($_GET['editace']) OR $_GET['editace']<=0){
            $_GET['editace'] = 0;
        }

        if(!isset($_GET['smazat']) OR $_GET['smazat']<=0){
            $_GET['smazat'] = 0;
        }

    echo $adminplayers->uzivateleSekce($_GET,$_POST,$_SESSION);
    ?>
</div>

