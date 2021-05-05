<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lms-admin.php/cours",name="admin_")
 */
class CoursController extends AbstractController
{
    /**
     * @Route("/liste", name="cours_index", methods={"GET"})
     * @param CoursRepository $coursRepository
     * @return Response
     */
    public function index(CoursRepository $coursRepository): Response
    {
        return $this->render('admin/cours/index.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cours_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {

        $cour = new Cours();
        $form = $this->createForm(CoursType::class, $cour);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($cour);
            $entityManager->flush();

            return $this->redirectToRoute('admin_cours_index');
        }

        return $this->render('admin/cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="cours_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Cours $cour
     * @return Response
     */
    public function edit(Request $request, Cours $cour): Response
    {
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_cours_index');
        }

        return $this->render('admin/cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/effacer/{id}", name="cours_delete",options={"expose"=true},requirements={"id":"\d+"})
     * @param Cours $id
     * @return Response
     */
    public function delete(Cours $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($id);
        $entityManager->flush();


        return $this->redirectToRoute('admin_cours_index');
    }
}
