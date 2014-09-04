<?
if(isset($_COOKIE['ds_reg_id'])) {
	$us=gl::$db->dessoc_reg[$_COOKIE['ds_reg_id']];
	
	if($us) {
		$pQuest=gl::$db->dessoc_questions[array(
			'individual'=>1,
			'dessoc_reg_id'=>(int)$us['id'],
			'dessoc_id'=>CURRENT_SOC
			)];
		// var_dump($pQuest);
		if($pQuest) {
			?>
			  <fieldset>
			    <legend>Персональный вопрос (будет только к вашей анкете)</legend>
			    Вопрос:
			    <span><b><?=$pQuest['question'];?></b></span>
			    <div class="answers_ready">
			    	<?
			    	$anwers=unserialize($pQuest['answers']);
			    	// var_dump($anwers);
			    	foreach ($anwers as $key => $value) {
			    		echo ($key+1).') '.$value.'<br/>';
			    	}
			    	?>
			    </div>
			    <?
			    if($pQuest['aproved']!=1) {
			    	?><button class="btn" onclick="$.post('/stage1/pquestion',{'act':'delPQ'},function(data){$('.questionLayar').html(data);},'text');">Удалить</button><?
			    }
			    ?>
			  </fieldset>
			<?

		} else {
			?>
			  <fieldset>
			    <legend>Персональный вопрос (будет только к вашей анкете)</legend>
			    <label>Вопрос</label>
			    <input type="text" name="question" class="input-xxlarge pquestionInput" placeholder="Вопрос">
			    <!--span class="help-block">Example block-level help text here.</span-->
			    <div class="answers"></div>
			    <label>
			      <input type="text" class="input-small pQuest_answer" placeholder="Ответ" onchange="addanswer();"> <button class="btn savePQuest" onclick="addanswer();">Добавить ответ</button>
			    </label>
			    <button class="savePQuest btn" onclick="saveQuestion();">Сохранить</button>
			  </fieldset>
			  <script>
			  drawAnswers();
			  </script>
			<?
		}
	}
} else {
	echo 'Auth false';
}
?>