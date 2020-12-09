<?php

namespace App\Service;

use App\Entity\Saldos;
use App\Entity\Personas;
use App\Entity\Operaciones;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SoapService
{
    private $em;

    private $mailer;

    public function __construct(EntityManagerInterface $em, MailerInterface $mailer)
    {
        $this->em = $em;
        $this->mailer = $mailer;
    }

    public function registrar($data)
    {
        $r = [0,0];
        $persona = (new Personas())
            ->setDocumento($data['documento'])
            ->setNombre($data['nombre'])
            ->setEmail($data['email'])
            ->setCelular($data['celular']);

        $this->em->persist($persona);
        $this->em->flush();

        if (!empty($persona->getId())) {

            $r[0] = 1;

            $saldo = (new Saldos())
                ->setMonto(0)
                ->setPersona($persona);

            $this->em->persist($saldo);
            $this->em->flush();

            if (!empty($saldo->getId())) {
                $r[1] = 1;
            }

        };

        return $r;
    }

    public function recargar($data)
    {
        $r = [0,0,0];
        $persona = $this->em->getRepository('App\Entity\Personas')->findOneBy([
            'documento' => $data['documento'],
            'celular' => $data['celular']
        ]);

        if (!empty($persona->getId())) {
            $r[0] = 1;
            $operacion = (new Operaciones())
                ->setMonto($data['monto'])
                ->setTipo('RECARGA')
                ->setToken(null)
                ->setPersona($persona);
            
            $this->em->persist($operacion);
            $this->em->flush();

            if (!empty($operacion->getId())) {
                $r[1] = 1;
                $saldo = $this->em->getRepository(Saldos::class)->findOneBy([
                    'persona' => $persona
                ]);

                $monto = $saldo->getMonto() + $data['monto'];
                $saldo->setMonto($monto);
                
                $this->em->persist($saldo);
                $this->em->flush();

                if (!empty($saldo->getId())) {
                    $r[2] = 1;
                }
            }
        }
        
        return $r;

    }    
    
    public function pagar($data)
    {
        $r = [0,0];
        $persona = $this->em->getRepository(Personas::class)->findOneBy([
            'email' => $data['email'],
        ]);

        if (!empty($persona->getId())) {
            $r[0] = 1;

            $operacion = (new Operaciones())
                ->setMonto($data['monto'])
                ->setTipo('SOLICITUD DE PAGO')
                ->setToken(rand(0, 999999))
                ->setPersona($persona);

            $this->em->persist($operacion);
            $this->em->flush();

            if (!empty($operacion->getId())) {
                $r[1] = 1;
                $msg = '<p>Su ID de Sesion es: <strong>'.$operacion->getId().'</strong><br>'
                        .'Su token de acceso es: <strong>'.$operacion->getToken().'</strong></strong></p>';
                $mail = (new Email())
                    ->from('billeteramovilalisojo@gmail.com')
                    ->to($persona->getEmail())
                    ->subject('Solicitud de Pago')
                    ->text('ID de Sesion y Token de Acceso')
                    ->html($msg);
                $this->mailer->send($mail);
            }
        }

        return $r;
    }

    public function confirmar($data)
    {
        $r = [0,0];
        $operacion = $this->em->getRepository(Operaciones::class)->findOneBy([
            'id' => $data['id'],
            'token' => $data['token']
        ]);
        
        if (!empty($operacion->getId())) {
            $r[0] = 1;

            $saldo = $this->em->getRepository(Saldos::class)->findOneBy([
                'persona' => $operacion->getPersona()
            ]);
            
            $monto = $saldo->getMonto() - $operacion->getMonto();
            $saldo->setMonto($monto);
            $this->em->persist($saldo);
            $this->em->flush();

            $operacion->setToken(null);
            $operacion->setTipo('PAGO');
            $this->em->persist($operacion);
            $this->em->flush();

            $r[1] = 1;
        }

        return $r;
    }

    public function consultar($data)
    {
        $r = false;
        $sql = 'SELECT s.monto, p.nombre FROM saldos s INNER JOIN personas p ON p.id = s.persona_id '.
                'WHERE p.documento = :doc AND p.celular = :cel';
        $query = $this->em->getConnection()->prepare($sql);

        if ($query->execute(['doc' => $data['documento'], 'cel' => $data['celular']])) {
            $r = $query->fetchAssociative();
        }
        
        return $r;
    }
}