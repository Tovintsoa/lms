<?php
namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminDashboardController
 * @package App\controller
 * @Route("/lms-admin.php", name="admin_")
 * @IsGranted({"ROLE_PROFESSEUR"})
 */
class AdminDashboardController extends AbstractController{

    /**
     * @Route("/", name="index", methods={"GET","POST"})
     */
    public function index(){
        return $this->render('admin/dashboard/index.html.twig',[

        ]);
    }
}