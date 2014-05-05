<?php
 
$auth=function () use($app) {
    //if(!isset($_SESSION['id_user']))
    //$app->redirect('/admin/logowanie');
};



$app->get('/admin', function () use ($app) {
    $app->redirect('/admin/');
});

$app->get('/admin/', $auth, function () use ($app) {
    $app->redirect('/admin/city');
});

/*
 * Cities ......................................................................
 */

$app->get('/admin/city', $auth, function () use ($admin) {
    
    $cities = Model::factory('City')->filter('getManyCitiesNames','pl')->find_many();

    $admin->render('/city/all.html.twig',array('cities'=>$cities));
    
    $_SESSION['msg'] = '';
});


/*
 * City edit
 */


$app->post('/admin/city/edit', $auth, function () use ($app) {
 
    //id : id, title : title, content : content, link : link, url : url
    $city = Model::factory('City')->find_one($app->request()->post('id'));
    
    if($city instanceof City) {

        try {

            $city->x_pos = intval($app->request()->post('x'));
            $city->y_pos = intval($app->request()->post('y'));
            if(!$city->save())   throw new Exception('Któraś z danych jest niepoprawna');

            $cityName = $city->getOneCityName()->where('lang','pl')->find_one(); //TODO wstawić język w zależności od wersji językowej w adminie
            $cityName->name = clearName($app->request()->post('city'));
            if(!$cityName->save())   throw new Exception('Błąd z nazwą miasta');

        } catch (Exception $e) {
            print json_encode(array('error'=>1, 'msg'=>'Błąd! '.$e->getMessage()));
            exit();
        }
        
        print json_encode(array('error'=>0, 'msg'=>'Miasto zostało wyedytowane'));
    } else {
        print json_encode(array('error'=>1, 'msg'=>'Błąd! Problem z ID Miasta.'));
    }
 });


 /*
 * City add
 */

$app->post('/admin/city/add', $auth, function () use ($app) {
    $city = Model::factory('City')->create();
    $city->x_pos = intval($app->request()->post('x'));
    $city->y_pos = intval($app->request()->post('y'));
    $city->save();

    $cityName = Model::factory('CityName')->create();
    $cityName->id_city = $city->id();
    $cityName->lang = 'pl'; //TODO wstawić język w zależności od wersji językowej w adminie
    $cityName->name = clearName($app->request()->post('city'));
    $cityName->save();

    print json_encode(array('error'=>0, 'msg'=>'Miasto zostało dodane', 'id'=>$cityName->id_city));
  });
 
 
 /*
 * City delete
 */
$app->get('/admin/city/delete/:id', $auth, function ($id) use ($admin) {
    $city = Model::factory('City')->find_one($id);
    
    if($city instanceof City) {
        $cityNames = $city->getOneCityName()->find_many();

            foreach($cityNames as $name) {
                if($name instanceof CityName)
                    $name->delete();
            }
        $city->delete();
        $_SESSION['status']='0';
        $_SESSION['msg']='Pozycja zostało usunięta';
    } else {
        $_SESSION['status']='1';
        $_SESSION['msg']='Błąd! Spróbuj później.';
    }

    $admin->app->redirect('/admin/city');
});


/****SITES*********************************************************************/

$app->get('/admin/site/all', $auth, function () use ($admin) {
    $sites=Model::factory('Site')->filter('getManySitesNames','pl')->find_many();
    $admin->render('/site/list.html.twig',array('sites'=>$sites));
    
    $_SESSION['msg'] = '';
});


/*
 * Edit site
 */
$app->get('/admin/site/edit/:id', function ($id) use ($admin) {
 
    $site=Model::factory('Site')->find_one($id);
    
    if($site instanceof Site) {
        $steps = $site->steps()->where('lang','pl')->find_many();
        foreach($steps as &$step) {
            $step->text = prepareDbToHtml($step->text);
        }
        $siteLang = $site->getOneSiteName()->find_one();
        $siteLang->text = prepareDbToHtml($siteLang->text);
        $admin->render('/site/edit.html.twig',array('site'=>$siteLang, 'steps'=>$steps, 'form'=>'edit'));
    }
    else $admin->redirect('/admin/site/all');
});

