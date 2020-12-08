<?php

namespace App\Service;

use App\Entity\Saldos;
use App\Entity\Personas;
use App\Entity\Operaciones;
use Doctrine\ORM\EntityManagerInterface;

class SoapService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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
            'documento' => $data['documento'],
            'celular' => $data['celular']
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
                $r['id'] = $operacion->getId();
                $r['token'] = $operacion->getToken();
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