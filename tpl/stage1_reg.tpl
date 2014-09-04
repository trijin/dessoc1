{% extends "main.tpl" %}
{% block aditioncss %}
<style>
	table,input {
		font-size:22px;
		line-height: 24px;
		vertical-align: top;
	}
</style>
{% endblock %}
{% block contaner %}
	<center>
		<h2>Регистрация на DesСоцОпрос</h2>
		{{ myerror|raw }}
		<form method="post" enctype="multipart/form-data">
			<table border="0" cellpadding="5" cellspacing="5">
				<tr>
					<td align="right">Имя Фамилия:</td>
					<td align="left"><input type="text" name="name" request/></td>
				</tr>
				<tr>
					<td align="right">никнейм:<br/><small><i>для лучшей идентификации</i></small></td>
					<td align="left"><input type="text" name="nick" request/></td>
				</tr>
				<tr>
					<td align="right">Почта:</td>
					<td align="left"><input type="email" name="email" request/></td>
				</tr>
				<tr>
					<td align="right" valign="top">фото:</td>
					<td align="left">
						<input type="text" name="photo_link" placeholder="Урл на фото"/><br/>
						<input type="file" name="photo_file"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" value="Регистрация"/></td>
				</tr>
			</table>
			</form>
	</center>
{% endblock %}