<?php

namespace App\Controller;

use App\Entity\Mention;
use App\Form\MentionType;
use App\Repository\MentionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/mention")
 */
class AdminMentionController extends AbstractController
{
    /**
     * @Route("/", name="admin_mention_index", methods={"GET"})
     */
    public function index(MentionRepository $mentionRepository): Response
    {
        return $this->render('admin_mention/index.html.twig', [
            'mentions' => $mentionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_mention_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $mention = new Mention();
        $form = $this->createForm(MentionType::class, $mention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mention);
            $entityManager->flush();

            return $this->redirectToRoute('admin_mention_index');
        }

        return $this->render('admin_mention/new.html.twig', [
            'mention' => $mention,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_mention_show", methods={"GET"})
     */
    public function show(Mention $mention): Response
    {
        return $this->render('admin_mention/show.html.twig', [
            'mention' => $mention,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_mention_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Mention $mention): Response
    {
        $form = $this->createForm(MentionType::class, $mention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_mention_index');
        }

        return $this->render('admin_mention/edit.html.twig', [
            'mention' => $mention,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_mention_delete", methods={"POST"})
     */
    public function delete(Request $request, Mention $mention): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mention->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mention);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_mention_index');
    }
}
