<?php

namespace App\Controller;

use SoapClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/soapclient", name="Billetera_soapclient")
     */
    public function soapClient()
    {
        
        $person = [
            'documento' => '26250360',
            'nombre' => 'Frank',
            'email' => 'ejemplo',
            'celular' => 'hola',
            'monto' => 1997,
            'id' => 16,
            'token' => 599950
        ];

        try {
            $response = $this->soap->__soapCall('consultar', array($person));
        } catch (\SoapFault $th) {
            $response = $th->faultstring;
        }

        // switch ($data['tipo']) {
        //     case 'registrar':
        //         # code...
        //         break;
            
        //     default:
        //         # code...
        //         break;
        // }
        var_dump($response);
        return (new Response())->setContent('respuesta');
    }
}