<?php

namespace App\Controller;

use App\Entity\Registro;
use App\Form\RegistroType;
use App\Repository\RegistroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * @Route("/registro")
 */
class RegistroController extends AbstractController
{
    /**
     * @Route("/", name="registro_index", methods={"GET"})
     */
    public function index(RegistroRepository $registroRepository): Response
    {
        return $this->render('registro/index.html.twig', [
            'registros' => $registroRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="registro_new", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $registro = new Registro();
        $form = $this->createForm(RegistroType::class, $registro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($registro);
            $entityManager->flush();

            // Correo electrónico alumno
            $message = (new \Swift_Message('PCCM Virtual - Registro'))
                ->setFrom('webmaster@matmor.unam.mx')
                ->setTo(array($registro->getCorreo() ))
//            ->setTo('gerardo@matmor.unam.mx')
                ->setBcc(array('gerardo@matmor.unam.mx'))
                ->setBody($this->renderView('registro/confirmacion.txt.twig',
                    array('registro' => $registro)));

            ;
            $mailer->send($message);


            return $this->render('registro/confirmacion.html.twig', [
                'registro' => $registro,
            ]);
        }

        return $this->render('registro/new.html.twig', [
            'registro' => $registro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="registro_show", methods={"GET"})
     */
    public function show(Registro $registro): Response
    {
        return $this->render('registro/show.html.twig', [
            'registro' => $registro,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="registro_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Registro $registro): Response
    {
        $form = $this->createForm(RegistroType::class, $registro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('registro_index');
        }

        return $this->render('registro/edit.html.twig', [
            'registro' => $registro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Referencia entity.
     *
     * @Route("/{slug}/evaluacion", name="registro_eval",  methods={"GET","POST"})
     */

    public function eval(Request $request, Registro $registro, $slug): Response
    {

        $formEval = $this->createFormBuilder($registro)

            ->add('aceptado','Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'  => array(
                    'Si' => true,
                    'No' => false,
                ),
                'expanded'=>true,
                'required'=>false,
                'placeholder'=>false,
            ))
            ->add('confirmado','Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'  => array(
                    'Si' => true,
                    'No' => false,
                ),
                'expanded'=>true,
                'required'=>false,
                'placeholder'=>false,
            ))
            ->add('comentarios', 'Symfony\Component\Form\Extension\Core\Type\TextareaType',  array(
                'label' => 'Comentarios',
                'required'=>false,
                'empty_data' => ''

            ))

            ->getForm();

        
        $formEval->handleRequest($request);

        if ($formEval->isSubmitted() && $formEval->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($registro);
            $em->flush();
            return $this->redirectToRoute('registro_show', array('slug' => $registro->getSlug()));

        }
        // $form   = $this->createForm($formEval, $entity);
        return $this->render('registro/eval.html.twig',
            array('registro' => $formEval->createView(),
                'slug'=> $registro->getSlug()));
        //return $this->redirect($this->generateUrl('registro_show', array('id' => $id)));

    }


    /**
     * @Route("/{id}", name="registro_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Registro $registro): Response
    {
        if ($this->isCsrfTokenValid('delete'.$registro->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($registro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('registro_index');
    }
}
