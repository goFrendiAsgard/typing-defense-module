<style type="text/css">
.game_title
{
	font:bold 15px arial;
	padding: 0px;
	margin: 0px;
}

.game
{ 
    padding: 10px; 
    font:bold 12px arial; 
    background-color: #dedede; 
    color: #000; 
    -webkit-border-radius: 10px; 
    -moz-border-radius: 10px;
    margin: 5px;
    float: left;
    width: 200px;
    height: 100px;
}

#score
{
	font:bold 20px arial;
	padding: 5px;
}

.game img
{
	float: right;
}
</style>
<div id="score">Your score : <?php echo $user_score;?>,<br />You've unlock these levels:</div>
<?php
	foreach($games as $game){
		echo '<div class="game">';
		echo anchor(site_url($cms['module_path'].'/typing_defense/game/'.$game['id']), 
				'<div class="game_title">'.$game['name'].'</div>');
		echo $game['description'];
		if($game['win']==1){
			echo '<img width="20px" src="'.site_url('modules/'.$cms['module_path']."/assets/images/check.png").'" />';
		};
		echo '</div>';
	}
?>
