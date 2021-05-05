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
 * @Route("lms-admin.php/admin/mention",name="admin_")
 */
class AdminMentionController extends AbstractController
{
    const _DIRECTORY = 'admin/';

    /**
     * @Route("/", name="mention_index", methods={"GET"})
     * @param MentionRepository $mentionRepository
     * @return Response
     */
    public function index(MentionRepository $mentionRepository): Response
    {
        return $this->render(self::_DIRECTORY.'admin_mention/index.html.twig', [
            'mentions' => $mentionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mention_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
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

        return $this->render(self::_DIRECTORY.'admin_mention/new.html.twig', [
            'mention' => $mention,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{mention}", name="mention_show", methods={"GET"},options={"expose"=true},requirements={"user":"\d+"})
     * @param Mention $mention
     * @return Response
     */
    public function show(Mention $mention): Response
    {
        return $this->render(self::_DIRECTORY.'admin_mention/show.html.twig', [
            'mention' => $mention,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mention_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Mention $mention
     * @return Response
     */
    public function edit(Request $request, Mention $mention): Response
    {
        $form = $this->createForm(MentionType::class, $mention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_mention_index');
        }

        return $this->render(self::_DIRECTORY.'admin_mention/edit.html.twig', [
            'mention' => $mention,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="mention_delete",options={"expose"=true})
     */
    public function delete(Mention $id): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($id);
            $entityManager->flush();
            return $this->redirectToRoute('admin_mention_index');
    }
}
