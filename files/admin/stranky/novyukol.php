
<div id="text">
	<h4> Zadejte úkol:</h4>
	<?php

	if(isset($_GET['sdeleni']) && isset ($_GET['admin']))
        $ukoly->NewUkol($_GET['sdeleni'],$_GET['admin']);

	echo $ukoly->AddForm();
	?>

</div>