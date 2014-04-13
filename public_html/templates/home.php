{% extends 'layout.php' %}

{% block page_title %}Strona główna{% endblock %}
{% block content %}          
        <main class="clearfix">
            {% for box in boxes%}
            <article>
                <div class="title">{{ box.title }}</div>
                <p>{{ box.text }}</p>
                {% if box.link != 0 %}<a href="{{ box.url }}" class="more">Więcej ></a>{% endif %}
            </article>
            {% endfor %}
            <article>
                <div class="title">Kontakt</div>
                <p>
                Centrum Rachunkowości<br>
                ul. Budowlanych 1<br>
                43-300 Bielsko-Biała<br>
                tel. +48 506 116 027<br>
                tel. +48 33 49 99 776<br>
                 <a href="/kontakt">Mapa dojazdu</a><br>
                 <a href="mailto:biuro@centrum-rachunkowosci.pl">biuro@centrum-rachunkowosci.pl</a>
                </p>
            </article>
        </main>
{% endblock %}        