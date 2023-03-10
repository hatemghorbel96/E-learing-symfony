<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Video;
use App\Entity\Course;
use App\Entity\Category;
use App\Entity\Technology;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('E-learning test app');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('user', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-user', Category::class);
        yield MenuItem::linkToCrud('Technologies', 'fas fa-user', Technology::class);
        yield MenuItem::linkToCrud('Courses', 'fas fa-user', Course::class);
        yield MenuItem::linkToCrud('videos', 'fas fa-user', Video::class);
    }
}
