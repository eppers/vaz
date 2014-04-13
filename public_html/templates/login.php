{% extends 'layout.php' %}
  
{% block page_title %}Logowanie{% endblock %}
  
{% block content %}
<div style="margin: 0 auto; text-align: center;">
                <div id="page-top">
                    <h1>Logowanie</h1>
                </div>
 
                <div id="" >
                    <div class="title">Logowanie</div>
                    <div class="content">
                        {{info}}{{login}}{{pass}}
                        <form action="/logowanie" method="post" style="text-align: center; float: none; margin: 0 auto;" >
                        <p>
                                    <label for="title">Login: </label><br />
                                    <input type="text" name="login" value="" id="login" />
                            </p>
 
                            <p>
                                    <label for="author">Hasło: </label><br />
                                    <input type="password" name="password" value="" id="password" />
                            </p>
                            <p>
                                    <input type="submit" value="Zaloguj" />
                            </p>
                        </form>
                    </div>
                </div>
</div>    
{% endblock %}
