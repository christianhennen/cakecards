<?php 
	
	if ($email->send()) {
		echo "<span id=\"successIndicator\" class=\"text-success\">".__('Success!')."</span>";
	} else {
		echo "<span id=\"successIndicator\" class=\"text-danger\">".__('Error!')."</span>";
	}
	
?>