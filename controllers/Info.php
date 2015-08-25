<?php

/**
 * Description of install
 *
 * @author gofrendi
 */
class Info extends CMS_Module {
    //this should be what happen when user install this module
    protected function do_activate(){
        $this->remove_all();
        $this->build_all();
    }
    //this should be what happen when user uninstall this module
    protected function do_deactivate(){
        $this->remove_all();
    }

    private function remove_all(){
        $this->dbforge->drop_table($this->cms_complete_table_name('score'), TRUE);
        $this->dbforge->drop_table($this->cms_complete_table_name('question'), TRUE);
        $this->dbforge->drop_table($this->cms_complete_table_name('level'), TRUE);

        $this->cms_remove_navigation("typedef_index");
        $this->cms_remove_navigation("typedef_level");
        $this->cms_remove_navigation("typedef_question");
    }

    private function build_all(){
        // level
        $fields = array(
                'level_id' => $this->TYPE_INT_UNSIGNED_AUTO_INCREMENT,
                'level_name' => $this->TYPE_VARCHAR_100_NOTNULL,
                'wrong_penalty' => $this->TYPE_INT_UNSIGNED_NOTNULL,
                'collation_penalty' => $this->TYPE_INT_UNSIGNED_NOTNULL,
                'correct_point' => $this->TYPE_INT_UNSIGNED_NOTNULL,
                'interval' => $this->TYPE_INT_UNSIGNED_NOTNULL,
                'speed' => $this->TYPE_INT_UNSIGNED_NOTNULL,
                'win_score' => $this->TYPE_INT_UNSIGNED_NOTNULL,
                'min_score' => $this->TYPE_INT_UNSIGNED_NOTNULL,
                'description' => $this->TYPE_TEXT,
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('level_id', TRUE);
        $this->dbforge->create_table($this->cms_complete_table_name('level'));

        // questions
        $fields = array(
                'question_id' => $this->TYPE_INT_UNSIGNED_AUTO_INCREMENT,
                'level_id' => $this->TYPE_INT_UNSIGNED_NOTNULL,
                'question' => $this->TYPE_VARCHAR_100_NOTNULL,
                'answer' => $this->TYPE_VARCHAR_100_NOTNULL,
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('question_id', TRUE);
        $this->dbforge->create_table($this->cms_complete_table_name('question'));

        // score
        $fields = array(
                'score_id' => $this->TYPE_INT_UNSIGNED_AUTO_INCREMENT,
                'level_id' => $this->TYPE_INT_UNSIGNED_NOTNULL,
                'user_id' => $this->TYPE_INT_UNSIGNED_NOTNULL,
                'score' => $this->TYPE_INT_UNSIGNED_NOTNULL,
                'win' => $this->TYPE_INT_UNSIGNED_NOTNULL,
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('score_id', TRUE);
        $this->dbforge->create_table($this->cms_complete_table_name('score'));

        $this->db->insert_batch($this->cms_complete_table_name('level'), array(
                array('level_id' => 1, 'level_name' => 'Letter Shooter', 'wrong_penalty' => 1, 'collation_penalty' => 2, 'correct_point' => 10, 'interval' => 1000, 'speed' => 5, 'win_score' => 500, 'min_score' => 0, 'description' => '<p>Shoot the floating letter</p>'),
                array('level_id' => 2, 'level_name' => 'Word Typer', 'wrong_penalty' => 1, 'collation_penalty' => 2, 'correct_point' => 10, 'interval' => 2000, 'speed' => 4, 'win_score' => 1000, 'min_score' => 1000, 'description' => '<p>Type the words</p>'),
                array('level_id' => 3, 'level_name' => 'Sentence Banisher', 'wrong_penalty' => 1, 'collation_penalty' => 2, 'correct_point' => 10, 'interval' => 6000, 'speed' => 2, 'win_score' => 1000, 'min_score' => 2000, 'description' => '<p>More than words...</p>'),
                array('level_id' => 4, 'level_name' => 'Amateur Calculator', 'wrong_penalty' => 1, 'collation_penalty' => 2, 'correct_point' => 10, 'interval' => 3000, 'speed' => 2, 'win_score' => 1000, 'min_score' => 2000, 'description' => '<p>Calculate and conquer...</p>')
            ));

        $this->db->insert_batch($this->cms_complete_table_name('question'), array(
                array('question_id' => 1, 'level_id' => 1, 'question' => 'A', 'answer' => 'A'),
                array('question_id' => 2, 'level_id' => 1, 'question' => 'a', 'answer' => 'a'),
                array('question_id' => 3, 'level_id' => 1, 'question' => 'B', 'answer' => 'B'),
                array('question_id' => 4, 'level_id' => 1, 'question' => 'b', 'answer' => 'b'),
                array('question_id' => 5, 'level_id' => 1, 'question' => 'C', 'answer' => 'C'),
                array('question_id' => 6, 'level_id' => 1, 'question' => 'c', 'answer' => 'c'),
                array('question_id' => 7, 'level_id' => 1, 'question' => 'D', 'answer' => 'D'),
                array('question_id' => 8, 'level_id' => 1, 'question' => 'd', 'answer' => 'd'),
                array('question_id' => 9, 'level_id' => 1, 'question' => 'E', 'answer' => 'E'),
                array('question_id' => 10, 'level_id' => 1, 'question' => 'e', 'answer' => 'e'),
                array('question_id' => 11, 'level_id' => 1, 'question' => 'F', 'answer' => 'F'),
                array('question_id' => 12, 'level_id' => 1, 'question' => 'f', 'answer' => 'f'),
                array('question_id' => 13, 'level_id' => 1, 'question' => 'G', 'answer' => 'G'),
                array('question_id' => 14, 'level_id' => 1, 'question' => 'g', 'answer' => 'g'),
                array('question_id' => 15, 'level_id' => 1, 'question' => 'H', 'answer' => 'H'),
                array('question_id' => 16, 'level_id' => 1, 'question' => 'h', 'answer' => 'h'),
                array('question_id' => 17, 'level_id' => 1, 'question' => 'I', 'answer' => 'I'),
                array('question_id' => 18, 'level_id' => 1, 'question' => 'i', 'answer' => 'i'),
                array('question_id' => 19, 'level_id' => 1, 'question' => 'J', 'answer' => 'J'),
                array('question_id' => 20, 'level_id' => 1, 'question' => 'j', 'answer' => 'j'),
                array('question_id' => 21, 'level_id' => 1, 'question' => 'K', 'answer' => 'K'),
                array('question_id' => 22, 'level_id' => 1, 'question' => 'k', 'answer' => 'k'),
                array('question_id' => 23, 'level_id' => 1, 'question' => 'L', 'answer' => 'L'),
                array('question_id' => 24, 'level_id' => 1, 'question' => 'l', 'answer' => 'l'),
                array('question_id' => 25, 'level_id' => 1, 'question' => 'M', 'answer' => 'M'),
                array('question_id' => 26, 'level_id' => 1, 'question' => 'm', 'answer' => 'm'),
                array('question_id' => 27, 'level_id' => 1, 'question' => 'N', 'answer' => 'N'),
                array('question_id' => 28, 'level_id' => 1, 'question' => 'n', 'answer' => 'n'),
                array('question_id' => 29, 'level_id' => 1, 'question' => 'O', 'answer' => 'O'),
                array('question_id' => 30, 'level_id' => 1, 'question' => 'o', 'answer' => 'o'),
                array('question_id' => 31, 'level_id' => 1, 'question' => 'P', 'answer' => 'P'),
                array('question_id' => 32, 'level_id' => 1, 'question' => 'p', 'answer' => 'p'),
                array('question_id' => 33, 'level_id' => 1, 'question' => 'Q', 'answer' => 'Q'),
                array('question_id' => 34, 'level_id' => 1, 'question' => 'q', 'answer' => 'q'),
                array('question_id' => 35, 'level_id' => 1, 'question' => 'R', 'answer' => 'R'),
                array('question_id' => 36, 'level_id' => 1, 'question' => 'r', 'answer' => 'r'),
                array('question_id' => 37, 'level_id' => 1, 'question' => 'S', 'answer' => 'S'),
                array('question_id' => 38, 'level_id' => 1, 'question' => 's', 'answer' => 's'),
                array('question_id' => 39, 'level_id' => 1, 'question' => 'T', 'answer' => 'T'),
                array('question_id' => 40, 'level_id' => 1, 'question' => 't', 'answer' => 't'),
                array('question_id' => 41, 'level_id' => 1, 'question' => 'U', 'answer' => 'U'),
                array('question_id' => 42, 'level_id' => 1, 'question' => 'u', 'answer' => 'u'),
                array('question_id' => 43, 'level_id' => 1, 'question' => 'V', 'answer' => 'V'),
                array('question_id' => 44, 'level_id' => 1, 'question' => 'v', 'answer' => 'v'),
                array('question_id' => 45, 'level_id' => 1, 'question' => 'W', 'answer' => 'W'),
                array('question_id' => 46, 'level_id' => 1, 'question' => 'w', 'answer' => 'w'),
                array('question_id' => 47, 'level_id' => 1, 'question' => 'X', 'answer' => 'X'),
                array('question_id' => 48, 'level_id' => 1, 'question' => 'x', 'answer' => 'x'),
                array('question_id' => 49, 'level_id' => 1, 'question' => 'Y', 'answer' => 'Y'),
                array('question_id' => 50, 'level_id' => 1, 'question' => 'y', 'answer' => 'y'),
                array('question_id' => 51, 'level_id' => 1, 'question' => 'Z', 'answer' => 'Z'),
                array('question_id' => 52, 'level_id' => 1, 'question' => 'z', 'answer' => 'z'),
                array('question_id' => 53, 'level_id' => 2, 'question' => 'Eat', 'answer' => 'Eat'),
                array('question_id' => 54, 'level_id' => 2, 'question' => 'Cut', 'answer' => 'Cut'),
                array('question_id' => 55, 'level_id' => 2, 'question' => 'Run', 'answer' => 'Run'),
                array('question_id' => 56, 'level_id' => 2, 'question' => 'Flee', 'answer' => 'Flee'),
                array('question_id' => 57, 'level_id' => 2, 'question' => 'Book', 'answer' => 'Book'),
                array('question_id' => 58, 'level_id' => 2, 'question' => 'Arm', 'answer' => 'Arm'),
                array('question_id' => 59, 'level_id' => 2, 'question' => 'Walk', 'answer' => 'Walk'),
                array('question_id' => 60, 'level_id' => 2, 'question' => 'Doze', 'answer' => 'Doze'),
                array('question_id' => 61, 'level_id' => 2, 'question' => 'Tool', 'answer' => 'Tool'),
                array('question_id' => 62, 'level_id' => 2, 'question' => 'Yes', 'answer' => 'Yes'),
                array('question_id' => 63, 'level_id' => 2, 'question' => 'No', 'answer' => 'No'),
                array('question_id' => 64, 'level_id' => 2, 'question' => 'Lie', 'answer' => 'Lie'),
                array('question_id' => 65, 'level_id' => 2, 'question' => 'Die', 'answer' => 'Die'),
                array('question_id' => 66, 'level_id' => 2, 'question' => 'Pie', 'answer' => 'Pie'),
                array('question_id' => 67, 'level_id' => 2, 'question' => 'Leg', 'answer' => 'Leg'),
                array('question_id' => 68, 'level_id' => 2, 'question' => 'Toe', 'answer' => 'Toe'),
                array('question_id' => 69, 'level_id' => 2, 'question' => 'Hoe', 'answer' => 'Hoe'),
                array('question_id' => 70, 'level_id' => 2, 'question' => 'Laze', 'answer' => 'Laze'),
                array('question_id' => 71, 'level_id' => 2, 'question' => 'Hair', 'answer' => 'Hair'),
                array('question_id' => 72, 'level_id' => 2, 'question' => 'Fur', 'answer' => 'Fur'),
                array('question_id' => 73, 'level_id' => 2, 'question' => 'Bow', 'answer' => 'Bow'),
                array('question_id' => 74, 'level_id' => 2, 'question' => 'Arc', 'answer' => 'Arc'),
                array('question_id' => 75, 'level_id' => 2, 'question' => 'View', 'answer' => 'View'),
                array('question_id' => 76, 'level_id' => 2, 'question' => 'Dig', 'answer' => 'Dig'),
                array('question_id' => 77, 'level_id' => 2, 'question' => 'Let', 'answer' => 'Let'),
                array('question_id' => 78, 'level_id' => 2, 'question' => 'Bath', 'answer' => 'Bath'),
                array('question_id' => 79, 'level_id' => 2, 'question' => 'Room', 'answer' => 'Room'),
                array('question_id' => 80, 'level_id' => 2, 'question' => 'Deep', 'answer' => 'Deep'),
                array('question_id' => 81, 'level_id' => 2, 'question' => 'Sea', 'answer' => 'Sea'),
                array('question_id' => 82, 'level_id' => 2, 'question' => 'Hat', 'answer' => 'Hat'),
                array('question_id' => 83, 'level_id' => 2, 'question' => 'Cap', 'answer' => 'Cap'),
                array('question_id' => 84, 'level_id' => 2, 'question' => 'Tie', 'answer' => 'Tie'),
                array('question_id' => 85, 'level_id' => 2, 'question' => 'Ball', 'answer' => 'Ball'),
                array('question_id' => 86, 'level_id' => 2, 'question' => 'Data', 'answer' => 'Data'),
                array('question_id' => 87, 'level_id' => 2, 'question' => 'Set', 'answer' => 'Set'),
                array('question_id' => 88, 'level_id' => 2, 'question' => 'Sin', 'answer' => 'Sin'),
                array('question_id' => 89, 'level_id' => 2, 'question' => 'Sick', 'answer' => 'Sick'),
                array('question_id' => 90, 'level_id' => 2, 'question' => 'Deer', 'answer' => 'Deer'),
                array('question_id' => 91, 'level_id' => 2, 'question' => 'Goat', 'answer' => 'Goat'),
                array('question_id' => 92, 'level_id' => 2, 'question' => 'Cow', 'answer' => 'Cow'),
                array('question_id' => 93, 'level_id' => 2, 'question' => 'Sow', 'answer' => 'Sow'),
                array('question_id' => 94, 'level_id' => 2, 'question' => 'Deer', 'answer' => 'Deer'),
                array('question_id' => 95, 'level_id' => 2, 'question' => 'Cat', 'answer' => 'Cat'),
                array('question_id' => 96, 'level_id' => 2, 'question' => 'Dog', 'answer' => 'Dog'),
                array('question_id' => 97, 'level_id' => 2, 'question' => 'Bird', 'answer' => 'Bird'),
                array('question_id' => 98, 'level_id' => 2, 'question' => 'Fish', 'answer' => 'Fish'),
                array('question_id' => 99, 'level_id' => 2, 'question' => 'Lock', 'answer' => 'Lock'),
                array('question_id' => 100, 'level_id' => 2, 'question' => 'Lamb', 'answer' => 'Lamb'),
                array('question_id' => 101, 'level_id' => 2, 'question' => 'Lamp', 'answer' => 'Lamp'),
                array('question_id' => 102, 'level_id' => 2, 'question' => 'All', 'answer' => 'All'),
                array('question_id' => 103, 'level_id' => 2, 'question' => 'Ant', 'answer' => 'Ant'),
                array('question_id' => 104, 'level_id' => 2, 'question' => 'Lion', 'answer' => 'Lion'),
                array('question_id' => 105, 'level_id' => 2, 'question' => 'Fool', 'answer' => 'Fool'),
                array('question_id' => 106, 'level_id' => 2, 'question' => 'Drug', 'answer' => 'Drug'),
                array('question_id' => 107, 'level_id' => 2, 'question' => 'Egg', 'answer' => 'Egg'),
                array('question_id' => 108, 'level_id' => 2, 'question' => 'Roe', 'answer' => 'Roe'),
                array('question_id' => 109, 'level_id' => 2, 'question' => 'Row', 'answer' => 'Row'),
                array('question_id' => 110, 'level_id' => 2, 'question' => 'Damp', 'answer' => 'Damp'),
                array('question_id' => 111, 'level_id' => 2, 'question' => 'Dump', 'answer' => 'Dump'),
                array('question_id' => 112, 'level_id' => 2, 'question' => 'Deal', 'answer' => 'Deal'),
                array('question_id' => 113, 'level_id' => 2, 'question' => 'Free', 'answer' => 'Free'),
                array('question_id' => 114, 'level_id' => 2, 'question' => 'Sit', 'answer' => 'Sit'),
                array('question_id' => 115, 'level_id' => 2, 'question' => 'Rat', 'answer' => 'Rat'),
                array('question_id' => 116, 'level_id' => 2, 'question' => 'Mole', 'answer' => 'Mole'),
                array('question_id' => 117, 'level_id' => 2, 'question' => 'Nail', 'answer' => 'Nail'),
                array('question_id' => 118, 'level_id' => 2, 'question' => 'Claw', 'answer' => 'Claw'),
                array('question_id' => 119, 'level_id' => 2, 'question' => 'Skin', 'answer' => 'Skin'),
                array('question_id' => 120, 'level_id' => 2, 'question' => 'Eye', 'answer' => 'Eye'),
                array('question_id' => 121, 'level_id' => 2, 'question' => 'Lash', 'answer' => 'Lash'),
                array('question_id' => 122, 'level_id' => 2, 'question' => 'Fish', 'answer' => 'Fish'),
                array('question_id' => 123, 'level_id' => 2, 'question' => 'Mutt', 'answer' => 'Mutt'),
                array('question_id' => 124, 'level_id' => 2, 'question' => 'Door', 'answer' => 'Door'),
                array('question_id' => 125, 'level_id' => 2, 'question' => 'Tile', 'answer' => 'Tile'),
                array('question_id' => 126, 'level_id' => 2, 'question' => 'Step', 'answer' => 'Step'),
                array('question_id' => 127, 'level_id' => 2, 'question' => 'Stop', 'answer' => 'Stop'),
                array('question_id' => 128, 'level_id' => 2, 'question' => 'Day', 'answer' => 'Day'),
                array('question_id' => 129, 'level_id' => 2, 'question' => 'Moon', 'answer' => 'Moon'),
                array('question_id' => 130, 'level_id' => 3, 'question' => 'Reading book', 'answer' => 'Reading book'),
                array('question_id' => 131, 'level_id' => 3, 'question' => 'Eating cake', 'answer' => 'Eating cake'),
                array('question_id' => 132, 'level_id' => 3, 'question' => 'Pipe down', 'answer' => 'Pipe down'),
                array('question_id' => 133, 'level_id' => 3, 'question' => 'Deep sleep', 'answer' => 'Deep sleep'),
                array('question_id' => 134, 'level_id' => 3, 'question' => 'Door to door', 'answer' => 'Door to door'),
                array('question_id' => 135, 'level_id' => 3, 'question' => 'Tile cracker', 'answer' => 'Tile cracker'),
                array('question_id' => 136, 'level_id' => 3, 'question' => 'Step up', 'answer' => 'Step up'),
                array('question_id' => 137, 'level_id' => 3, 'question' => 'Stop down', 'answer' => 'Stop down'),
                array('question_id' => 138, 'level_id' => 3, 'question' => 'Day off', 'answer' => 'Day off'),
                array('question_id' => 139, 'level_id' => 3, 'question' => 'Moon light', 'answer' => 'Moon light'),
                array('question_id' => 140, 'level_id' => 3, 'question' => 'Sun shine', 'answer' => 'Sun shine'),
                array('question_id' => 141, 'level_id' => 3, 'question' => 'Deep sea', 'answer' => 'Deep sea'),
                array('question_id' => 142, 'level_id' => 3, 'question' => 'Run amok', 'answer' => 'Run amok'),
                array('question_id' => 143, 'level_id' => 3, 'question' => 'Island to island', 'answer' => 'Island to island'),
                array('question_id' => 144, 'level_id' => 3, 'question' => 'Day by day', 'answer' => 'Day by day'),
                array('question_id' => 145, 'level_id' => 3, 'question' => 'Living hell', 'answer' => 'Living hell'),
                array('question_id' => 146, 'level_id' => 3, 'question' => 'Mad scientist', 'answer' => 'Mad scientist'),
                array('question_id' => 147, 'level_id' => 3, 'question' => 'Loony bard', 'answer' => 'Loony bard'),
                array('question_id' => 148, 'level_id' => 3, 'question' => 'Dumb merchant', 'answer' => 'Dumb merchant'),
                array('question_id' => 149, 'level_id' => 3, 'question' => 'Naked king', 'answer' => 'Naked king'),
                array('question_id' => 150, 'level_id' => 3, 'question' => 'Sleepy cow', 'answer' => 'Sleepy cow'),
                array('question_id' => 151, 'level_id' => 3, 'question' => 'Death door', 'answer' => 'Death door'),
                array('question_id' => 152, 'level_id' => 3, 'question' => 'Reader digest', 'answer' => 'Reader digest'),
                array('question_id' => 153, 'level_id' => 3, 'question' => 'Final judgement', 'answer' => 'Final judgement'),
                array('question_id' => 154, 'level_id' => 3, 'question' => 'Evil twin', 'answer' => 'Evil twin'),
                array('question_id' => 155, 'level_id' => 3, 'question' => 'Devil\'s luck', 'answer' => 'Devil\'s luck'),
                array('question_id' => 156, 'level_id' => 3, 'question' => 'Fear to tread', 'answer' => 'Fear to tread'),
                array('question_id' => 157, 'level_id' => 3, 'question' => 'Iron fist', 'answer' => 'Iron fist'),
                array('question_id' => 158, 'level_id' => 3, 'question' => 'Liar\'s due', 'answer' => 'Liar\'s due'),
                array('question_id' => 159, 'level_id' => 3, 'question' => 'Claypot rice', 'answer' => 'Claypot rice'),
                array('question_id' => 160, 'level_id' => 3, 'question' => 'Spam e-mail', 'answer' => 'Spam e-mail'),
                array('question_id' => 161, 'level_id' => 3, 'question' => 'Letter of marquee', 'answer' => 'Letter of marquee'),
                array('question_id' => 162, 'level_id' => 3, 'question' => 'Rogue trader', 'answer' => 'Rogue Trader'),
                array('question_id' => 163, 'level_id' => 3, 'question' => 'Wild quess', 'answer' => 'Wild quess'),
                array('question_id' => 164, 'level_id' => 3, 'question' => 'Trade warrant', 'answer' => 'Trade warrant'),
                array('question_id' => 165, 'level_id' => 3, 'question' => 'Secure routing', 'answer' => 'Secure routing'),
                array('question_id' => 166, 'level_id' => 3, 'question' => 'Document analysis', 'answer' => 'Document analysis'),
                array('question_id' => 167, 'level_id' => 3, 'question' => 'Requirement engineering', 'answer' => 'Requirement engineering'),
                array('question_id' => 168, 'level_id' => 3, 'question' => 'Time control', 'answer' => 'Time control'),
                array('question_id' => 169, 'level_id' => 3, 'question' => 'Illegal move', 'answer' => 'Illegal move'),
                array('question_id' => 170, 'level_id' => 3, 'question' => 'Pawn promotion', 'answer' => 'Pawn promotion'),
                array('question_id' => 171, 'level_id' => 3, 'question' => 'Bad mouth', 'answer' => 'Bad mouth'),
                array('question_id' => 172, 'level_id' => 3, 'question' => 'High roller', 'answer' => 'High roller'),
                array('question_id' => 173, 'level_id' => 3, 'question' => 'Raise the roof', 'answer' => 'Raise the roof'),
                array('question_id' => 174, 'level_id' => 3, 'question' => 'Hit the spot', 'answer' => 'Hit the spot'),
                array('question_id' => 175, 'level_id' => 3, 'question' => 'Buy the farm', 'answer' => 'Buy the farm'),
                array('question_id' => 176, 'level_id' => 3, 'question' => 'Green thumb', 'answer' => 'Green thumb'),
                array('question_id' => 177, 'level_id' => 3, 'question' => 'Sitting duck', 'answer' => 'Sitting duck'),
                array('question_id' => 178, 'level_id' => 3, 'question' => 'Not my cup of tea', 'answer' => 'Not my cup of tea'),
                array('question_id' => 179, 'level_id' => 3, 'question' => 'Excess baggage', 'answer' => 'Excess baggage'),
                array('question_id' => 180, 'level_id' => 3, 'question' => 'Fast food', 'answer' => 'Fast food'),
                array('question_id' => 181, 'level_id' => 3, 'question' => 'Low life', 'answer' => 'Low life'),
                array('question_id' => 182, 'level_id' => 3, 'question' => 'Know it all', 'answer' => 'Know it all'),
                array('question_id' => 183, 'level_id' => 3, 'question' => 'Sweet tooth', 'answer' => 'Sweet tooth'),
                array('question_id' => 184, 'level_id' => 3, 'question' => 'Zone out', 'answer' => 'Zone out'),
                array('question_id' => 185, 'level_id' => 3, 'question' => 'In a bind', 'answer' => 'In a bind'),
                array('question_id' => 186, 'level_id' => 3, 'question' => 'Jump ship', 'answer' => 'Jump ship'),
                array('question_id' => 187, 'level_id' => 3, 'question' => 'Cut a deal', 'answer' => 'Cut a deal'),
                array('question_id' => 188, 'level_id' => 3, 'question' => 'Ants in your pants', 'answer' => 'Ants in your pants'),
                array('question_id' => 189, 'level_id' => 3, 'question' => 'On cloud nine', 'answer' => 'On cloud nine'),
                array('question_id' => 190, 'level_id' => 4, 'question' => '1+1', 'answer' => '2'),
                array('question_id' => 191, 'level_id' => 4, 'question' => '5-7', 'answer' => '-2'),
                array('question_id' => 192, 'level_id' => 4, 'question' => '9+4', 'answer' => '13'),
                array('question_id' => 193, 'level_id' => 4, 'question' => '20-3', 'answer' => '17'),
                array('question_id' => 194, 'level_id' => 4, 'question' => '8-9', 'answer' => '-1'),
                array('question_id' => 195, 'level_id' => 4, 'question' => '7+8', 'answer' => '15'),
                array('question_id' => 196, 'level_id' => 4, 'question' => '3+2', 'answer' => '5'),
                array('question_id' => 197, 'level_id' => 4, 'question' => '4+4', 'answer' => '8'),
                array('question_id' => 198, 'level_id' => 4, 'question' => '4-4', 'answer' => '0'),
                array('question_id' => 199, 'level_id' => 4, 'question' => '2+7', 'answer' => '9'),
                array('question_id' => 200, 'level_id' => 4, 'question' => '1+11', 'answer' => '12'),
                array('question_id' => 201, 'level_id' => 4, 'question' => '25-7', 'answer' => '18'),
                array('question_id' => 202, 'level_id' => 4, 'question' => '9-5', 'answer' => '4'),
                array('question_id' => 203, 'level_id' => 4, 'question' => '5+9', 'answer' => '14'),
                array('question_id' => 204, 'level_id' => 4, 'question' => '8-10', 'answer' => '-2'),
                array('question_id' => 205, 'level_id' => 4, 'question' => '7+9', 'answer' => '16'),
                array('question_id' => 206, 'level_id' => 4, 'question' => '3+0', 'answer' => '3'),
                array('question_id' => 207, 'level_id' => 4, 'question' => '0-3', 'answer' => '-3'),
                array('question_id' => 208, 'level_id' => 4, 'question' => '4+18', 'answer' => '22'),
                array('question_id' => 209, 'level_id' => 4, 'question' => '2-7', 'answer' => '-5')
            ));

        $original_directory = 'typing_defense';
        $module_url = $this->cms_module_path();
        $module_main_controller_url = '';
        if($module_url != $original_directory){
        	$module_main_controller_url = $module_url.'/'.$original_directory;
        }else{
        	$module_main_controller_url = $module_url;
        }

        $this->cms_add_navigation("typedef_index","Typing Defense", $module_main_controller_url."/index", 3);
        $this->cms_add_navigation("typedef_level", "Level Management", $module_main_controller_url."/level", 4, "typedef_index");
        $this->cms_add_navigation("typedef_question", "Question Management", $module_main_controller_url."/question", 4, "typedef_index");
    }
}

?>
