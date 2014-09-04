{% extends "main.tpl" %}
{% block aditioncss %}
<style>
	table,input {
		font-size:22px;
		line-height: 24px;
		vertical-align: top;
	}
	.rule {
		text-indent: 20px;
		width: 60%;
		text-align: left;
		line-height: 18px;
		font-size: 16px;
	}
	.buttonBlock {
		margin:40px;
		width: 50%;
	}

</style>
{% endblock %}
{% block contaner %}
<center>
<h1>Условия</h1>
	<div class="rule">{{ dessoc.accept_rule|raw }}</div>
	<div class="buttonBlock">
		<button class="btn btn-large btn-block btn-primary" onclick="$.post('/stage3/accept/yes',{'accept':'yes'},'script');">Принимаю</button>
		<button class="btn btn-large btn-block" onclick="$.post('/stage3/accept/no',{'accept':'no'},'script');">Отказываюсь</button>
	</div>
</center>
{% endblock %}
{% block endJS %}

{% endblock %}