<?php

/*
 * Wyświetlenie strony głównej
 */
$app->get('/', function () use ($app) {

    $boxes = Model::factory('Box')->where('active','1')->order_by_asc('id_box')->limit(3)->find_many();
    
    $app->render('home.php', array('menuid'=>'', 'boxes'=>$boxes)); 
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
    $app->render('contact.html.twig', array('menuid'=>'5'));
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
          $app->render('contact.html.twig', array('menuid'=>'4','error'=>'Wiadomość nie została wysłana.'));
          exit;
    } else {
        $app->render('contact.html.twig', array('menuid'=>'4','error'=>'Wiadomość została wysłana.'));
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
