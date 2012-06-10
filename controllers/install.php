<?php

/**
 * Description of install
 *
 * @author gofrendi
 */
class Install extends CMS_Module_Installer {
    //this should be what happen when user install this module
    protected function do_install(){
        $this->remove_all();
        $this->build_all();
    }
    //this should be what happen when user uninstall this module
    protected function do_uninstall(){
        $this->remove_all();
    }
    
    private function remove_all(){    	        
        $this->db->query("DROP TABLE IF EXISTS `typedef_score`;");
        $this->db->query("DROP TABLE IF EXISTS `typedef_question`;"); 
        $this->db->query("DROP TABLE IF EXISTS `typedef_level`;");       
        
        $this->remove_navigation("typedef_index");
        $this->remove_navigation("typedef_level"); 
        $this->remove_navigation("typedef_question");    
    }
    
    private function build_all(){
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `typedef_level` (
              `level_id` int(20) unsigned NOT NULL AUTO_INCREMENT,
              `level_name` varchar(100) NOT NULL,
              `description` text,
              PRIMARY KEY (`level_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
         ");
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `typedef_question` (
              `question_id` int(20) unsigned NOT NULL AUTO_INCREMENT,
              `level_id` int(20) unsigned NOT NULL,
              `question` varchar(100) NOT NULL,
              `answer` varchar(100) NOT NULL,
              PRIMARY KEY (`question_id`),
              KEY `level_id` (`level_id`),
              CONSTRAINT `typedef_question_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `typedef_level` (`level_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
         ");
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `typedef_score` (
              `score_id` int(20) unsigned NOT NULL AUTO_INCREMENT,
              `level_id` int(20) unsigned NOT NULL,
              `user_id` int(20) unsigned NOT NULL,
              `score` int(20) NOT NULL,
              PRIMARY KEY (`score_id`),
              KEY `level_id` (`level_id`),
              KEY `user_id` (`user_id`),
              CONSTRAINT `typedef_score_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `typedef_level` (`level_id`),
              CONSTRAINT `typedef_score_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `cms_user` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
         ");
        
        $this->add_navigation("typedef_index","Typing Defense", "typing_defense", 3);
        $this->add_navigation("typedef_level", "Level Management", "typing_defense/level", 4, "typedef_index");
        $this->add_navigation("typedef_question", "Question Management", "typing_defense/question", 4, "typedef_index");
    }
}

?>