$app->post('/admin/site/edit/:id', $auth, function ($id) use ($admin) {
 
    $site=Model::factory('Site')->find_one($id);
    
    if($site instanceof Site) {

        $siteLang = $site->getOneSiteName()->where('lang','pl')->find_one();
        $siteLang->text   = prepareHtmlToDb($admin->app->request()->post('content'));
        $siteLang->save();

        $steps = $site->steps()->where('lang','pl')->find_many();
        foreach($steps as $step) {
            if($step instanceof Step) {
                $step->text =  prepareHtmlToDb($admin->app->request()->post('krok_'.$step->id_step));
                $step->save();
            }
        }

        $_SESSION['status']='0';
        $_SESSION['msg']='Strona została wyedytowana pomyślnie';
        
    } else {
        $_SESSION['status']='1';
        $_SESSION['msg']='Coś poszło nie tak. Spróbuj ponownie.';
    } 
    
    $admin->app->redirect('/admin/site/all');
});

/****CALENDAR*********************************************************************/

$app->get('/admin/calendar', $auth, function () use ($admin) {
    $cities = Model::factory('CityName')->where('lang','pl')->find_many();
    $date = date('Y-m-j');
    $currentMonth = date('n');
    $calendar = new Acme\Calendar($cities[0]->id_city);
    $calendarCurrentMonth = $calendar->getFreeDaysForCityInMonth($date);
    $listOfMonths = Acme\Calendar::getListOfMonths('pl');

    $admin->render('/calendar/calendar.html.twig',array('cities'=>$cities, 'available'=>$calendarCurrentMonth, 'month'=>$currentMonth, 'listOfMonths'=>$listOfMonths));

});

$app->post('/admin/calendar/update', $auth, function () use ($app) {

    $post = array();
    parse_str($app->request()->post('form'),$post);

    $year = date('Y'); //TODO w razie chęci dodawania terminów na rok następny wysyłąć dodatkowe pole
    $month = intval($post['month']);
    $day = intval($post['day-id']);
    $cityId = intval($post['city']);
    $time = explode('-',$post['amount-time']);
    $date = $year.'-'.$month.'-'.$day;
    $hourFrom = date('G:i:s',strtotime($time[0]));
    $hourTo = date('G:i:s',strtotime($time[1]));
        
    $city = Model::factory('City')->find_one($cityId);
    if($city instanceof City) {
        $calendar = Model::factory('Calendar')->where('date',$date)->where('id_city',$cityId)->find_one();
        if(!$calendar instanceof Calendar) {    
            $calendar = Model::factory('Calendar')->create();
            $calendar->date = $date;
            $calendar->id_city = $cityId;
        }    
        $calendar->hour_from = $hourFrom;
        $calendar->hour_to = $hourTo;
        $calendar->save();

        print json_encode('1');
    } else print json_encode('0');

});

$app->post('/admin/calendar/delete', $auth, function () use ($app) {

    $post = array();
    parse_str($app->request()->post('form'),$post);

    $year = date('Y'); //TODO w razie chęci dodawania terminów na rok następny wysyłąć dodatkowe pole
    $month = intval($post['month']);
    $day = intval($post['day-id']);
    $cityId = intval($post['city']);
    $date = $year.'-'.$month.'-'.$day;
      
    $calendar = Model::factory('Calendar')->where('date',$date)->where('id_city',$cityId)->find_one();
    if($calendar instanceof Calendar) {
      $calendar->delete();
      print json_encode('1');
    } else print json_encode('0'); 
   
});

/****USER*********************************************************************/
/*
 * Edit user
 */
