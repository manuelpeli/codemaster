<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Student;

/**
 * @Route("/student")
 */
class StudentController extends Controller
{
    /**
     * @Route("/index", name="student_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $students = $em->getRepository('AppBundle:Student')->findAll();

        return $this->render('AppBundle:Student:index.html.twig', array(
            'students' => $students
        ));
    }

    /**
     * @Route("/show/{id}", name="student_show")
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $students = $em->getRepository('AppBundle:Student')->findById($id);

        if(!$students)
        {
            throw $this->createNotFoundException('No students found for id ' . $id);
        }
        $student = $students[0];

        return $this->render('AppBundle:Student:show.html.twig', array(
            'student' => $student
        ));
    }

    /**
     * @Route("/create", name="student_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $student = new Student();

        $form = $this->createFormBuilder($student)
            ->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('serialNumber', 'text')
            ->add('city', 'text')
            ->add('birthDate', 'date')
            ->add('save', 'submit', array('label' => 'Create student'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('student_show', array('id' => $student->getId()));
        }

        return $this->render('AppBundle:Student:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}", name="student_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $students = $em->getRepository('AppBundle:Student')->findById($id);

        if(!$students)
        {
            throw $this->createNotFoundException('No students found for id ' . $id);
        }
        $student = $students[0];

        $form = $this->createFormBuilder($student)
            ->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('serialNumber', 'text')
            ->add('city', 'text')
            ->add('birthDate', 'date')
            ->add('save', 'submit', array('label' => 'Update student'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('student_show', array('id' => $student->getId()));
        }

        return $this->render('AppBundle:Student:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/exams/{id}", name="student_exams")
     * @Template()
     */
    public function examsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $students = $em->getRepository('AppBundle:Student')->findById($id);

        if(!$students)
        {
            throw $this->createNotFoundException('No students found for id ' . $id);
        }
        $student = $students[0];

        return $this->render('AppBundle:Student:exams.html.twig', array(
            'exams' => $student->getExams()
        ));
    }
}
