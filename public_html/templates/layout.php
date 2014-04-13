<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Centrum Rachunkowości Joanna Kubica Biuro Rachunkowe Bielsko-Biała – usługi księgowe w Bielsku i okolicach - {% block page_title %} {% endblock %}</title>
    <meta name="description" content="Centrum Rachunkowości oferuje kompleksowe usługi księgowe i podatkowe. Konkurencyjne ceny oraz pakiet rabatów.">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="/public/css/normalize.css">
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/jquery.fancybox.css">
    <link rel="icon" type="image/png" href="favicon.png">
    <link href="https://plus.google.com/110449739553287642650" rel="publisher" />
    <script src="/public/js/vendor/modernizr-2.6.2.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/public/js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
</head>
<body onload="mapaStart()">
    
    <div class="wrapper">
        <header class="clearfix">
            <h1><a href="/">Centrum rachunkowości</a></h1>
            <nav>
                <ul>
                    <li {% if menuid == 1 %}class="current"{% endif %}><a href="/o_firmie">o firmie</a></li>
                    <li {% if menuid == 2 %}class="current"{% endif %}><a href="/oferta">oferta</a></li>
                    <li {% if menuid == 3 %}class="current"{% endif %}><a href="/cennik">cennik</a></li>
                    <li {% if menuid == 4 %}class="current"{% endif %}><a href="/uprawnienia">uprawnienia</a></li>
                    <li {% if menuid == 5 %}class="current"{% endif %}><a href="/kontakt">kontakt</a></li>
                </ul>
            </nav>
            <a class="fb" href="https://www.facebook.com/pages/Centrum-Rachunkowo%C5%9Bci-Joanna-Kubica/1394585550755272" target="_blank"></a>
        </header>
        <div class="top">
            <img src="/public/img/top_motto.jpg" alt="Ksiegowosc przekazana nam,to łatwy sposób na Twój biznes.">
        </div>
        {% block content %} {% endblock %}
        <footer>Copyright © 2013 Centrum Rachunkowości. Wszelkie prawa zastrzeżone. Zaprojektowane przez designtree.
        <strong>Kodowanie front-end: <a href="http://bpcoders.pl">BPCoders.pl</a></strong>
        </footer>
    </div><!--/.wrapper-->

    
    <script src="/public/js/plugins.js"></script>
    <script src="/public/js/main.js"></script>
    <script src="/public/js/vendor/jquery.fancybox.js"></script>
    <script src="/public/js/vendor/jquery.fancybox.pack.js"></script>
    <script src="/public/js/vendor/jquery.mousewheel-3.0.6.pack.js"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>   
    <script type="text/javascript">   
    <!-- 
    var mapa;
		var dymek = new google.maps.InfoWindow(); // zmienna globalna
		
		function dodajMarker(lat,lng,txt)
		{
			// tworzymy marker
			var opcjeMarkera =   
			{  
				position: new google.maps.LatLng(lat,lng),  
				map: mapa
			}  
			var marker = new google.maps.Marker(opcjeMarkera);
			marker.txt=txt;
			
			google.maps.event.addListener(marker,"click",function()
			{
				dymek.setContent(marker.txt);
				dymek.open(mapa,marker);
			});
			return marker;
		}
		
		function mapaStart()   
		{   
			var wspolrzedne = new google.maps.LatLng(49.838924,19.046417);
			var opcjeMapy = {
			  zoom: 14,
			  center: wspolrzedne,
			  mapTypeId: google.maps.MapTypeId.ROADMAP
			};

			mapa = new google.maps.Map(document.getElementById("google-map"), opcjeMapy); 
			var marker = dodajMarker(49.8323141233446,19.042605757713318,'<strong>Centrum Rachunkowości</strong><br>ul. Budowlanych 1<br>43-300 Bielsko-Biała<br><br>506 116 027<br>33 49 99 776<br>biuro@centrum-rachunkowosci.pl<br>');
			google.maps.event.trigger(marker,'click');
		}   

        -->
    </script>  
</body>
</html>