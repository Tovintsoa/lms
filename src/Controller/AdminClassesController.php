<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Form\ClassesType;
use App\Repository\ClassesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("lms-admin.php/admin/classes")
 */
class AdminClassesController extends AbstractController
{
    const _DIRECTORY = 'admin/';

    /**
     * @Route("/liste", name="admin_classes_index", methods={"GET"})
     * @param ClassesRepository $classesRepository
     * @return Response
     */
    public function index(ClassesRepository $classesRepository): Response
    {
        return $this->render(self::_DIRECTORY.'admin_classes/index.html.twig', [
            'classes' => $classesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_classes_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $class = new Classes();
        $form = $this->createForm(ClassesType::class, $class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($class);
            $entityManager->flush();

            return $this->redirectToRoute('admin_classes_index');
        }

        return $this->render(self::_DIRECTORY.'admin_classes/new.html.twig', [
            'class' => $class,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_classes_show", methods={"GET"})
     * @param Classes $class
     * @return Response
     */
    public function show(Classes $class): Response
    {
        return $this->render(self::_DIRECTORY.'admin_classes/show.html.twig', [
            'class' => $class,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_classes_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Classes $class
     * @return Response
     */
    public function edit(Request $request, Classes $class): Response
    {
        $form = $this->createForm(ClassesType::class, $class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_classes_index');
        }

        return $this->render(self::_DIRECTORY.'admin_classes/edit.html.twig', [
            'class' => $class,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_classes_delete", options={"expose"=true})
     * @param Classes $id
     * @return Response
     */
    public function delete(Classes $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($id);
        $entityManager->flush();

        return $this->redirectToRoute('admin_classes_index');
    }
}
