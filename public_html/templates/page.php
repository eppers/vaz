{% extends 'layout.php' %}

{% block page_title %}{{title}}{% endblock %}
{% block content %}
    {{content|raw}}
{% endblock %}