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
 * @Route("lms-admin.php/admin/etudiant")
 */
class AdminEtudiantController extends AbstractController
{
    /**
     * @Route("/etudian_list", name="admin_etudiant_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, new User());
        return $this->render('admin/admin_etudiant/index.html.twig', [
            'users' => $userRepository->findByRoles("ROLE_ETUDIANT"),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new_etudiant", name="admin_etudiant_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserManager $userManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->create($user,$form->get('password')->getData(),"ROLE_ETUDIANT");
            $userManager->save($user);

            return $this->redirectToRoute('admin_etudiant_index');
        }

        return $this->render('admin/admin_etudiant/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{user}/edit", name="admin_etudiant_edit",options={"expose"=true} )
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function edit(User $user,Request $request,UserManager $userManager){
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_etudiant_index');
        }

        return $this->render('admin/admin_etudiant/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{user}", name="admin_etudiant_show", methods={"GET"},options={"expose"=true})
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('admin/admin_etudiant/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/delete/{user}", name="admin_etudiant_delete",options={"expose"=true})
     */
    public function delete( User $user):Response
    {


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('admin_user_list');
    }

}
