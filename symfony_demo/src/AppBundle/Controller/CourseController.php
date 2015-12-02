<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Course;

/**
 * @Route("/course")
 */
class CourseController extends Controller
{
    /**
     * @Route("/index", name="course_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository('AppBundle:Course')->findAll();

        return $this->render('AppBundle:Course:index.html.twig', array(
            'courses' => $courses
        ));
    }

    /**
     * @Route("/show/{id}", name="course_show")
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository('AppBundle:Course')->findById($id);

        if(!$courses)
        {
            throw $this->createNotFoundException('No courses found for id ' . $id);
        }
        $course = $courses[0];

        return $this->render('AppBundle:Course:show.html.twig', array(
            'course' => $course
        ));
    }

    /**
     * @Route("/create", name="course_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $course = new Course();

        $form = $this->createFormBuilder($course)
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('teacher', 'entity', array(
                'class' => 'AppBundle:Teacher',
                'choice_label' => 'fullName',
            ))
            ->add('save', 'submit', array('label' => 'Create course'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($course);
            $em->flush();

            return $this->redirectToRoute('course_show', array('id' => $course->getId()));
        }

        return $this->render('AppBundle:Course:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}", name="course_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository('AppBundle:Course')->findById($id);

        if(!$courses)
        {
            throw $this->createNotFoundException('No courses found for id ' . $id);
        }
        $course = $courses[0];

        $form = $this->createFormBuilder($course)
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('teacher', 'entity', array(
                'class' => 'AppBundle:Teacher',
                'choice_label' => 'fullName',
            ))
            ->add('save', 'submit', array('label' => 'Update course'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($course);
            $em->flush();

            return $this->redirectToRoute('course_show', array('id' => $course->getId()));
        }

        return $this->render('AppBundle:Course:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/exams/{id}", name="course_exams")
     * @Template()
     */
    public function examsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository('AppBundle:Course')->findById($id);

        if(!$courses)
        {
            throw $this->createNotFoundException('No courses found for id ' . $id);
        }
        $course = $courses[0];

        return $this->render('AppBundle:Course:exams.html.twig', array(
            'exams' => $course->getExams()
        ));
    }
}
