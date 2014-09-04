<?

$app->view->appendData(array('questions_status' => array(-1=>'Отклонен',0=>'Ожидает модерации',1=>'Принят')));
if($app->request->isAjax()) {
	if(isset($_POST['act'])) {
		switch ($_POST['act']) {
			case 'aprove':
					$row=gl::$db->dessoc_questions[array('id'=>(int)$_POST['qid'],'dessoc_id'=>CURRENT_SOC,'individual'=>1)];
					if($row) {
						$row['aproved']=1;
						$row->update();
					}
				break;
			case 'notaprove':
					$row=gl::$db->dessoc_questions[array('id'=>(int)$_POST['qid'],'dessoc_id'=>CURRENT_SOC,'individual'=>1)];
					if($row) {
						$row['aproved']=-1;
						$row->update();
					}
				break;
			case 'addQuestion':
			case 'addQuestion':
			case 'addQuestion':
				if(isset($_POST['q']) && isset($_POST['answ']) && strlen($_POST['q'])>3 && count($_POST['answ'])>2) {
					$block=false;
					if(isset($_POST['block']) && strlen($_POST['block'])>3) {
						$block=gl::$db->dessoc_questions_block[array('block_name'=>trim(strip_tags($_POST['block'])))];
						if(!$block) {
							$block=gl::$db->dessoc_questions_block->insert(array('block_name'=>trim(strip_tags($_POST['block']))));
						}
					}
					if(!$block) {
						$block=array('id'=>0,'block_name'=>'');
					}

					gl::$db->dessoc_questions->insert(array(
						'question'=>trim(strip_tags($_POST['q'])),
						'individual'=>0,
						'dessoc_reg_id'=>0,
						'aproved'=>1,
						'answers'=>serialize($_POST['answ']),
						'dessoc_id'=>CURRENT_SOC,
						'dessoc_questions_block_id'=>$block['id']
						));



				}
				break;
		}
		$app->redirect('/stage0/pquestions');
	} elseif($app->request->isGet()) {
		$rows=gl::$db->dessoc_questions->where(array('dessoc_id'=>CURRENT_SOC,'individual'=>1))->select('dessoc_questions_block.*, dessoc_reg.*, dessoc_questions.*')->order('dessoc_questions.id');
		// echo (string)$rows;
		$questions=array();
		foreach ($rows as $key => $row) {
			foreach ($row as $k => $v) {
				$questions[$key][$k]=$v;
			}
			$questions[$key]['answers']=unserialize($row['answers']);
		}
		$app->view->appendData(array('questions' => $questions));
		$app->render('pquestion_items.tpl');
	}

} else {
	$rows=gl::$db->dessoc_questions->where(array('dessoc_id'=>CURRENT_SOC,'individual'=>1))->select('dessoc_questions_block.*, dessoc_reg.*, dessoc_questions.*')->order('dessoc_questions.id');
	// echo (string)$rows;
	$questions=array();
	foreach ($rows as $key => $row) {
		foreach ($row as $k => $v) {
			$questions[$key][$k]=$v;
		}
		$questions[$key]['answers']=unserialize($row['answers']);
	}
	$app->view->appendData(array('questions' => $questions));
	$app->render('pquestions.tpl');
}
?>