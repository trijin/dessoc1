<?
// echo '1';
if(@(int)$_SESSION['s3_pass_id']>0) {
	if(gl::$currentSoc['stage']!=3) {
		$app->view->appendData(array('centralMessage' => 'Доступ к опросу получен<br/><small>Ожидайте этапа Опроса</small>'));
		$app->render('main.tpl');
	} else {
		// echo '1';
		$us=gl::$db->dessoc_hashes[(int)$_SESSION['s3_pass_id']];
		// echo '2';
		if(strlen(gl::$currentSoc['accept_rule'])>0 && $us['accept']!=1) {
			// echo '1';
			$app->view->appendData(array(
				'dessoc' => gl::$currentSoc,
				));
			$app->render('accept.tpl');
		} else {
			$selectedId=0;

			if($us['all_done']==0) {

				// $generateUserFor
				// $totalQuestions
				$totalQuestions=gl::$db->dessoc_questions->where(array('individual'=>0,'dessoc_id'=>CURRENT_SOC))->count();
				$totalIndividual=gl::$db->dessoc_questions->where(array('individual'=>1,'dessoc_id'=>CURRENT_SOC,'aproved'=>'1'))->where('dessoc_reg_id>0')->select('COUNT(*) as cnt, dessoc_reg_id')->group('dessoc_reg_id')->fetchPairs('dessoc_reg_id');
				// var_dump((string)$totalQuestions);
				foreach ($totalIndividual as $key => $value) {
					$totalIndividual[$key]=$totalIndividual[$key]['cnt'];
				}
				// var_dump($totalIndividual);
				$totalAnswersDb=gl::$db->dessoc_reg->
					group('dessoc_answers:dessoc_hashes_id, dessoc_reg.id')->
					select('dessoc_reg.id, dessoc_answers:dessoc_hashes_id, COUNT(dessoc_answers:dessoc_questions_id) as cnt')->
					join('dessoc_answers','(dessoc_reg_id=dessoc_reg.id AND dessoc_hashes_id='.(int)$_SESSION['s3_pass_id'].')')->order('RAND()');
				// var_dump((string)$totalAnswersDb);
				// $totalAnswers=$totalAnswers->fetchPairs('id');
				// var_dump($totalAnswersDb);
				$selectedId=0;
				foreach ($totalAnswersDb as $key => $value) {
					if($value['cnt']==$totalQuestions+@$totalIndividual[$value['id']]) {
						continue;
					}
					$selectedId=$value['id'];
					$totalAnswers=(int)$value['cnt'];
					break;
				}
			}

			if($selectedId>0) {
				$rows=gl::$db->dessoc_questions->where(array('dessoc_id'=>CURRENT_SOC,'dessoc_reg_id'=>array(0,$selectedId),'aproved'=>'1'))->select('dessoc_questions_block.*, dessoc_questions.*')->order('individual, dessoc_questions_block_id, dessoc_questions.id');
				// var_dump((string)$rows);
				$questions=array();
				foreach ($rows as $key => $row) {
					foreach ($row as $k => $v) {
						$questions[$key][$k]=$v;
					}
					$questions[$key]['answers']=unserialize($row['answers']);
				}
				if($totalAnswers>0) {
					$answers=gl::$db->dessoc_answers->where(array('dessoc_hashes_id'=>(int)$_SESSION['s3_pass_id'],'dessoc_reg_id'=>(int)$selectedId))->fetchPairs('dessoc_questions_id');
					foreach ($answers as $key => $value) {
						$questions[$value['dessoc_questions_id']]['answer']=$value['answer'];
					}
				} else {
					$answers=array();
				}

				$app->view->appendData(array(
					'user' => gl::$db->dessoc_reg[$selectedId],
					'questions' => $questions,
					// 'answers' => $answers,
					));
				$app->render('stage3.tpl');

			} else {
				if($us['all_done']==0) {
					$us['all_done']=1;
					$us->update();
				}
				$app->view->appendData(array('centralMessage' => 'Вы закончили Опрос'));
				$app->render('main.tpl');
			}
		}
	}
} else {
	// echo '2';
	$app->view->appendData(array('centralMessage' => 'Необходима авторизация по уникальной ссылке'));
	$app->render('main.tpl');	
}
?>