<?php
/**
 * Description of blog
 *
 * @author gofrendi
 */
class Typing_defense extends CMS_Controller {
    //put your code here
    public function index(){
    	$query = $this->db
    		->select_sum('score')
    		->from('typedef_score')
    		->where('user_id', $this->cms_userid())
    		->get();
    	$row = $query->row();
    	$user_score = isset($row->score)?$row->score:0;
    	
    	$where = 'min_score_to_play <= '.$user_score;
    	$query = $this->db
    		->select('level_id, level_name, description')
    		->from('typedef_level')
    		->where($where)
    		->order_by('min_score_to_play', 'desc')
    		->get();
    	$games = array();
    	foreach($query->result() as $row){
    		$games[] = array(
    			'id' => $row->level_id,
    			'name' => $row->level_name,
    			'description' => $row->description
    		);
    	}
    	$data=array("games"=>$games);
    	$this->view('index.php', $data, 'typedef_index');
    }
    
    public function game($level_id=NULL){
    	if(!isset($level_id)){    		
    		redirect($this->cms_module_name().'/index');
    	}
    	$data=array(
    			"level" => $level_id,
    			"cms" => array(
    					"module_name" => $this->cms_module_name()
    				)
    	);
    	$this->load->view('game.php', $data);
    }
    
    public function json_end_game($level_id){
    	$query = $this->db->select('wrong_penalty, collation_penalty, correct_point, interval, speed, win_score')
    	->from('typedef_level')
    	->where('level_id', $level_id)
    	->get();
    	$row = $query->row();
    	$win_score = $row->win_score;
    	
    	$user_id = $this->cms_userid();
    	$score = $this->input->post('score');
    	$where = array("level_id"=>$level_id, "user_id"=>$user_id);
    	$query = $this->db->select('score_id, score, win')
    		->from('typedef_score')
    		->where($where)
    		->get();
    	
    	if($query->num_rows()==0){
    		$win = ($score >= $win_score)?1:0;
    		if($win) $score = $win_score;
    		$data = array("level_id"=>$level_id, "user_id"=>$user_id, "score"=>$score, "win"=>$win);
    		$this->db->insert('typedef_score', $data);
    	}else{
    		$row = $query->row();
    		$old_score = $row->score;
    		if($score>$old_score){
    			$win = ($score >= $win_score)?1:0;
    			if($win) $score = $win_score;
    			$data = array("level_id"=>$level_id, "user_id"=>$user_id, "score"=>$score, "win"=>$win);
    			$where = array("score_id"=>$row->score_id);
    			$this->db->update('typedef_score', $data, $where);
    		}
    	}
    	
    }

    public function json_start_game($level_id){
    	$data = array();
    	$query = $this->db->select('question, answer')
    		->from('typedef_question')
    		->where('level_id', $level_id)
    	    ->get();
    	foreach($query->result() as $row){
    		$data[] = array($row->question, $row->answer, 0);
    	}
    	
    	$query = $this->db->select('wrong_penalty, collation_penalty, correct_point, interval, speed, win_score')
    		->from('typedef_level')
    		->where('level_id', $level_id)
    		->get();
    	$row = $query->row();
    	$wrong_penalty = $row->wrong_penalty;
    	$collation_penalty = $row->collation_penalty;
    	$correct_point = $row->correct_point;
    	$interval = $row->interval;
    	$speed = $row->speed;
    	$win_score = $row->win_score;
    	
    	$json = array(
    			"data"=>$data,
    			"wrong_penalty"=>$wrong_penalty,
    			"collation_penalty"=>$collation_penalty,
    			"correct_point"=>$correct_point,
    			"interval"=>$interval,
    			"speed"=>$speed,
    			"win_score"=>$win_score,    			
    	);
    	echo json_encode($json, true);
    }
    
    
    public function level(){
    	$crud = new grocery_CRUD();    	
    	$crud->set_table('typedef_level');
    	$output = $crud->render();    	
    	$this->view('grocery_CRUD', $output, 'typedef_level');
    }
    
    public function question(){
    	$crud = new grocery_CRUD();
    	$crud->set_table('typedef_question');
    	$crud->set_relation('level_id', 'typedef_level', 'level_name');
    	$output = $crud->render();
    	$this->view('grocery_CRUD', $output, 'typedef_question');
    }
    
}

?>
