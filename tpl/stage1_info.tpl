{% extends "main.tpl" %}
{% block aditioncss %}
<style>
	table,input {
		font-size:22px;
		line-height: 24px;
		vertical-align: top;
	}
	.answers .icon-remove {
		cursor: pointer;
	}
</style>
{% endblock %}
{% block contaner %}
<center>
	<h2>Регистрация на DesСоцОпрос</h2>
	<table border="0" cellpadding="5" cellspacing="5">
		<tr>
			<td align="right">Имя Фамилия:</td>
			<td align="left">{{ user.name }}</td>
		</tr>
		<tr>
			<td align="right">никнейм:<br/><small><i>для лучшей идентификации</i></small></td>
			<td align="left">{{ user.nick }}</td>
		</tr>
		<tr>
			<td align="right">Почта:</td>
			<td align="left">{{ user.email }}</td>
		</tr>
		<tr>
			<td align="right" valign="top">фото:</td>
			<td align="left">
				{% if user.photo_link|length > 0 %}
					<img border="0" src="{{ user.photo_link }}">
				{% else %}
					нет фото
				{% endif %}
			</td>
		</tr>
		<tr>
			<td align="left" class="questionLayar" colspan="2"></td>
		</tr>
		{% if ds.stage == 4 %}
			<tr>
				<td align="center" class="buttonLayar" colspan="2">
					<button class="btn btn-large btn-block" style="width:50%" onclick="$.post('/stage1/showres',{'act':'change'},'script');">{% if user.show_my_result == 1 %}<b class="icon-check"></b> Результаты: показываются
					{% else %}<b class="icon-unchecked"></b> Результаты: не показываются
					{% endif %}</button>
				</td>
			</tr>
		{% endif %}
	</table>
</center>
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
	var q=$('.pquestionInput').val();
	if(q.length>0 && pQuest_answers.length>2) {
		$.post('/stage1/pquestion',{
			'act':'addPQ',
			'q':q,
			'answ':pQuest_answers
		},function(data){
			$('.questionLayar').html(data);
		},'text');
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
$('.questionLayar').load('/stage1/pquestion');
</script>
{% endblock %}