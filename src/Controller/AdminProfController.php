<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("lms-admin.php/admin/prof")
 */
class AdminProfController extends AbstractController
{
    /**
     * @Route("/liste_prof", name="admin_prof_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, new User());
        return $this->render('admin/admin_prof/index.html.twig', [
            'users' => $userRepository->findByRoles('ROLE_PROFESSEUR'),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newProf", name="admin_prof_new", methods={"GET","POST"})
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
            $userManager->create($user,$form->get('password')->getData(),"ROLE_PROFESSEUR");
            $userManager->save($user);

            return $this->redirectToRoute('admin_prof_index');
        }

        return $this->render('admin/admin_prof/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{user}/edit", name="admin_prof_edit",options={"expose"=true} )
     * @param User $user
     * @param Request $request
     * @param UserManager $userManager
     * @return Response
     */
    public function edit(User $user,Request $request,UserManager $userManager){
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_prof_index');
        }

        return $this->render('admin/admin_admin/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{user}", name="admin_prof_show", methods={"GET"},options={"expose"=true})
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('admin/admin_prof/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/delete/{user}", name="admin_prof_delete",options={"expose"=true})
     * @param User $user
     * @return Response
     */
    public function delete( User $user):Response
    {


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('admin_user_list');
    }

}
