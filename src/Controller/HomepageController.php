<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(EntityManagerInterface $em)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_ANONYMOUSLY ')) {
            dd("connected");
        }
        $repository = $em->getRepository(Product::class);
        $products = $repository->findAll();
        if(!$products) {
            throw $this->createNotFoundException('Sorry, there is no product');
        }

        return $this->render('homepage/index.html.twig', [
            "products" => $products
        ]);
    }
}
