<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  @Route("/lms-admin.php", name="admin_")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/list", name="user_list", methods={"GET"})
     * @IsGranted({"ROLE_SUPER_ADMIN"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/admin_user/index.html.twig', [
            'users' => $userRepository->findByRoles("ROLE_ADMIN"),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @IsGranted({"ROLE_SUPER_ADMIN"})
     */
    public function new(Request $request,UserManager $userManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userManager->create($user,$form->get('password')->getData(),"ROLE_ADMIN");
            $userManager->save($user);

            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/admin_user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @IsGranted({"ROLE_SUPER_ADMIN"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/admin_user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @IsGranted({"ROLE_SUPER_ADMIN"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/admin_user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     * @IsGranted({"ROLE_SUPER_ADMIN"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }
}
