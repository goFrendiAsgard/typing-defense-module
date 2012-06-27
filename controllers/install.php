<?php

/**
 * Description of install
 *
 * @author gofrendi
 */
class Install extends CMS_Module_Installer {
	protected $NAME = 'gofrendi.typing_defense';
	protected $DEPENDENCIES = array();
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
        	  `wrong_penalty` int(20) unsigned NOT NULL DEFAULT '5',
        	  `collation_penalty` int(20) unsigned NOT NULL DEFAULT '50',
        	  `correct_point` int(20) unsigned NOT NULL DEFAULT '10',
        	  `interval` int(20) unsigned NOT NULL DEFAULT '1000',
        	  `speed` int(20) unsigned NOT NULL DEFAULT '5',
        	  `win_score` int(20) unsigned NOT NULL DEFAULT '1000',
        	  `min_score_to_play` int(20) unsigned NOT NULL DEFAULT '0',
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
              `score` int(20) unsigned NOT NULL,
        	  `win` int(20) unsigned NOT NULL DEFAULT '0',
              PRIMARY KEY (`score_id`),
              KEY `level_id` (`level_id`),
              KEY `user_id` (`user_id`),
              CONSTRAINT `typedef_score_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `typedef_level` (`level_id`),
              CONSTRAINT `typedef_score_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `cms_user` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
         ");
        $this->db->query("
        	INSERT INTO `typedef_level` (`level_id`, `level_name`, `wrong_penalty`, `collation_penalty`, `correct_point`, `interval`, `speed`, `win_score`, `min_score_to_play`, `description`) VALUES
				(1, 'Letter Shooter', 5, 50, 10, 1000, 5, 1000, 0, '<p>Shoot the floating letter</p>'),
				(2, 'Word Typer', 5, 50, 10, 2000, 4, 1000, 1000, '<p>Type the words</p>'),
				(3, 'Sentence Banisher', 5, 50, 10, 6000, 2, 1000, 2000, '<p>More than words...</p>'),
        		(4, 'Amateur Calculator', 5, 50, 10, 3000, 2, 1000, 2000, '<p>Calculate and conquer...</p>');        		
         ");
        $this->db->query("
        	INSERT INTO `typedef_question` (`question_id`, `level_id`, `question`, `answer`) VALUES
				(1, 1, 'A', 'A'),
				(2, 1, 'a', 'a'),
				(3, 1, 'B', 'B'),
				(4, 1, 'b', 'b'),
				(5, 1, 'C', 'C'),
				(6, 1, 'c', 'c'),
        		(7, 1, 'D', 'D'),
				(8, 1, 'd', 'd'),
				(9, 1, 'E', 'E'),
				(10, 1, 'e', 'e'),
				(11, 1, 'F', 'F'),
				(12, 1, 'f', 'f'),
        		(13, 1, 'G', 'G'),
				(14, 1, 'g', 'g'),
				(15, 1, 'H', 'H'),
				(16, 1, 'h', 'h'),
        		(17, 1, 'I', 'I'),
				(18, 1, 'i', 'i'),
				(19, 1, 'J', 'J'),
        		(20, 1, 'j', 'j'),
				(21, 1, 'K', 'K'),
				(22, 1, 'k', 'k'),
        		(23, 1, 'L', 'L'),
				(24, 1, 'l', 'l'),
				(25, 1, 'M', 'M'),
				(26, 1, 'm', 'm'),
        		(27, 1, 'N', 'N'),
				(28, 1, 'n', 'n'),
				(29, 1, 'O', 'O'),
        		(30, 1, 'o', 'o'),
				(31, 1, 'P', 'P'),
				(32, 1, 'p', 'p'),
        		(33, 1, 'Q', 'Q'),
				(34, 1, 'q', 'q'),
				(35, 1, 'R', 'R'),
				(36, 1, 'r', 'r'),
        		(37, 1, 'S', 'S'),
				(38, 1, 's', 's'),
				(39, 1, 'T', 'T'),
        		(40, 1, 't', 't'),
				(41, 1, 'U', 'U'),
				(42, 1, 'u', 'u'),
        		(43, 1, 'V', 'V'),
				(44, 1, 'v', 'v'),
				(45, 1, 'W', 'W'),
				(46, 1, 'w', 'w'),
        		(47, 1, 'X', 'X'),
				(48, 1, 'x', 'x'),
				(49, 1, 'Y', 'Y'),
        		(50, 1, 'y', 'y'),
				(51, 1, 'Z', 'Z'),
				(52, 1, 'z', 'z'),
        		(53, 2, 'Eat', 'Eat'),
				(54, 2, 'Cut', 'Cut'),	
        		(55, 2, 'Run', 'Run'),
        		(56, 2, 'Flee', 'Flee'),
				(57, 2, 'Book', 'Book'),
				(58, 2, 'Arm', 'Arm'),
        		(59, 2, 'Walk', 'Walk'),
				(60, 2, 'Doze', 'Doze'),
				(61, 2, 'Tool', 'Tool'),
				(62, 2, 'Yes', 'Yes'),
        		(63, 2, 'No', 'No'),
				(64, 2, 'Lie', 'Lie'),	
        		(65, 2, 'Die', 'Die'),
        		(66, 2, 'Pie', 'Pie'),
				(67, 2, 'Leg', 'Leg'),
				(68, 2, 'Toe', 'Toe'),
        		(69, 2, 'Hoe', 'Hoe'),
				(70, 2, 'Laze', 'Laze'),
				(71, 2, 'Hair', 'Hair'),
				(72, 2, 'Fur', 'Fur'),
        		(73, 2, 'Bow', 'Bow'),
				(74, 2, 'Arc', 'Arc'),	
        		(75, 2, 'View', 'View'),
        		(76, 2, 'Dig', 'Dig'),
				(77, 2, 'Let', 'Let'),
				(78, 2, 'Bath', 'Bath'),
        		(79, 2, 'Room', 'Room'),
				(80, 2, 'Deep', 'Deep'),
				(81, 2, 'Sea', 'Sea'),
				(82, 2, 'Hat', 'Hat'),
        		(83, 2, 'Cap', 'Cap'),
				(84, 2, 'Tie', 'Tie'),	
        		(85, 2, 'Ball', 'Ball'),
        		(86, 2, 'Data', 'Data'),
				(87, 2, 'Set', 'Set'),
				(88, 2, 'Sin', 'Sin'),
        		(89, 2, 'Sick', 'Sick'),
				(90, 2, 'Deer', 'Deer'),
				(91, 2, 'Goat', 'Goat'),
				(92, 2, 'Cow', 'Cow'),
        		(93, 2, 'Sow', 'Sow'),
				(94, 2, 'Deer', 'Deer'),	
        		(95, 2, 'Cat', 'Cat'),
        		(96, 2, 'Dog', 'Dog'),
				(97, 2, 'Bird', 'Bird'),
				(98, 2, 'Fish', 'Fish'),
        		(99, 2, 'Lock', 'Lock'),
				(100, 2, 'Lamb', 'Lamb'),
				(101, 2, 'Lamp', 'Lamp'),
				(102, 2, 'All', 'All'),
        		(103, 2, 'Ant', 'Ant'),
				(104, 2, 'Lion', 'Lion'),	
        		(105, 2, 'Fool', 'Fool'),
        		(106, 2, 'Drug', 'Drug'),
				(107, 2, 'Egg', 'Egg'),
				(108, 2, 'Roe', 'Roe'),
        		(109, 2, 'Row', 'Row'),
        		(110, 2, 'Damp', 'Damp'),
				(111, 2, 'Dump', 'Dump'),
				(112, 2, 'Deal', 'Deal'),
        		(113, 2, 'Free', 'Free'),
				(114, 2, 'Sit', 'Sit'),	
        		(115, 2, 'Rat', 'Rat'),
        		(116, 2, 'Mole', 'Mole'),
				(117, 2, 'Nail', 'Nail'),
				(118, 2, 'Claw', 'Claw'),
        		(119, 2, 'Skin', 'Skin'),
        		(120, 2, 'Eye', 'Eye'),
				(121, 2, 'Lash', 'Lash'),
				(122, 2, 'Fish', 'Fish'),
        		(123, 2, 'Mutt', 'Mutt'),
				(124, 2, 'Door', 'Door'),	
        		(125, 2, 'Tile', 'Tile'),
        		(126, 2, 'Step', 'Step'),
				(127, 2, 'Stop', 'Stop'),
				(128, 2, 'Day', 'Day'),
        		(129, 2, 'Moon', 'Moon'),
        		(130, 3, 'Reading book', 'Reading book'),
        		(131, 3, 'Eating cake', 'Eating cake'),
				(132, 3, 'Pipe down', 'Pipe down'),
        		(133, 3, 'Deep sleep', 'Deep sleep'),
				(134, 3, 'Door to door', 'Door to door'),	
        		(135, 3, 'Tile cracker', 'Tile cracker'),
        		(136, 3, 'Step up', 'Step up'),
				(137, 3, 'Stop down', 'Stop down'),
				(138, 3, 'Day off', 'Day off'),
        		(139, 3, 'Moon light', 'Moon light'),
        		(140, 3, 'Sun shine', 'Sun shine'),
        		(141, 3, 'Deep sea', 'Deep sea'),
				(142, 3, 'Run amok', 'Run amok'),
        		(143, 3, 'Island to island', 'Island to island'),
				(144, 3, 'Day by day', 'Day by day'),	
        		(145, 3, 'Living hell', 'Living hell'),
        		(146, 3, 'Mad scientist', 'Mad scientist'),
				(147, 3, 'Loony bard', 'Loony bard'),
				(148, 3, 'Dumb merchant', 'Dumb merchant'),
        		(149, 3, 'Naked king', 'Naked king'),
        		(150, 3, 'Sleepy cow', 'Sleepy cow'),
        		(151, 3, 'Death door', 'Death door'),
				(152, 3, 'Reader digest', 'Reader digest'),
        		(153, 3, 'Final judgement', 'Final judgement'),
				(154, 3, 'Evil twin', 'Evil twin'),	
        		(155, 3, 'Devil\'s luck', 'Devil\'s luck'),
        		(156, 3, 'Fear to tread', 'Fear to tread'),
				(157, 3, 'Iron fist', 'Iron fist'),
				(158, 3, 'Liar\'s due', 'Liar\'s due'),
        		(159, 3, 'Claypot rice', 'Claypot rice'),
        		(160, 3, 'Spam e-mail', 'Spam e-mail'),
        		(161, 3, 'Letter of marquee', 'Letter of marquee'),
				(162, 3, 'Rogue trader', 'Rogue Trader'),
        		(163, 3, 'Wild quess', 'Wild quess'),
				(164, 3, 'Trade warrant', 'Trade warrant'),	
        		(165, 3, 'Secure routing', 'Secure routing'),
        		(166, 3, 'Document analysis', 'Document analysis'),
				(167, 3, 'Requirement engineering', 'Requirement engineering'),
				(168, 3, 'Time control', 'Time control'),
        		(169, 3, 'Illegal move', 'Illegal move'),
        		(170, 3, 'Pawn promotion', 'Pawn promotion'),
        		(171, 3, 'Bad mouth', 'Bad mouth'),
				(172, 3, 'High roller', 'High roller'),
        		(173, 3, 'Raise the roof', 'Raise the roof'),
				(174, 3, 'Hit the spot', 'Hit the spot'),	
        		(175, 3, 'Buy the farm', 'Buy the farm'),
        		(176, 3, 'Green thumb', 'Green thumb'),
				(177, 3, 'Sitting duck', 'Sitting duck'),
				(178, 3, 'Not my cup of tea', 'Not my cup of tea'),
        		(179, 3, 'Excess baggage', 'Excess baggage'),
        		(180, 3, 'Fast food', 'Fast food'),
        		(181, 3, 'Low life', 'Low life'),
				(182, 3, 'Know it all', 'Know it all'),
        		(183, 3, 'Sweet tooth', 'Sweet tooth'),
				(184, 3, 'Zone out', 'Zone out'),	
        		(185, 3, 'In a bind', 'In a bind'),
        		(186, 3, 'Jump ship', 'Jump ship'),
				(187, 3, 'Cut a deal', 'Cut a deal'),
				(188, 3, 'Ants in your pants', 'Ants in your pants'),
        		(189, 3, 'On cloud nine', 'On cloud nine'),
        		(190, 4, '1+1', '2'),
        		(191, 4, '5-7', '-2'),
				(192, 4, '9+4', '13'),
        		(193, 4, '20-3', '17'),
				(194, 4, '8-9', '-1'),	
        		(195, 4, '7+8', '15'),
        		(196, 4, '3+2', '5'),
				(197, 4, '4+4', '8'),
				(198, 4, '4-4', '0'),
        		(199, 4, '2+7', '9'),
        		(200, 4, '1+11', '12'),
        		(201, 4, '25-7', '18'),
				(202, 4, '9-5', '4'),
        		(203, 4, '5+9', '14'),
				(204, 4, '8-10', '-2'),	
        		(205, 4, '7+9', '16'),
        		(206, 4, '3+0', '3'),
				(207, 4, '0-3', '-3'),
				(208, 4, '4+18', '22'),
        		(209, 4, '2-7', '-5');				
        	");
        $this->add_navigation("typedef_index","Typing Defense", $this->cms_module_path()."/typing_defense/index", 3);
        $this->add_navigation("typedef_level", "Level Management", $this->cms_module_path()."/typing_defense/level", 4, "typedef_index");
        $this->add_navigation("typedef_question", "Question Management", $this->cms_module_path()."/typing_defense/question", 4, "typedef_index");
    }
}

?>
