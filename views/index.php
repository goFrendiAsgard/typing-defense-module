<?php
	foreach($games as $game){
		echo anchor(base_url().'typing_defense/game/'.$game['id'], $game['name']);
		echo br();
		echo $game['description'];
		echo '<hr />';
		echo br();
	}
?>