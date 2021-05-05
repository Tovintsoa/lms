<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Form\MatiereType;
use App\Repository\MatiereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("lms-admin.php/matiere",name="admin_")
 */
class AdminMatiereController extends AbstractController
{
    const _DIRECTORY = "admin/";

    /**
     * @Route("/liste", name="matiere_index", methods={"GET"})
     * @param MatiereRepository $matiereRepository
     * @return Response
     */
    public function index(MatiereRepository $matiereRepository): Response
    {
        return $this->render(self::_DIRECTORY.'matiere/index.html.twig', [
            'matieres' => $matiereRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="matiere_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $matiere = new Matiere();
        $form = $this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($matiere);
            $entityManager->flush();

            return $this->redirectToRoute('admin_matiere_index');
        }

        return $this->render(self::_DIRECTORY.'matiere/new.html.twig', [
            'matiere' => $matiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="matiere_show", methods={"GET"})
     * @param Matiere $matiere
     * @return Response
     */
    public function show(Matiere $matiere): Response
    {
        return $this->render('matiere/show.html.twig', [
            'matiere' => $matiere,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="matiere_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Matiere $matiere
     * @return Response
     */
    public function edit(Request $request, Matiere $matiere): Response
    {
        $form = $this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_matiere_index');
        }

        return $this->render(self::_DIRECTORY.'matiere/edit.html.twig', [
            'matiere' => $matiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/effacer/{id}", name="matiere_delete", options={"expose"=true})
     * @param Request $request
     * @param Matiere $id
     * @return Response
     */
    public function delete(Request $request, Matiere $id): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($id);
            $entityManager->flush();


        return $this->redirectToRoute('admin_matiere_index');
    }
}
