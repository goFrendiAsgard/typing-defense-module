<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>modules/<?php echo $cms["module_path"]; ?>/assets/css/style.css" />
    <script type="text/javascript" src ="<?php echo base_url().'assets/nocms/js/jquery.js';?>"></script>
    <script type="text/javascript">
		    var DATA = null;
		    var WRONG_PENALTY = 5;
		    var CORRECT_POINT = 10;
		    var INTERVAL = 1000;
		    var SPEED = 5;
		    var COLLATION_PENALTY = 50;
		    var WIN_SCORE = 1000;
		    var GAME_OVER = false;
		
		    $(document).ready(function(){
		        // Getting screen resolutions and positioning the start button
		        var width = screen.width - 100;
		        var height = screen.height - 200;
		        var score = 0;
		        var timer = "";
		        
		        $('#start').css({ 
		            "top" : (height/2 - $('#start').height()/2)+'px', 
		            "left" : (width/2 - $('#start').width()/2)+'px' 
		        });

		        $('#end').css({ 
		            "top" : (height/2 - $('#end').height()/2)+'px', 
		            "left" : (width/2 - $('#end').width()/2)+'px' 
		        });
		        
		        $('#word').css({ 
		            "top" : (height/2 - $('#word').height()/2)+'px', 
		            "left" : (width/2 - $('#word').width()/2)+'px' 
		        });

		        $('#end').click( function(){
		        	window.location = '<?php echo site_url($cms['module_path']."/typing_defense/index");?>';
		        });
		
		        $('#start').click( function(){
			        $.ajax({
						"url":"<?php echo site_url($cms['module_path']."/typing_defense/json_start_game/".$level) ?>",
						"dataType":"json",
						"success":function(response){
							DATA = response["data"];
							WRONG_PENALTY = response["wrong_penalty"];
							COLLATION_PENALTY = response["collation_penalty"];
							INTERVAL = response["interval"];
							SPEED = response["speed"];
							WIN_SCORE = response["win_score"];
							$('#start').fadeOut('slow');
				            $('#score').show();
				            $('#word').show(); 
				            $('#word').focus();       
				            timer = setInterval(on_timer, 100) 
				            genLetter();
						},
					    "error":function(response){
						    alert(response);
					    }   
					});
		            
		        });
		
		        // Dealing KeyEvents and fading out matched bubble
		        $('#word').keyup(function(event){
		            var word = $('#word').val();
		            var delta_score = 0;
		            var wrong = true;
		            for(var i=0; i<DATA.length; i++){
		                if(DATA[i][2]>0){
		                    var correct_word = DATA[i][1];
		                    if(word==correct_word){
		                        $('.bubb'+i).fadeOut('slow').hide( 'slow');
		                        $('.bubb'+i).remove();  
		                        delta_score += CORRECT_POINT * DATA[i][2];
		                        DATA[i][2] = 0;
		                        wrong = false;  
		                        $('#word').val('');
		                    }else if(correct_word.indexOf(word)==0){
		                        wrong = false;
		                    }
		                }
		            }
		            if(wrong){
		                delta_score -= WRONG_PENALTY;
		                $('#word').val('');
		            }
		            if(delta_score!=0){
		                score += delta_score;
		                display_score(score);
		            }
		            
		        });

		        function display_score(newScore){
		        	if(newScore<0){
	                	$('#score').html('0');
	                }else if(newScore>WIN_SCORE){
						$('#score').html(WIN_SCORE);
			        }else{
	                	$('#score').html(newScore);
			        }
				}
		        
		        function on_timer(){
		            var top_target = height/2;
		            var left_target = width/2;
		            $(".bubb").each(function(){
		                var top = $(this).css("top");
		                top = top.slice(0, top.length-2);
		                top = parseInt(top);
		                var left = $(this).css("left");
		                left = left.slice(0, left.length-2);
		                left = parseInt(left);
		                
		                var delta_y = top_target - top;
		                var delta_x = left_target - left;
		                var delta = Math.sqrt(Math.pow(delta_y,2)+Math.pow(delta_x,2));
		                
		                //if delta <20 then explode
		                if(delta<20){
		                    score -= COLLATION_PENALTY
		                    $(this).remove();
		                    display_score(score);
		                }
		                
		                if (score<0){
		                    //$("#board").html('<div class="gameover">You loose</div>');
		                    $("#end").html('You Loose');
		                    GAME_OVER = true;
		                }else if (score>=WIN_SCORE){
		                    //$("#board").html('<div class="gameover">You Win</div>');
		                    $("#end").html('You Win');
		                    GAME_OVER = true;
		                }
		                if(GAME_OVER){
			                $.ajax({
			                	"url":"<?php echo base_url(); ?>typing_defense/json_end_game/<?php echo $level; ?>",
								"type":"POST",
			                	"data":{
				                	"score" : score
			                	}
					        });
		                    window.clearInterval(timer);
		                    $("#end").show();
		                    $("#word").hide();
		                    $('.bubb').fadeOut('slow').hide( 'slow');
	                        $('.bubb').remove();
		                }
		                
		                delta_y = Math.round(delta_y * SPEED/delta);
		                delta_x = Math.round(delta_x * SPEED/delta);
		                
		                $(this).css("top", top+delta_y);
		                $(this).css("left", left+delta_x);
		            });      
		        }
		
		        // Generating bubble
		        function genLetter(){
		            if(GAME_OVER){
		                return false;
		            }
		            var k = Math.round(Math.random()*(DATA.length-1));
		            var content = DATA[k][0];
		            var top = 0;
		            var left = 0;
		            var decission = Math.round(Math.random());
		            if(decission == 0){
		                decission = Math.round(Math.random());
		                if(decission == 0){
		                    top = 0;
		                }else{
		                    top = height;
		                }
		                left = Math.floor(Math.random() * width );
		            }else{
		                decission = Math.round(Math.random());
		                if(decission == 0){
		                    left = 0;
		                }else{
		                    left = width;
		                }
		                top = Math.floor(Math.random() * height );
		            }
		            $('#board').append(
				            '<span class="bubb bubb'+ k +'" style="left: '+ left +'; top: '+ top +';">'+
				            '<img width="80px" src="<?php echo site_url('modules/'.$cms['module_path']."/assets/images/asteroid.gif");?>" />'+ 
				            	content +
				            '</span>'
				    	);
		            DATA[k][2] +=1;
		            setTimeout(genLetter,INTERVAL);
		        }
		        
		    });
    		
    </script>
</head>
<body>
    <div id="board">
        <div id="score">0</div> 
        <div id="start">Start</div>
        <input id="word" type="text" />
        <div id="end">End</div>
    </div>    
</body>
</html>
