<div id="text">

    <?php
    if(isset($_GET['ukolid']) AND isset($_GET['ukolst'])){
        echo $ukoly->ResUkol($_GET['ukolid'],$_GET['ukolst']);
    }

    if(isset($_GET['ukolid']) AND isset($_GET['ukolsm'])){
        echo $ukoly->SmazUkol($_GET['ukolid'],$_GET['ukolsm'],$_POST);
    }

    echo $ukoly->Vypis();
    ?>

    <div style="width:60%;margin-left:auto;margin-right:auto;padding-top:25px">
        <hr>
        <h3>Informace o stavech:</h3>
        <p>Když už si dá někdo práci s tím, že zadá úkol do systému tak by
            bylo fajn, aby se tyto barvy dodrživali... </p>
        <table width="100%" border="1px">
            <tr align="center">
                <th width="50%">Stav</th>
                <th width="50%">Popis</th>
            </tr>
            <tr align="center" style='background-color:#EF8186;border:solid red 2px;'>
                <td>Červená</td>
                <td>Úkol je zadaný v systému</td>
            </tr>
            <tr align="center" style='background-color:#F7F98B;border:solid #F5EE00 2px;'>
                <td>Žlutá</td>
                <td>Na úkolu se usilovně pracuje</td>
            </tr>
            <tr align="center" style='background-color:#B0EF81;border:solid green 2px;'>
                <td>Zelená</td>
                <td>Úkol je vyřešen</td>
            </tr>
        </table>
    </div>

</div>