<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    /**
     * @Route("/welcome", name="welcome")
     */
    public function welcome()
    {

        // CHECK CONNECTION //
        $session = new Session(new NativeSessionStorage());
        if (empty($session->get('connected'))) {
            return $this->redirect("/");
        }

        return $this->render('product/welcome.html.twig', [
            'page_name' => 'Welcome',
            'fullname' => $session->get('fullname'),
        ]);
    }
    
    /**
     * @Route("/", name="login")
     */
    public function login(Request $request)
    {

        // CHECK CONNECTION //
        $session = new Session(new NativeSessionStorage());
        if (!empty($session->get('connected'))) {
            return $this->redirect("/welcome");
        }

        // POST REQUEST RESULT //
        $error = false;
        if ($request->getMethod() == 'POST') {
            $username = $request->request->get('username', '');
            $password = $request->request->get('password', '');

            if ($username === 'Elliot' && $password === 'test') {

                $session = new Session();
                $session->set('connected', 1);
                $session->set('username', $username);
                $session->set('fullname', 'Elliot COENE');
                $session->set('email', 'elliot.coene@e-telier.be');

                return $this->redirect("/welcome");

            } else {
                $error = true;
            }

        }

        return $this->render('product/login.html.twig', [
            'page_name' => 'Login',
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {

        // DELETE SESSION //
        $session = new Session();
        $session->set('connected', null);

        return $this->render('product/logout.html.twig', [
            'page_name' => 'Logout',
        ]);
    }

}
