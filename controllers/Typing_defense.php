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
    		->from($this->cms_complete_table_name('score'))
    		->where('user_id', $this->cms_user_id())
    		->get();
    	$row = $query->row();
    	$user_score = isset($row->score)?$row->score:0;

    	$where = 'min_score <= '.$user_score;
    	$query = $this->db
    		->select($this->cms_complete_table_name('level.level_id, level_name, description, win'))
    		->from($this->cms_complete_table_name('level'))
    		->join($this->cms_complete_table_name('score'), 
                $this->cms_complete_table_name('score').'.level_id = '.$this->cms_complete_table_name('level').'.level_id AND '.$this->cms_complete_table_name('score').'.user_id=\''.$this->cms_user_id().'\'', 'left')
    		->where($where)
    		->order_by('min_score', 'desc')
    		->get();
    	$games = array();
    	foreach($query->result() as $row){
    		$games[] = array(
    			'id' => $row->level_id,
    			'name' => $row->level_name,
    			'description' => $row->description,
    			'win' => $row->win
    		);
    	}
    	$data=array("games"=>$games, "user_score"=>$user_score);
    	$this->view('index.php', $data, $this->cms_complete_navigation_name('index'));
    }

    public function game($level_id=NULL){
    	if(!isset($level_id)){
    		redirect($this->cms_module_path().'/index');
    	}
    	$data=array(
    			"level" => $level_id
    	);
    	$this->view('game.php', $data, $this->cms_complete_navigation_name('index'), array('only_content'=>TRUE));
    }

    public function json_end_game($level_id){
    	$query = $this->db->select('wrong_penalty, collation_penalty, correct_point, interval, speed, win_score')
    	->from($this->cms_complete_table_name('level'))
    	->where('level_id', $level_id)
    	->get();
    	$row = $query->row();
    	$win_score = $row->win_score;

    	$user_id = $this->cms_user_id();
    	$score = $this->input->post('score');
    	$where = array("level_id"=>$level_id, "user_id"=>$user_id);
    	$query = $this->db->select('score_id, score, win')
    		->from($this->cms_complete_table_name('score'))
    		->where($where)
    		->get();

    	if($query->num_rows()==0){
    		$win = ($score >= $win_score)?1:0;
    		if($win) $score = $win_score;
    		$data = array("level_id"=>$level_id, "user_id"=>$user_id, "score"=>$score, "win"=>$win);
    		$this->db->insert($this->cms_complete_table_name('score'), $data);
    	}else{
    		$row = $query->row();
    		$old_score = $row->score;
    		if($score>$old_score){
    			$win = ($score >= $win_score)?1:0;
    			if($win) $score = $win_score;
    			$data = array("level_id"=>$level_id, "user_id"=>$user_id, "score"=>$score, "win"=>$win);
    			$where = array("score_id"=>$row->score_id);
    			$this->db->update($this->cms_complete_table_name('score'), $data, $where);
    		}
    	}

    }

    public function json_start_game($level_id){
    	$data = array();
    	$query = $this->db->select('question, answer')
    		->from($this->cms_complete_table_name('question'))
    		->where('level_id', $level_id)
    	    ->get();
    	foreach($query->result() as $row){
    		$data[] = array($row->question, $row->answer, 0);
    	}

    	$query = $this->db->select('wrong_penalty, collation_penalty, correct_point, interval, speed, win_score')
    		->from($this->cms_complete_table_name('level'))
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
    	$this->cms_show_json($json);
    }


    public function level(){
    	$crud = $this->new_crud();
		$crud->unset_jquery();
    	$crud->set_table($this->cms_complete_table_name('level'));
    	$output = $crud->render();
    	$this->view('grocery_CRUD', $output, 'typedef_level');
    }

    public function question(){
    	$crud = $this->new_crud();
        $crud->unset_jquery();
    	$crud->set_table($this->cms_complete_table_name('question'));
    	$crud->set_relation('level_id', $this->cms_complete_table_name('level'), 'level_name');
    	$output = $crud->render();
    	$this->view('grocery_CRUD', $output, 'typedef_question');
    }

}

?>
