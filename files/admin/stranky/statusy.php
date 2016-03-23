<div id="text">
    <p>Poznámka vývoje: Jestli se vytvoří nový sloupeček pravomocí tak se to musí zadat / vytvořit v systému ručně. Todolist:
    vytvořit vytváření sloupečků...</p>
    <hr>
    <?php

    if(isset($_GET['pravomoce'])){
        echo $adminstatus->editacePravooce($_GET['pravomoce'],$_POST);
    }

    echo $adminstatus->vypisStatusu();
    ?>




</div>