$app->get('/admin/user/edit', function () use ($admin) {
 
    $user=Model::factory('User')->find_one();
    
    if($user instanceof User) {

        $admin->render('/user/edit.html.twig',array('user'=>$site));
    }
    else $admin->redirect('/admin/site/all');
});

$app->post('/admin/user/edit', $auth, function () use ($admin) {
 
    $pass = trim(preg_replace('/[^\w\d_ -]/si', '', $admin->app->request()->post('pass')));
    $passre = trim(preg_replace('/[^\w\d_ -]/si', '', $admin->app->request()->post('passre')));
    
    $user=Model::factory('User')->find_one();
    print 'pass'.$pass;
    if($user instanceof User) {
        
        if($pass == $passre) {
            $user->pass = md5($pass);
            $user->save();
        
            $_SESSION['status']='0';
            $_SESSION['msg']='Hasło została wyedytowana pomyślnie';
        } else {
            $_SESSION['status']='1';
            $_SESSION['msg']='Hasła nie są jednakowe';
            
            $admin->app->redirect('/admin/user/edit');
        }
    } else {
        $_SESSION['status']='1';
        $_SESSION['msg']='Coś poszło nie tak. Spróbuj ponownie.';
    } 
    
    $admin->app->redirect('/admin/site/all');
});

/******************** Dokumenty ***********************/

$app->get('/admin/dokumenty', function () use ($admin) {

    $docs = Model::factory('Document')->where('lang','pl')->find_many(); //TODO wersja jezykowa w zaleznosci od sesji

    $admin->render('/doc/all.html.twig',array('docs'=>$docs));
});


$app->post('/admin/doc/add', $auth, function () use ($app) {

    $name = $app->request()->post('name');

    if(!empty($name) && isset($_FILES)) {
        $document=Model::factory('Document')->create();

        try {
            $file = \Acme\File::load($_FILES,'./public/upload/');
            $document->name = clearName($name);
            $document->url = $file->getFileName();
            $document->lang = 'pl'; //TODO wersja jezykowa sesja

            if(!$document->save()) {
                throw new Exception('Któraś z danych jest niepoprawna');
            }
        }catch (PDOException $pdoex) {
            unlink($file->getFilePath());
            print json_encode(array('error'=>1, 'msg'=>'Błąd SQL! '.$pdoex->getMessage()));
            exit();
        }catch(Exception $e) {
            print json_encode(array('error'=>1, 'msg'=>'Błąd! '.$e->getMessage()));
            exit();
        }

        print json_encode(array('error'=>0));

    } else print json_encode(array('error'=>1, 'msg'=>'Błąd! Problem z którymś z pól.'));
});

/*
* Document delete
*/
$app->get('/admin/doc/delete/:id', $auth, function ($id) use ($admin) {

    $id = intval($id);
    $doc = Model::factory('Document')->find_one($id);

    if($doc instanceof Document) {

        unlink('./public/upload/'.$doc->url);
        $doc->delete();
    }

    $admin->app->redirect('/admin/dokumenty');
});

/*
 * Logowanie - wyświetlanie formularza
 */
$app->get('/admin/logowanie', function () use ($admin) {

    $admin->render('login.php',array());
});

/*
 * Logowanie - wysłanie formularza
 */
$app->post('/admin/logowanie', function () use ($admin) {
    $user = Model::factory('User')->where('login',$admin->app->request()->post('login'))->where('pass', md5($admin->app->request()->post('password')))->find_one();
    $login=$admin->app->request()->post('login');
    $pass=$admin->app->request()->post('password');

    if ( $user instanceof User) {
            $_SESSION['id_user'] = $user->id_user;
            $_SESSION['login'] = $user->login;   
            $admin->app->redirect('/admin/');
	}
    else {
        $admin->render('login.php', array('info'=>'Login lub hasło niepoprawne'));
    }

});

/*
 * Wyloguj
 */
$app->get('/admin/wyloguj', $auth, function () use ($app) {
    
    session_destroy();
    
    $app->redirect('/');
});