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
     * @Route("/billetera", name="billetera")
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
        $data = ['name' => 'Frank'];
        return (new Response())->setContent($this->soap->__soapCall('hello', array($data)));
    }
}