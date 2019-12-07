<?php

namespace App\Controller;

use Swift_Mailer;
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

    /**
     * @Route("/sendmail", name="sendmail")
     */
    public function SendMail(Swift_Mailer $mailer)
    {

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('maiscetaitsur@gmail.com')
            ->setTo('kraknistic.43@gmail.com')
            ->setBody(
                "Hey c'est un super mail ça!!"
            )
        ;
        $mailer->send($message);

        return $this->redirectToRoute("index");
    }
}
