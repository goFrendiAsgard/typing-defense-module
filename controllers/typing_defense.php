<?php
/**
 * Description of blog
 *
 * @author gofrendi
 */
class Typing_defense extends CMS_Controller {
    //put your code here
    public function index(){        
    	if($this->cms_allow_navigate('typedef_index')){
        	$this->load->view('index.php');
    	}else{
    		echo "login first";
    		//replace this with redirect
    	}
    }

    public function json_game($level_id){
    	$data = array();
    	$this->db->select('question, answer')->from('typedef_question')->where('level_id', $level_id);
    	$query = $this->db->get();
    	foreach($query->result() as $row){
    		$data[] = array($row->question, $row->answer, 0);
    	}
    	$wrong_penalty = 5;
    	$collation_penalty = 50;
    	$correct_point = 10;
    	$interval = 1000;
    	$speed = 5;
    	$win_score = 1000;
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
