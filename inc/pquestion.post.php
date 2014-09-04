<?
if(isset($_POST['act']) && isset($_COOKIE['ds_reg_id'])) {
	switch ($_POST['act']) {
		case 'addPQ':
				if(isset($_POST['q']) && isset($_POST['answ']) && strlen($_POST['q'])>3 && count($_POST['answ'])>2) {
					$qc=gl::$db->dessoc_questions->where(array(
							'individual'=>1,
							'dessoc_reg_id'=>(int)$_COOKIE['ds_reg_id'],
						))->count();
					if($qc==0) {
						gl::$db->dessoc_questions->insert(array(
							'question'=>strip_tags($_POST['q']),
							'individual'=>1,
							'dessoc_reg_id'=>(int)$_COOKIE['ds_reg_id'],
							'answers'=>serialize($_POST['answ']),
							'dessoc_id'=>CURRENT_SOC
							));
					}
				}
			break;
		case 'delPQ':
				$pQuest=gl::$db->dessoc_questions[array(
					'individual'=>1,
					'dessoc_reg_id'=>(int)$_COOKIE['ds_reg_id'],
					'dessoc_id'=>CURRENT_SOC,
					'aproved'=>array(0,-1),
					)];
				if($pQuest) {
					$pQuest->delete();
				}

			break;
	}
}
$app->redirect('/stage1/pquestion');
?>