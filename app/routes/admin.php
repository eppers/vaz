<?php
 
$auth=function () use($app) {
    if(!isset($_SESSION['id_user']))
    $app->redirect('/admin/logowanie');    
};



$app->get('/admin', function () use ($app) {
    $app->redirect('/admin/');
});

$app->get('/admin/', $auth, function () use ($app) {
    $app->redirect('/admin/box/all');
});

/*
 * Boxes ......................................................................
 */

$app->get('/admin/box/all', $auth, function () use ($admin) {
    
    $boxes = Model::factory('Box')->find_many();

    $admin->render('/box/all.php',array('boxes'=>$boxes));
    
    $_SESSION['msg'] = '';
});


/*
 * Box edit
 */

$app->post('/admin/box/edit', $auth, function () use ($app) {
 
    //id : id, title : title, content : content, link : link, url : url
    $box = Model::factory('Box')->find_one($app->request()->post('id'));
    
    if($box instanceof Box) {
        try {
            $title = $app->request()->post('title');
            $content = $app->request()->post('content');
            $link = $app->request()->post('link');
            $url = $app->request()->post('url');
            
            $box->title = $title;
            $box->text = $content;
            $box->link = $link;
            $box->url = $url;
            
            if(!$box->save())   throw new Exception('Któraś z danych jest niepoprawna');
        } catch (Exception $e) {
            print json_encode(array('error'=>1, 'msg'=>'Błąd! '.$e->getMessage()));
            exit();
        }
        
        print json_encode(array('error'=>0, 'msg'=>'Box został wyedytowany'));
    } else {
        print json_encode(array('error'=>1, 'msg'=>'Błąd! Problem z ID boxa.'));
    }
 });


 /*
 * Box add
 */

$app->post('/admin/box/add', $auth, function () use ($app) {
 
    $title = $app->request()->post('title');
    $content = $app->request()->post('content');
    $link = $app->request()->post('link');
    $url = $app->request()->post('url');
    
    
    if(isset($title) && isset($content)) {
        $box = Model::factory('Box')->create();
        
        try {
            
            $box->title = $title;
            $box->text = $content;
            $box->link = $link;
            $box->url = $url;
            
            if(!$box->save())   throw new Exception('Któraś z danych jest niepoprawna');
        }catch(Exception $e) {
            print json_encode(array('error'=>1, 'msg'=>'Błąd! '.$e->getMessage()));
            exit();
        }
        
        print json_encode(array('error'=>0, 'msg'=>'Boks został dodany.'));
        
    } else print json_encode(array('error'=>1, 'msg'=>'Błąd! Problem z tytułem i zawartością boxa.'));

 });
 
 
 /*
 * Box delete
 */
$app->get('/admin/box/delete/:id', $auth, function ($id) use ($admin) {
    $box = Model::factory('Box')->find_one($id);
    
    if($box instanceof Box) {
        $box->delete();
        $_SESSION['status']='0';
        $_SESSION['msg']='Pozycja zostało usunięta';
    } else {
        $_SESSION['status']='1';
        $_SESSION['msg']='Błąd! Spróbuj później.';
    }

    $admin->app->redirect('/admin/box/all');
});

 
/*
 * Box active
 */
$app->post('/admin/box/active', $auth, function () use ($app) {
    $box = Model::factory('Box')->find_one($app->request()->post('id'));
    
    if($box instanceof Box) {
        try {
            if($box->active == 0) $box->active = 1;
            else $box->active = 0;
            
            if(!$box->save())   throw new Exception('Nie udało się aktywować/deaktywować boxa');
        } catch (Exception $e) {
            print json_encode(array('error'=>1, 'msg'=>'Błąd! '.$e->getMessage()));
            exit();
        }
        
        print json_encode(array('error'=>0, 'msg'=>'Box został wyedytowany', 'active'=>$box->active));
    } else {
        print json_encode(array('error'=>1, 'msg'=>'Błąd! Problem z ID boxa.'));
    }
});




/*
 * Sites ......................................................................
 */
$app->get('/admin/site/all', $auth, function () use ($admin) {
    $sites=Model::factory('Site')->find_many();
    $admin->render('/site/list.php',array('sites'=>$sites));
    
    $_SESSION['msg'] = '';
});


/*
 * Edit site
 */
$app->get('/admin/site/edit/:id', function ($id) use ($admin) {
 
    $site=Model::factory('Site')->find_one($id);
    
    if($site instanceof Site) {

        $admin->render('/site/edit.php',array('site'=>$site, 'form'=>'edit'));
    }
    else $admin->redirect('/admin/site/all');
});

$app->post('/admin/site/edit/:id', $auth, function ($id) use ($admin) {
 
    $site=Model::factory('Site')->find_one($id);
    
    if($site instanceof Site) {

        $site->text   = $admin->app->request()->post('content');
        $site->save();
        
        $_SESSION['status']='0';
        $_SESSION['msg']='Strona została wyedytowana pomyślnie';
        
    } else {
        $_SESSION['status']='1';
        $_SESSION['msg']='Coś poszło nie tak. Spróbuj ponownie.';
    } 
    
    $admin->app->redirect('/admin/site/all');
});


/****USER*********************************************************************/
/*
 * Edit user
 */
$app->get('/admin/user/edit', function () use ($admin) {
 
    $user=Model::factory('User')->find_one();
    
    if($user instanceof User) {

        $admin->render('/user/edit.php',array('user'=>$site));
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