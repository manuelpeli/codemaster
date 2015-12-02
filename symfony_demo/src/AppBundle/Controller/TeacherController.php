<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Teacher;

/**
 * @Route("/teacher")
 */
class TeacherController extends Controller
{
    /**
     * @Route("/index", name="teacher_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $teachers = $em->getRepository('AppBundle:Teacher')->findAll();

        return $this->render('AppBundle:Teacher:index.html.twig', array(
            'teachers' => $teachers
        ));
    }

    /**
     * @Route("/show/{id}", name="teacher_show")
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $teachers = $em->getRepository('AppBundle:Teacher')->findById($id);

        if(!$teachers)
        {
            throw $this->createNotFoundException('No teachers found for id ' . $id);
        }
        $teacher = $teachers[0];

        return $this->render('AppBundle:Teacher:show.html.twig', array(
            'teacher' => $teacher
        ));
    }

    /**
     * @Route("/create", name="teacher_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $teacher = new Teacher();

        $form = $this->createFormBuilder($teacher)
            ->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('serialNumber', 'text')
            ->add('city', 'text')
            ->add('birthDate', 'date')
            ->add('save', 'submit', array('label' => 'Create teacher'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($teacher);
            $em->flush();

            return $this->redirectToRoute('teacher_show', array('id' => $teacher->getId()));
        }

        return $this->render('AppBundle:Teacher:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}", name="teacher_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $teachers = $em->getRepository('AppBundle:Teacher')->findById($id);

        if(!$teachers)
        {
            throw $this->createNotFoundException('No teachers found for id ' . $id);
        }
        $teacher = $teachers[0];

        $form = $this->createFormBuilder($teacher)
            ->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('serialNumber', 'text')
            ->add('city', 'text')
            ->add('birthDate', 'date')
            ->add('save', 'submit', array('label' => 'Update teacher'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($teacher);
            $em->flush();

            return $this->redirectToRoute('teacher_show', array('id' => $teacher->getId()));
        }

        return $this->render('AppBundle:Teacher:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
