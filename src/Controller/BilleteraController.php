<?php

namespace App\Controller;

use SoapFault;
use SoapClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BilleteraController extends AbstractController
{
    private $soap;

    public function __construct()
    {
        $opts = array(
            'trace' => 1,
            'uri' => '/billetera_movil/public/index.php/soap',
            'location' => 'http://localhost/billetera_movil/public/index.php/soap'
        );
        $this->soap = new SoapClient(NULL, $opts);
    }

    /**
     * @Route("/", name="billetera")
     */
    public function index(): Response
    {
        $words = ['sky', 'cloud', 'wood', 'rock', 'forest',
            'mountain', 'breeze'];
        // return (new Response())->setContent('hi');
        return $this->render('billetera/index.html.twig', [
            'words' => $words
        ]);
    }

    /**
     * @Route("/soapclient", name="Billetera_soapclient" )
     */
    public function soapClient(Request $rq)
    {
        $rq = json_decode($rq, true);
        $error = [];

        switch ($rq['tipo']) {
            case 'registrar':
                if (!in_array(strlen($rq['documento']), range(7,20))) {
                    $error['error'] = 'documento';
                } elseif (!in_array(strlen($rq['nombre']), range(3,25))) {
                    $error['error'] = 'nombre';
                } elseif (!in_array(strlen($rq['email']), range(7,30))
                        || !filter_var($rq['email'], FILTER_VALIDATE_EMAIL)) {
                    $error['error'] = 'email';
                } elseif (!in_array(strlen($rq['celular']), range(7,25))) {
                    $error['error'] = 'email';
                }
                break;
            
            case 'recargar':
                if (!in_array(strlen($rq['documento']), range(7,20))) {
                    $error['error'] = 'documento';
                } elseif (!in_array(strlen($rq['celular']), range(7,30))) {
                    $error['error'] = 'celular';
                } elseif (!is_numeric($rq['monto'])) {
                    $error['error'] = 'monto';
                }
                break;

            case 'pagar':
                if (!in_array(strlen($rq['email']), range(7,30))
                        || !filter_var($rq['email'], FILTER_VALIDATE_EMAIL)) {
                    $error['error'] = 'email';
                } elseif (!is_numeric($rq['monto'])) {
                    $error['error'] = 'monto';
                }
                break;

            case 'confirmar':
                if (!is_numeric($rq['id'])) {
                    $error['error'] = 'id'; 
                } elseif (!is_numeric($rq['token']) || strlen($rq['token']) == 6) {
                    $error['error'] = 'token' ;
                }
                break;

            case 'consultar':
                if (!in_array(strlen($rq['documento']), range(7,20))) {
                    $error['error'] = 'documento';
                } elseif (!in_array(strlen($rq['celular']), range(7,30))) {
                    $error['error'] = 'celular';
                }
                break;
        }

        if (!empty($error)) {
            return new JsonResponse($error);
        }

        try {
            $response = $this->soap->__soapCall($rq['tipo'], array($rq));
        } catch (SoapFault $th) {
            $response['error'] = $th->faultstring;
        }

        return new JsonResponse($response);
    }
}