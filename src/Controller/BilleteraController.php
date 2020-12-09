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
    public function index()
    {
        return $this->render('billetera/index.html.twig');
    }

    /**
     * @Route("/soapclient", name="Billetera_soapclient" )
     */
    public function soapClient(Request $rq)
    {
        $data = json_decode($rq->getContent(),true);
        $error = [];

        switch ($data['tipo']) {
            case 'registrar':
                if (!in_array(strlen($data['documento']), range(7,20)) || !isset($data['documento'])) {
                    $error['error'] = 'documento';
                } elseif (!in_array(strlen($data['nombre']), range(3,25)) || !isset($data['nombre'])) {
                    $error['error'] = 'nombre';
                } elseif (!in_array(strlen($data['email']), range(7,30)) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
                    || !isset($data['email'])) {
                    $error['error'] = 'email';
                } elseif (!in_array(strlen($data['celular']), range(7,25)) || !isset($data['celular'])) {
                    $error['error'] = 'email';
                }
                break;
            
            case 'recargar':
                if (!in_array(strlen($data['documento']), range(7,20))) {
                    $error['error'] = 'documento';
                } elseif (!in_array(strlen($data['celular']), range(7,30))) {
                    $error['error'] = 'celular';
                } elseif (!is_numeric($data['monto'])) {
                    $error['error'] = 'monto';
                }
                break;

            case 'pagar':
                if (!in_array(strlen($data['email']), range(7,30))
                        || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $error['error'] = 'email';
                } elseif (!is_numeric($data['monto'])) {
                    $error['error'] = 'monto';
                }
                break;

            case 'confirmar':
                if (!is_numeric($data['id'])) {
                    $error['error'] = 'id'; 
                } elseif (!is_numeric($data['token']) || strlen($data['token']) == 6) {
                    $error['error'] = 'token' ;
                }
                break;

            case 'consultar':
                if (!in_array(strlen($data['documento']), range(7,20))) {
                    $error['error'] = 'documento';
                } elseif (!in_array(strlen($data['celular']), range(7,30))) {
                    $error['error'] = 'celular';
                }
                break;
        }

        if (!empty($error)) {
            return new JsonResponse($error);
        }

        try {
            $response = $this->soap->__soapCall($data['tipo'], array($data));
        } catch (SoapFault $th) {
            $response['error_soap'] = $th->faultstring;
        }
        
        return new JsonResponse($response);
    }
}