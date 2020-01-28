<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestController extends AbstractController
{
    /**
     * @Route("/rest/product", name="restProduct", methods={"POST"})
     */
    public function restProduct(Request $request)
    {

        $product_name = $request->request->get('product_name', '');
        $product_id = $request->request->get('product_id', '');
        $product_manager = $request->request->get('product_manager', '');
        $product_date = $request->request->get('product_date', '');
        $valid = false;

        // CHECK REQUIRED //
        if (!empty($product_name) && !empty($product_id) && !empty($product_date)) {
            // CHECK NUMERIC //
            if (is_numeric($product_id)) {
                // CHECK DATE FORMAT //
                $date_format = 'Y-m-d';
                $d = \DateTime::createFromFormat($date_format, $product_date);
                if ($d && $d->format($date_format) == $product_date) {
                    $valid = true;
                }
            }
        }
        if ($valid) {
            // POST THE PRODUCT //
            $result = JSON_decode('{"result": 1}');
            return new JsonResponse($result, Response::HTTP_OK);

        } else {

            // BAD REQUEST //
            $result = JSON_decode('{"result": 0}');
            return new JsonResponse($result, Response::HTTP_BAD_REQUEST);

        }

    }

    /**
     * @Route("/rest/sales", name="restSales", methods={"GET"})
     */
    public function restSales()
    {

        // GET THE SALES //
        $data = JSON_decode(file_get_contents('../assets/potato_sales.json'));
        return new JsonResponse($data, Response::HTTP_OK);

    }
}
