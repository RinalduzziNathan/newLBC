<?php

namespace App\Controller;

use App\Form\SendMailFormType;
use Swift_Mailer;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(EntityManagerInterface $em, Request $request)
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

        $formMail = $this->createForm(SendMailFormType::class);
        $formMail->handleRequest($request);
        if ($formMail->isSubmitted() && $formMail->isValid()) {
            $email = $formMail->getData()['email'];
            return $this->redirectToRoute('sendmail', ["email" => $email]);
        }

            return $this->render('homepage/index.html.twig', [
            "products" => $products, 'formMail' => $formMail->createView()
        ]);
    }

    /**
     * @Route("/sendmail/{email}", name="sendmail")
     */
    public function SendMail(Swift_Mailer $mailer, $email)
    {

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('maiscetaitsur@gmail.com')
            ->setTo($email)
            ->setBody(
                "Hey c'est un super mail ça!!"
            )
        ;
        $mailer->send($message);

        return $this->redirectToRoute("index");
    }
}
