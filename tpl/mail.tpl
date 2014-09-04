{% import "macros.tpl" as utils %}
<table cellpadding="0" class="preview" cellspacing="0" width="100%" border="0" bgcolor="#ffffff" style="min-width:600px;">
	<tr>
		<td valign="top" align="center">
			<table cellspacing="0" cellpadding="0" width="560" border="0" style="border-width:1px;border-color:#57c6df;border-style:solid;" bgcolor="#ffffff" class="campaign">
				<tr>
					<td align="center" width="560">
						<table border="0" cellspacing="0" width="560" style="background-color:#57c6df">
							<tr>
								<td class="space" width="20"></td>
								<td height="30" width="520" class="headinsmall"></td>
								<td class="space" width="20"></td>
							</tr>
							<tr>
							<td width="20" class="space"></td>
								<td width="520" class="headin" align="center" style="line-height:normal; font-weight: bold;font-family:Arial, Helvetica, sans-serif;font-size:28px;color:#004155;">DespeRados Sociometry</td>
								<td width="20" class="space"></td>
							</tr>
							<tr>
							<td width="20" class="space"></td>
								<td width="520" height="10" class="headinsmall" align="center"></td>
								<td width="20" class="space"></td>
							</tr>
							<tr>
							<td width="20" class="space"></td>
								<td width="520" class="headinsmall" align="center" style="line-height:normal; font-weight: bold;font-family:Arial, Helvetica, sans-serif;font-size:16px;color:#ffffff;">готовы узнать больше?</td>
								<td width="20" class="space"></td>
							</tr>
							<tr>
							<td width="20" class="space"></td>
								<td width="520" height="30" class="headinsmall" align="center"></td>
								<td width="20" class="space"></td>
							</tr>
						</table>
						<table width="560" border="0" cellspacing="0" cellpadding="0" class="headcontent">
							<tr>
								<td width="560" height="20" class="headcontent"></td>
							</tr>
						</table>
						<table width="520" border="0" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<td width="520" style="border-top-width:1px;border-color:#e2d9d2;border-top-style:solid; " class="cell">
									<table width="520" border="0" cellspacing="0" cellpadding="0" class="table">
										<tr>
											<td width="520" height="20" class="row"> </td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<table width="520" border="0" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<td width="300" align="left" style="color:#464646;font-family:Verdana, Geneva, sans-serif;line-height:22px;font-size:16px;font-weight:bold;" class="cell">{{ user.name }}</td>
								<td rowspan="2" width="220" align="center" style="color:#464646;font-family:Verdana, Geneva, sans-serif;line-height:22px;font-size:16px;font-weight:bold;" class="cell">
									{% if urlimage|length > 0 %}
										<img border="0" src="{{ urlimage }}" width="200"/>
									{% else %}
										нет фото
									{% endif %}
								</td>
							</tr>
							<tr>
								<td width="300" align="left" style="color:#464646;font-family:Verdana, Geneva, sans-serif;line-height:22px;font-size:16px;font-weight:bold;" class="cell">{{ user.nick }}</td>
							</tr>
							<tr>
								<td width="520" height="13" class="cell"></td>
							</tr>
						</table>
						{% if dessoc is defined and dessoc.result_text is defined and dessoc.result_text|length > 0 %}
						<table width="560" border="0" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<td width="20"> </td>
								<td width="520" align="left" valign="top" style="color:#696969;font-family:Arial, Helvetica, sans-serif;line-height:20px;font-size:16px;" class="cell">
									{{ dessoc.result_text|raw }}
								</td>
								<td width="20"> </td>
							</tr>
							<tr>
								<td width="20"> </td>
								<td width="520" height="10" class="spacer"></td>
								<td width="20"> </td>
							</tr>
						</table>
						{% endif %}
						<table width="520" border="0" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<td width="520" style="border-top-width:1px;border-color:#e2d9d2;border-top-style:solid; " class="cell">
									<table width="520" border="0" cellspacing="0" cellpadding="0" class="table">
										<tr>
											<td width="520" height="20" class="row"> </td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
				{% set qblock = '0' %}
				{% for question in questions %}
					{% if qblock != question.dessoc_questions_block_id %}
						{% if question.dessoc_questions_block_id > 0 %}
						<table width="520" border="0" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<td width="520" align="left" style="color:#00a851;font-family:Arial, Helvetica, sans-serif;line-height:28px;font-size:22px;font-weight:bold;" class="cell">{{ question.block_name}}</td>
							</tr>
							<tr>
								<td width="520" height="14" class="cell"></td>
							</tr>
						</table>
						{% else %}
						<table width="520" border="0" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<td width="520" style="border-top-width:1px;border-color:#e2d9d2;border-top-style:solid; " class="cell">
									<table width="520" border="0" cellspacing="0" cellpadding="0" class="table">
										<tr>
											<td width="520" height="20" class="row"> </td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						{% endif %}
						{% set qblock = question.dessoc_questions_block_id %}
					{% endif %}
						<table width="520" border="0" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<td width="520" align="left" style="color:#464646;font-family:Verdana, Geneva, sans-serif;line-height:22px;font-size:16px;font-weight:bold;" class="cell">{{ question.question }}</td>
							</tr>
							<tr>
								<td width="520" height="13" class="cell"></td>
							</tr>
						</table>
						<table width="560" border="0" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<td width="20"> </td>
								<td width="520" align="left" valign="top" style="color:#696969;font-family:Arial, Helvetica, sans-serif;line-height:20px;font-size:14px;" class="cell">
									<ul>
										{% for answer in question.answers %}
											<li>{{ answer }} {% if attribute(answers, question.id) is defined and attribute(attribute(answers, question.id), loop.index0) is defined %}
												<b> — {{ utils.declension( attribute(attribute(answers, question.id), loop.index0), ['ответил','ответило','ответило']) }} {{ attribute(attribute(answers, question.id), loop.index0) }} {{ utils.declension( attribute(attribute(answers, question.id), loop.index0), ['человек','человека','человек']) }}</b>
											{% endif %}
											</li>
										{% endfor %}
									</ul>
								</td>
								<td width="20"> </td>
							</tr>
							<tr>
								<td width="20"> </td>
								<td width="520" height="10" class="spacer"></td>
								<td width="20"> </td>
							</tr>
						</table>
				{% endfor %}
					</td>
				</tr>
			</table>
			<table width="560" border="0" cellspacing="0" cellpadding="0" class="pfooter">
				<tr>
					<td height="15" width="560" class="pfooter"></td>
				</tr>
				<tr>
					<td width="560" align="center" style="font-family:Arial;font-size: 11px;color:#696969;font-family:Arial, Helvetica, sans-serif;font-size:11px;" class="pfooter">
				  	2014 © <b>trijin</b> &amp; <b>OS zla</b> | <a href="http://dessoc.myexg.ru/">http://dessoc.myexg.ru/</a>
				  </td>
				</tr>
				<tr>
				<td height="10" width="560" class="pfooter"></td>
				</tr>
				<tr>
					<td class="pfooter" style="font-family:Arial;font-size: 11px;color:#696969;font-family:Arial, Helvetica, sans-serif;font-size:11px;" width="560" align="center">
						Вы получили это письмо потомучто указали этот адрес <b>{{ user.email }}</b>  при регистрации на опрос на сайте http://dessoc.myexg.ru/
				  </td>
				</tr>
				<tr>
					<td height="10" class="pfooter" width="560"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>