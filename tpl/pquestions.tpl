{% extends "main.tpl" %}
{% block aditioncss %}
<style></style>
{% endblock %}
{% block contaner %}

<div class="question_content">
	{% include 'pquestion_items.tpl' %}
</div>
{% endblock %}
{% block endJS %}
<script>
var pQuest_answers=['Недостаточно знаком'];
function addanswer(){
	var ans=$('.pQuest_answer').val();
	if(ans.length>0) {
		pQuest_answers.push(ans);
		$('.pQuest_answer').val('');
		drawAnswers();
	}
};
function saveQuestion() {
	var q=$('.pQuestionInput').val();
	if(q.length>0 && pQuest_answers.length>2) {
		$.post('',{
			'act':'addQuestion',
			'q':q,
			'block':$('.pBlockInput').val(),
			'answ':pQuest_answers
		},function(data){
			$('.question_content').html(data);
		},'text');
		$('.pQuestionInput').val('');
	}
}
function drawAnswers() {
	var txt='';
	if(pQuest_answers.length>0) {
		for (var i = 0; i < pQuest_answers.length; i++) {
			txt+=(i+1)+') '+pQuest_answers[i]+(i>0?' <b class="icon-remove" onclick="removeAnswer('+i+');"></b>':'')+'<br/>';
		};
	}
	$('.answers').html(txt);
}
function removeAnswer(i) {
	if(i>0) {
		pQuest_answers.splice(i,1);
		drawAnswers();
	}
}
drawAnswers();
</script>
{% endblock %}