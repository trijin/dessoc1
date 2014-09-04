<!DOCTYPE html>
<html lang="ru">
  <head>
    <title>{% if headTitle is defined %}{{ headTitle }}{% else %}{% block title %}{% endblock %}{% endif %} DespeRados Sociometry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    {# <meta name="verify-reformal" content="74208afa67a707e43206c70e" /> #}
    <!-- Bootplus -->
    <link href="/css/bootplus.min.css" rel="stylesheet" media="screen">
    <link href="/css/bootplus-responsive.min.css" rel="stylesheet" media="screen">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/css/font-awesome.min.css">
    <style>

    body {
      /*padding-top: 20px;*/
      padding-bottom: 60px;
      background-color: #FFF;
    }

    /* Custom container */
    .container {
      margin: 0 auto;
      max-width: 1000px;
      min-height: 100%;
    }
    .container > hr {
      margin: 60px 0;
    }

    /* Main marketing message and sign up button */
    .jumbotron {
      margin: 80px 0;
      text-align: center;
      min-height: 100%;
      vertical-align: middle;
    }
    .jumbotron h1 {
      font-size: 70px;
      /*margin-top:40%;*/
      line-height: 1;
      font-family: Arial;
	    font-weight: bold;
    }
    .jumbotron .lead {
      font-size: 24px;
      line-height: 1.25;
    }
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .page-wrapper {
        min-height: 100%;
        margin-bottom: -50px;
    }
    * html .page-wrapper {
        height: 100%;
    }
    .page-buffer {
        height: 50px;
    }
    </style>
    <!--[if IE 7]>
    <link rel="stylesheet" href="/css/bootplus-ie7.min.css">
    <![endif]-->
    {% block aditioncss %}
    {% endblock %}
  </head>
  <body>
  	<div class="page-wrapper">
    <div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <div class="container-fluid">
          <span class="brand">DesSoc</span>
        </div>
      </div>
    </div>
  	
  	<div class="container">
  	{% block contaner %}
  	<header class="jumbotron">
  		{% if flash is defined %}
  		  {% for t,m in flash %}
  		  <div class="alert alert-{{ t }}">
  		    <button type="button" class="close" data-dismiss="alert">&times;</button>
  		    <strong>{{ t|capitalize }}!</strong> {{ m }}
  		  </div>
  		  {% endfor %}
  		{% endif %}
  	  <!-- <div class="inner"> -->
  	  	<h1>{% if centralMessage is defined %}{{ centralMessage|raw }}{% else %}DespeRados Sociometry{% endif %}</h1>
  	  <!-- </div> -->
  	</header>
  	{% endblock %}
  	</div> <!-- /container -->
  	<div class="page-buffer"></div>
  	</div>
  	<div class="page-footer">
  		<div class="container">
  			&copy; 2014 trijin <br>{#<button onclick="TogetherJS(this); return false;">Start TogetherJS</button>#}<br>
  		</div>
  	</div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    {% block endJS %}
    {% endblock %}
  </body>
</html>