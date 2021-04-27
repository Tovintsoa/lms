<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminProfileController
 * @package App\Controller
 * @Route("lms-admin.php/admin/profile",name="admin_profile_")
 */
class AdminProfileController extends AbstractController
{
    /**
     * @Route("/modifier-profile", name="update")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('admin/admin_profile/index.html.twig', [
            'controller_name' => 'AdminProfileController',
            'user' => $user,
        ]);
    }
}
