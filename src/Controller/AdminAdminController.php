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
 * * @IsGranted({"ROLE_SUPER_ADMIN"})
 */
class AdminAdminController extends AbstractController
{

    /**
     * @Route("/list", name="user_list", methods={"GET"})
     */
    public function index(UserRepository $userRepository,Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        return $this->render('admin/admin_admin/index.html.twig', [
            'users' => $userRepository->findByRoles("ROLE_ADMIN"),
            'form' => $form->createView(),
            //'user' => $user,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @param UserManager $userManager
     * @return Response
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

        return $this->render('admin/admin_admin/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{user}/edit", name="admin_edit",options={"expose"=true} )
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function edit(User $user,Request $request,UserManager $userManager){
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/admin_admin/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{user}", name="admin_show", methods={"GET"},options={"expose"=true})
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('admin/admin_admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/delete/{user}", name="admin_delete",options={"expose"=true})
     */
    public function delete( User $user):Response
    {


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('admin_user_list');
    }
}