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
     * @Route("/product", name="product")
     */
    public function product(Request $request)
    {

        // CHECK CONNECTION //
        $session = new Session(new NativeSessionStorage());
        if (empty($session->get('connected'))) {
            return $this->redirect("/");
        }

        // POST REQUEST RESULT //
        $result = -1;
        if ($request->getMethod() == 'POST') {
            $product_name = $request->request->get('product_name', '');
            $product_id = $request->request->get('product_id', '');
            $product_manager = $request->request->get('product_manager', '');
            $product_date = $request->request->get('product_date', '');

            $data = array('product_name' => $product_name, 'product_id' => $product_id, 'product_date' => $product_date, 'product_manager' => $product_manager);

            // TODO API CALL
             $result = 1;            
            
        }

        return $this->render('product/product.html.twig', [
            'page_name' => 'New Product',
            'fullname' => $session->get('fullname'),
            'result' => $result,
        ]);
    }

    /**
     * @Route("/sales", name="sales")
     */
    public function sales(Request $request)
    {

        // CHECK CONNECTION //
        $session = new Session(new NativeSessionStorage());
        if (empty($session->get('connected'))) {
            return $this->redirect("/");
        }

        // TODO API CALL
        $data = JSON_decode(file_get_contents('../assets/potato_sales.json'));        

        // add field property if missing //
        for ($i = 0; $i < count($data->column); $i++) {
            if (!isset($data->column[$i]->field)) {
                $prop_name = str_replace(' ', '_', strtolower($data->column[$i]->header));
                $data->column[$i]->field = $prop_name;

                if (strpos($prop_name, 'total') !== false) {
                    $total_prop_name = $prop_name;
                }
            }
        }

        // ADD totals //
        for ($i = 0; $i < count($data->data); $i++) {
            $total = 0;
            for ($n = 0; $n < 4; $n++) {
                $prop_name = 'salesQ' . ($n + 1);
                $total += $data->data[$i]->$prop_name;
            }

            $data->data[$i]->$total_prop_name = $total;
        }

        return $this->render('product/sales.html.twig', [
            'page_name' => 'Sales',
            'fullname' => $session->get('fullname'),
            'table' => $data,
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
