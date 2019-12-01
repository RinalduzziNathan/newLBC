<?php

namespace App\Controller;

use App\Entity\UserLogin;
use App\Form\UserLoginFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthCustomController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('index');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

       // dd($lastUsername);
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        //return new RedirectResponse($this->urlGenerator->generate('/login'));
    }
    /**
     * @Route("/register", name="register")
    */
    public function register(Request $request, UserPasswordEncoderInterface $encoder,EntityManagerInterface $em)
    {
        $user = new UserLogin();
        $form = $this->createForm(UserLoginFormType::class,$user);
        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
        if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $article = $form->getData(); // On récupère l'article associé
            $encoded = $encoder->encodePassword($article, $article->getPassword());

       

            $article->setPassword($encoded);
          //  $article->setCreationdate(New \Dat());
            $article->setRoles(['ROLE_USER']);
         //   $article->setChangedate(New \DateTime());

            $em->persist($article); // on le persiste
            $em->flush(); // on save
            return $this->redirectToRoute('index');
        }
        return $this->render('register.html.twig', ['form' => $form->createView()]); // Hop redirigé et on sort du controller
    }

    /**
     * @Route("/logout", name="app_logout")
    */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
        
    }
    /**
     * @Route("/index", name="index")
    */
    public function GoIndex()
    {
        return $this->render('index.html.twig');
    }
}
