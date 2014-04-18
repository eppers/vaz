<?php

//TODO miasta zapis do bazy i generowanie na stronie

/*
 * Stosowne menu dla danego języka
 */
$app->hook('slim.before.dispatch', function() use ($app) {
    $menuTop = Model::factory(Menu)->where('position','top')->filter('getAllNames','pl')->order_by_asc('order')->find_many();
    foreach($menuTop as &$menu) {
        $menuTmp = new stdClass();
        $menuTmp = $menu;
        $menuTmp->url = cleanForShortURL($menu->name);
        $menu = $menuTmp;
    }

    $app->view()->setData('topMenu', $menuTop);
});


/*
 * Wyświetlenie strony głównej
 */
$app->get('/', function () use ($app) {

    $site = Model::factory('Site')->find_one(1);
    $steps = Model::factory('Step')->where('id_site',$site->id_site)->find_many();

    $app->render('vazectomia.html.twig', array('menuid'=>1, 'steps'=>$steps));
});

/*
 * Wyświetlanie strony za pomocą ID
 */
$app->get('/:id,:slug', function ($id) use ($app) {

    $site = Model::factory('Site')->find_one(intval($id));
    $steps = $site->steps()->find_many();
    foreach($steps as &$step) {
        $step->text = prepareDbToHtml($step->text);
    }
    if($site->mapa == 1) {
        $cities = Model::factory('City')->filter('getManyCitiesNames','pl')->find_many(); //TODO jezyk w zaleznosci od wersji jezykowej
    } else $cities = array();
    $app->render($site->template.'.html.twig', array('menuid'=>1, 'steps'=>$steps, 'cities'=>$cities));
});

$app->get('/miasto/:id', function ($id) use ($app) {

    $city = Model::factory('CityName')->where('id_city',intval($id))->where('lang','pl')->find_one();//TODO jezyk w zaleznosci od wersji jezykowej
    $cities = Model::factory('City')->filter('getManyCitiesNames','pl')->find_many(); //TODO jezyk w zaleznosci od wersji jezykowej

    $app->render('placowki.html.twig', array('menuid'=>1, 'city'=>$city, 'cities'=>$cities));
});

/**
 * Uprawnienia
 */
$app->get('/uprawnienia', function () use ($app) {

   // $fotos = Model::factory('Foto')->order_by_asc('pos')->find_many();
    $app->render('uprawnienia.php', array('menuid'=>'4'));
});


/**
 * Kontakt
 */
$app->get('/kontakt', function () use ($app) {

   // $fotos = Model::factory('Foto')->order_by_asc('pos')->find_many();
    $app->render('kontakt.html.twig', array('menuid'=>'5'));
});


$app->post('/kontakt', function () use ($app) {

//Konfiguracja PHPMailer
  $mail = new PHPMailer;

  //$mail->IsSMTP();                                      // Set mailer to use SMTP
  $mail->Host = 's99.vdl.pl';  // Specify main and backup server
  $mail->SMTPAuth = false;                               // Enable SMTP authentication
  $mail->Username = 'info@centrum-rachunkowosci.pl';                            // SMTP username
  $mail->Password = 'RvgHmTwa';                           // SMTP password
  //$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
  $mail->SetLanguage('pl', '../lib/PHPMailer/language/');
  $mail->CharSet = "UTF-8";
  $mail->Port       = 587;
  
  $mail->SetFrom('info@centrum-rachunkowosci.pl','formularz');
  $mail->FromName = 'info@centrum-rachunkowosci.pl';
  $mail->AddAddress('info@centrum-rachunkowosci.pl');               // Name is optional
      
  $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
  $mail->IsHTML(true);                                  // Set email format to HTML
  
//trzy pola ktore musza byc wypelnione
  $name = $app->request()->post('name');
  $content = $app->request()->post('content');
  $subject = $app->request()->post('subject');
  $email = (filter_var($app->request()->post('email'), FILTER_VALIDATE_EMAIL)? $app->request()->post('email') : '');
  if(!empty($email)) $mail->From = $email;  
  
  if(!empty($name) && !empty($email) && !empty($content)) {
    
      $name = clearName($name);
      $content = clearName($content);
      $subject = clearName($subject);
 
    
      
     $mail->Subject = $subject;
     $mail->Body    = ' Wiadomość od: <br>
                        Imię: '.$name.'<br>
                        Email: '.$email.'<br><br>
                        Treść wiadomości: '.$content;
        
     $mail->AltBody = "Wiadomość od: \n
                        Imię: ".$name."\n
                        Email: ".$email."\n
                        Treść wiadomości: ".$content;
     
     if(!$mail->Send()) {
          //echo 'Wiadomość nie została wysłana.';
          //echo 'Mailer Error: ' . $mail->ErrorInfo;
          $app->render('kontakt.html.twig', array('menuid'=>'4','error'=>'Wiadomość nie została wysłana.'));
          exit;
    } else {
        $app->render('kontakt.html.twig', array('menuid'=>'4','error'=>'Wiadomość została wysłana.'));
    }
  }

});


 

/**
 * Pages
 */
$app->get('/:page', function ($page) use ($app) {

    $page = Model::factory('Site')->where('link',$page)->find_one();
    if($page instanceof Site)
        $app->render('page.php', array('menuid'=>$page->id_site, 'title'=>$page->title, 'content'=>$page->text));
    else 
        $app->redirect('/');
});

?>
