<?php
	foreach($games as $game){
		echo anchor(site_url($cms['module_name'].'/game/'.$game['id']), $game['name']);
		echo br();
		echo $game['description'];
		echo '<hr />';
		echo br();
	}
?>