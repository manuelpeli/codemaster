<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Exam;

/**
 * @Route("/exam")
 */
class ExamController extends Controller
{
    /**
     * @Route("/index", name="exam_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $exams = $em->getRepository('AppBundle:Exam')->findAll();

        return $this->render('AppBundle:Exam:index.html.twig', array(
            'exams' => $exams
        ));
    }

    /**
     * @Route("/show/{id}", name="exam_show")
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $exams = $em->getRepository('AppBundle:Exam')->findById($id);

        if(!$exams)
        {
            throw $this->createNotFoundException('No exams found for id ' . $id);
        }
        $exam = $exams[0];

        return $this->render('AppBundle:Exam:show.html.twig', array(
            'exam' => $exam
        ));
    }

    /**
     * @Route("/create", name="exam_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $exam = new Exam();

        $form = $this->createFormBuilder($exam)
            ->add('course', 'entity', array(
                'class' => 'AppBundle:Course',
                'choice_label' => 'name',
            ))
			->add('student', 'entity', array(
                'class' => 'AppBundle:Student',
                'choice_label' => 'fullName',
            ))
            ->add('exam_date', 'date')
            ->add('grade', 'integer')
            ->add('save', 'submit', array('label' => 'Create exam'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($exam);
            $em->flush();

            return $this->redirectToRoute('exam_show', array('id' => $exam->getId()));
        }

        return $this->render('AppBundle:Exam:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}", name="exam_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $exams = $em->getRepository('AppBundle:Exam')->findById($id);

        if(!$exams)
        {
            throw $this->createNotFoundException('No exams found for id ' . $id);
        }
        $exam = $exams[0];

        $form = $this->createFormBuilder($exam)
            ->add('course', 'entity', array(
                'class' => 'AppBundle:Course',
                'choice_label' => 'name',
            ))
			->add('student', 'entity', array(
                'class' => 'AppBundle:Student',
                'choice_label' => 'fullName',
            ))
            ->add('exam_date', 'date')
            ->add('grade', 'integer')
            ->add('save', 'submit', array('label' => 'Update exam'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($exam);
            $em->flush();

            return $this->redirectToRoute('exam_show', array('id' => $exam->getId()));
        }

        return $this->render('AppBundle:Exam:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
