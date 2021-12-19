<?php

namespace App\Controller\Contacto;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ParametroConfiguracion;
use App\Entity\Contacto\Cliente;
use App\Entity\Admin\Comuna;
use App\Entity\Admin\Region;
use App\Entity\Admin\Pais;

/**
 * @Route("/enrolar")
 */
class EnrolarController extends AbstractController
{
    public function __construct()
    {
    }

    /**
     * @Route("/", name="index_enrolar")
     */
    public function index(Request $request): Response
    {
        $cliente = $this->getDoctrine()->getRepository(Cliente::class)->findAll();
        $valor = $this->getDoctrine()->getRepository(ParametroConfiguracion::class)->findBy(['parametro' => 'VALOR'])[0]->getValor();

        $productosConIngredientes = [];

        $entityManager = $this->getDoctrine()->getManager();

            return $this->render('/enrolar/index.html.twig', [
                'cliente' => $cliente,
                'VALOR' => $valor,
        ]);
    }

    /**
     * @Route("/feedback", name="cliente_new_feedback", methods={"POST"})
     */
    public function agregarFeedback(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $entity = new \App\Entity\EmpleadoFeedback();
        $form = $this->createForm(\App\Form\EmpleadoFeedbackType::class, $entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setEmpleado($this->getUser()->getEmpleado());
            $em->persist($entity);

            $em->flush();

            return new JsonResponse([
                'status' => true,
                'message' => 'Feedback registrado',
            ]);
        }

        return new JsonResponse([
            'status' => false,
            'message' => 'Ocurrio un error al intentar guardar el feedback',
            'errors' => array_map(function($e) { return $e->getMessage(); }, iterator_to_array($form->getErrors())),
        ]);
    }

    /**
     * @Route("/guardar", name="enrolar_guardar", methods={"POST"})
     */
    function enrolarCliente(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $data = new \App\Data\PedidoCajaData();
        $form = $this->createForm(PedidoCajaType::class, $data);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity = Pedido::fromPedidoCaja($form->getData());
            

            if (!$entity->requierePreparacion()) {
                $entity->setEstado(Pedido::ESTADO_ARMADO);
            }

            $em->persist($entity->getCliente());
            $em->persist($entity);

            $em->flush();

            return new JsonResponse([
                'status' => true,
                'data' => $entity->toArray(),
                'message' => 'El pedido fue registrado.',
            ]);
        }

        return new JsonResponse([
            'status' => false,
            'message' => 'Ocurrio un error al intentar guardar el pedido.',
            'errors' => array_map(function($e) { return $e->getMessage(); }, iterator_to_array($form->getErrors())),
        ]);
    }

    /**
     * @Route("/getDireccion", name="getDireccion")
     */
    public function getDireccion(Request $request){
        $idDireccion = $request->get('idDireccion');
        $direccion = $this->getDoctrine()->getRepository(ClienteDireccion::class)->find($idDireccion);
        if($direccion == null){
            $data = array('direccion' => false);
            return new JsonResponse($data);

        }else{
            $sector = $direccion->getSector();
            $adicional = $direccion->getAdicional();
            $data = array('sectorNombre' => $sector->getNombre(), 'sectorId' => $sector->getId(),'direccion' => $direccion,'referencia' => $adicional);
            return new JsonResponse($data);
        }
    }

    /**
     * @Route("/getCliente", name="getCliente")
     */
    public function getCliente(Request $request){
        $idCliente = $request->get('idCliente');
        $cliente = $this->getDoctrine()->getRepository(Cliente::class)->find($idCliente);
        if($cliente){
            $direcciones = $cliente->getDirecciones();
            $listaDirecciones = [];
            foreach ($direcciones as $direccion) {
                $listaDirecciones[] = array(
                    'id' => $direccion->getId(),
                    'direccion' => $direccion->getDireccion(),
                    'sector' => $direccion->getSector()->getNombre()
                );
            }
            $sectores = $this->getDoctrine()->getRepository(Sector::class)->findAll();
            $listaSectores = [];
            foreach ($sectores as $sector){
                $listaSectores [] = array(
                    'id' => $sector->getId(),
                    'nombre' => $sector->getNombre()
                );
            }
            $data = array('idCliente' => $cliente->getId(),'nombreCliente' => $cliente->getNombreCompleto(), 'telefonoCliente' => $cliente->getTelefono(),'puntaje' => $cliente->getPuntuacionEmpleados(),'direcciones' => $listaDirecciones,'sectores' => $listaSectores );
            return new JsonResponse($data);
        }
        else{
            $data = array('idCliente' => null);
            return new JsonResponse($data);

        }
    }

    /**
     * @Route("/clientes", name="clientes")
     */
    public function getClientes(Request $request){
        $clientes = $this->getDoctrine()->getRepository(Cliente::class)->findAll();
        $arrayClientes = [];
        foreach ($clientes as $cliente) {
            $arrayClientes[] = array(
                'id' => $cliente->getId(),
                'nombre' => $cliente->getNombreCompleto(),
                'telefono' => $cliente->getTelefono()
            );
        }
        $data = array('clientes' => $arrayClientes);
        return new JsonResponse($data);
    }

    /**
     * @Route("/formaulario/html", name="caja_promocion_html")
     */
    function getSeccionPromocionContent(Request $request){
        $promocion = $this->getDoctrine()->getRepository(Promocion::class)->find($request->query->get('id'));
        
        $html = $this->render('caja/sections/seccion_promocion.html.twig', [
            'promocion' => $promocion
        ])->getContent();

        return new JsonResponse([
            'status' => true,
            'data' => $html,
        ]);
    }
}