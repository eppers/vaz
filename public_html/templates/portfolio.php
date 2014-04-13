{% extends 'layout.php' %}

{% block page_title %}Portfolio{% endblock %}
{% block content %}
                <aside>
                    <ul>
                        {% for cat in categories %}
                        <li {% if cat.id == selectedCat %}class="it"{% endif %}><a>{{ cat.name }}</a>
                            {% if cat.subcats %}
                            <dl {% if cat.id == selectedCat %}class="show" style="display: block;"{% endif %}>
                                {% for subcat in cat.subcats %}
                                <dt><a href="/portfolio/{{ cat.url }}/{{ subcat.url }}">{{ subcat.name }}</a></dt>
                                {% endfor %}
                            </dl>
                            {% endif %}
                        </li>
                        {% endfor %}
                    </ul>
                </aside>
                <section class="right">
                     <div id="slider">
                        <ul class="bjqs">
                          {% for foto in fotos %}
                          <li><img src="/public/img/gallery/{{foto.img}}" title="{% if loop.index <= 9 %}0{{loop.index}}{% else %}{{loop.index}}{% endif %} / {{foto.name}}"></li>
                          {% endfor %}
                        </ul>
                    </div>
                </section>
{% endblock %}