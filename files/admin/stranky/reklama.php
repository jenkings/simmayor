<div id="text">

    <?php
    if(intval($player->getVar('admin')) >= 20)
    {

        echo $reklama->Pozadavky($_GET);
        echo $reklama->Prehled();
    }
    ?>

</div>