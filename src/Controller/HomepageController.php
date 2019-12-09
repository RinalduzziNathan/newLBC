<?php

namespace App\Controller;

use App\Form\SearchProductFormType;
use App\Form\SendMailFormType;
use Swift_Mailer;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Openbuildings\Swiftmailer\CssInlinerPlugin;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

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

        $formMail = $this->createForm(SendMailFormType::class);
        $formMail->handleRequest($request);
        if ($formMail->isSubmitted() && $formMail->isValid()) {
            $email = $formMail->getData()['email'];
            return $this->redirectToRoute('sendmail', ["email" => $email]);
        }

        $formSearch = $this->createForm(SearchProductFormType::class);
        $formSearch->handleRequest($request); // On récupère le formulaire envoyé dans la requête

        if ($formSearch->isSubmitted() && $formSearch->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $repository = $em->getRepository(Product::class);
            $article = $formSearch->getData(); // On récupère l'article associé
            $name = $article["recherche"];
            $names = $repository->findByName($name);
            return $this->render('product/recherche.html.twig', ['formSearch' => $formSearch->createView(), 'formMail' => $formMail->createView(), 'result'=>$names]); // Hop redirigé et on sort du controller
        }
            return $this->render('homepage/index.html.twig', [
                'formSearch' => $formSearch->createView(),"products" => $products, 'formMail' => $formMail->createView()
        ]);
    }

    /**
     * @Route("/sendmail/{email}", name="sendmail")
     */
    public function SendMail(\Swift_Mailer $mailer, $email, EntityManagerInterface $em,Request $request)
    {
        $converter = new CssToInlineStyles();
        $css = file_get_contents('../public/css/core-style.css');
        $converter->convert($css);
        $mailer->registerPlugin(new CssInlinerPlugin($converter));

        $formSearch = $this->createForm(SearchProductFormType::class);
        $formSearch->handleRequest($request); // On récupère le formulaire envoyé dans la requête

        if ($formSearch->isSubmitted() && $formSearch->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $repository = $em->getRepository(Product::class);
            $article = $formSearch->getData(); // On récupère l'article associé
            $name = $article["recherche"];
            $names = $repository->findByName($name);
            return $this->render('product/recherche.html.twig', ['formSearch' => $formSearch->createView(),'names'=>$names]); // Hop redirigé et on sort du controller
        }

        $repository = $em->getRepository(Product::class);
        $products = $repository->findallWithLimit(6);
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('maiscetaitsur@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'email/email.html.twig', [
                    "products" => $products,'formSearch' => $formSearch->createView()
                ]),'text/html'
            )
            ->addPart(
                $this->renderView(
                // templates/emails/registration.txt.twig
                    'email/email.html.twig',
                    ['products' => $products,'formSearch' => $formSearch->createView()]
                ),
                'text/plain'
            )
        ;
        $mailer->send($message);

        return $this->redirectToRoute("index", [
            'formSearch' => $formSearch->createView()
        ]);
    }

    /**
     * @Route("/mail", name="mail")
     */
    public function Mail(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('email/email.html.twig', [
            "products" => $products
        ]);
    }
}
