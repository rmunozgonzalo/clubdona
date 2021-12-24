<?php

namespace App\Controller\Contacto;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Admin\ParametroConfiguracion;
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
        //$cliente = $this->getDoctrine()->getRepository(Cliente::class)->findAll();
        $valor = $this->getDoctrine()->getRepository(ParametroConfiguracion::class)->findOneBy(['parametro' => 'VALOR']);
        if($valor){
            $valor = $valor->getValor();
        }
        else{
            $valor = 0;
        }
        

        $productosConIngredientes = [];

        $entityManager = $this->getDoctrine()->getManager();

            return $this->render('/formulario_enrolar/form.html.twig', [
                //'cliente' => $cliente,
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
        $valid = false;
        $first_name = $request->request->get('first_name');
        $last_name = $request->request->get('last_name');
        $birthday = $request->request->get('birthday');
        $email = $request->request->get('email');
        $phone = $request->request->get('phone');
        $facebook = $request->request->get('facebook');
        $instagram = $request->request->get('instagram');
        $clienteExiste = null;
        
        if($email!=''){
            $clienteExiste = $em->getRepository(Cliente::class)->findOneBy(['email'=>$email]);
        }
        
        if($clienteExiste){
            return new JsonResponse([
                'status' => false,
                'message' => 'Ya tenemos un registro con ese correo.',
                'errors' => 'Correo registrado',
            ]);
        }
        else{
            $valid = true;
        }

        if ($valid) {
            
            $cliente = new Cliente();
            $cliente->setNombre($first_name);
            $cliente->setApellidos($last_name);
            $fecha = \DateTime::createFromFormat('Y-m-d',$birthday);
            $cliente->setFechaNacimiento($fecha);
            $cliente->setEmail($email);
            $cliente->setTelefono($phone);
            $cliente->setFacebook($facebook);
            $cliente->setInstagram($instagram);

            $em->persist($cliente);

            $em->flush();

            return new JsonResponse([
                'status' => true,
                'data' => $cliente->toArray(),
                'message' => 'El registro fue exitoso.',
            ]);
        }

        return new JsonResponse([
            'status' => false,
            'message' => 'Ocurrio un error al intentar realizr el registro.',
            'errors' => 'Error de validacion',
        ]);
    }


    public function getClientes(){
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

}