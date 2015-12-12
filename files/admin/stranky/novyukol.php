
<div id="text">
	<h4> Zadejte úkol:</h4>
	<?php

	if(isset($_POST['sdeleni']) && isset ($_POST['admin']))
        $ukoly->NewUkol($_POST['sdeleni'],$_POST['admin']);

	echo $ukoly->AddForm();
	?>

</div>