<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

class ControlarComprasCommand extends Command
{
    protected static $defaultName = 'ControlarCompras';
    protected static $defaultDescription = 'Controlar Compras y Stock de Ventas no Pagas';

    protected function configure(): void
    {
        $this
         ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
         ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    //Funcion para validar los dias de vencimiento de una venta
    private function validarCantidadDias($fechaVenta) {
     //Calculo que no hayan pasado mas de 5 dias desde la venta
     $fechaActual = date('Y-m-d');
     $datetime1 = date_create($fechaVenta);
     $datetime2 = date_create($fechaActual);
     $cantidadDias= date_diff($datetime1, $datetime2)->format('%a');

        if ($cantidadDias > 5) {
         return true;
        }
        else {
         return false;
        }
    }

    //Funcion para pasar a vencidas
    private function pasarVentaComoVencida($venta) {
     //Obtengo el EntityManager
     $em = $this->entityManager;
     //Obtengo el estado de venta cancelada
     $estadoCancelada=$em->getRepository("App:Estadoventa")->find(4);
     //Cambio el estado de la venta
     $venta->setEstado($estadoCancelada);
     //Escribo el comentario de la venta
     $venta->setComentario("VENTA CANCELADA POR SISTEMA - PASARON 5 DIAS DESDE EL INICIO Y NO SE HA REALIZADO EL PAGO");
     //Le doy persistencia 
     $em->persist($venta);
     //Asiento los cambios en la base de datos
     $em->flush();
     //Retorno la venta
     return $venta;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
     $io = new SymfonyStyle($input, $output);     
     print("------------------------------------------------------------------------\n");
     print("Controlar Compras y Stock de Ventas que se les termino el plazo de pago\n");
     print("------------------------------------------------------------------------\n");
     print("\n");
     print("Se listaran todas las ventas en estado NUEVO que esten en estado PENDIENTE de pago\n");
     print("\n");
     print("\n");

        
     //Obtengo el EntityManager
     $em = $this->entityManager;
     //Obtengo las ventas en estado pendiente
     $ventasPendientes=$em->getRepository("App:Venta")->findByVentasPendientes();


       //Itero sobre todas las ventas pendientes
        foreach ($ventasPendientes as $venta) {
         //Obtengo la fecha de la venta
         $fechaVenta=$venta->getFecha()->format("d-m-Y");
         //Flag para saber si pasaron los dias permitidos o no
         $flagVenta= $this->validarCantidadDias($fechaVenta);

        
            //Si el flag venta esta activo
            if ($flagVenta == true ) {
             print("\n");
             print("Venta ID: ".$venta->getId()." - Estado: ".$venta->getEstado()->getEstado()." - Precio: $".$venta->getPrecio()." - Cliente: ".$venta->getUsuario()->getUsername()." - Mail: ".$venta->getUsuario()->getMail()."\n");
             //Cambio el estado de la venta
             $venta= $this->pasarVentaComoVencida($venta);
            }           
       }

     $io->success('Fin del Control');
     return Command::SUCCESS;
    }
}
