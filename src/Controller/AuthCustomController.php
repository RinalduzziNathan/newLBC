<?php

namespace App\Controller;

use App\Entity\UserImage;
use App\Entity\UserLogin;
use App\Form\UserLoginFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        $image = new UserImage();
        $form = $this->createForm(UserLoginFormType::class,$user);
        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
        if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            /** @var UploadedFile $File */
            $File = $form->get('userImage')->get('filename')->getData();

            $article = $form->getData(); // On récupère l'article associé
            $encoded = $encoder->encodePassword($article, $article->getPassword());
            $article->setPassword($encoded);
            $article->setCreationdate(New \DateTime());
            $article->setRoles(['ROLE_USER']);

            if ($File) {
                $originalFilename = pathinfo($File->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL

                $safeFilename = preg_replace('/[^A-Za-z0-9]/', "",$originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$File->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $File->move(
                        $this->getParameter('file_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $image->setFilename($newFilename);
                $image->setUser($user);
                $user->setImageUser($image);
            }

            $em->persist($image);
            $em->persist($article); // on le persiste
            $em->flush(); // on save
            return $this->redirectToRoute('index');
        }
        return $this->render('security/register.html.twig', ['form' => $form->createView()]); // Hop redirigé et on sort du controller
    }

    /**
     * @Route("/logout", name="app_logout")
    */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
        
    }

    /**
     * @Route("/profile/{id}", name="profile", methods={"GET"})
     */
    public function UserInfo(EntityManagerInterface $em, $id)
    {
        $repository = $em->getRepository(User::class);
        $user = $repository->find($id);
        if(!$user) {
            throw $this->createNotFoundException('Sorry, there is no user with this id');
        }
        return $this->render('profile.html.twig', [
            "user" => $user
        ]);
    }
}
