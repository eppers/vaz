{% extends 'layout.php' %}

{% block page_title %}Kontakt{% endblock %}
{% block content %}
        <main  class="oferta clearfix">
                <article class="contact">
                  <div class="title">Kontakt</div>
	             <div class="contact-box">
                  <p style="padding-left: 19px; font-size: 16px; line-height: 20px;">
                    <b>Centrum Rachunkowości</b><br>
                    ul. Budowlanych 1<br>
                    43-300 Bielsko-Biała<br>
                    tel. +48 506 116 027<br>
                    tel. +48 33 49 99 776<br>
                    <a href="mailto:biuro@centrum-rachunkowosci.pl">biuro@centrum-rachunkowosci.pl</a>
                  </p>
                        <div class="contact-col-left">
                            {% if error is defined %}<p style="font-weight: bold; font-size: 14px;">{{ error }}</p>{% endif %}
                        <p>Formularz kontaktowy:</p>
                        <form method="post" action="" id="contact-form">
                          <input type="text" name="name" placeholder="Imię i Nazwisko">
                          <input type="email" name="email" placeholder="E-mail">
                          <input type="text" name="subject" placeholder="Temat">
                          <textarea name="content" placeholder="Treść wiadomości"></textarea>
                          <input type="submit" value="Wyślij">
                        </form>
		                   </div>
		
		                  <div class="contact-col-right">
			                   <p>Mapa dojazdowa:</p>
                        <div id="google-map"></div>
		                  </div>
	             </div>
               </article>
        </main>          
        <script>
        $( document ).ready(function() {
            $('body').css('height','auto');
        });
        </script>
{% endblock %}