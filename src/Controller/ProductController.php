<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\UserLogin;
use App\Entity\ProductImage;
use App\Form\CreateProductFormType;
use App\Form\SearchProductFormType;
use App\Form\SendMailFormType;
use App\Form\UpdateProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;



use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends AbstractController
{

    /**
     * @Route("/shop",name="shop")
     **/
    public function categories(EntityManagerInterface $em) {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_ANONYMOUSLY ')) {
            dd("connecetd");
        }
        $repository = $em->getRepository(Product::class);
        $products = $repository->findAll();
        if(!$products) {
            throw $this->createNotFoundException('Sorry, there is no product');
        }
        return $this->render('product/categories.html.twig', [
            "products" => $products
        ]);
    }

    /**
     * @Route("/product/{productId}",name="productDetails")
     **/
    public function productDetails(EntityManagerInterface $em, $productId) {
        $repository = $em->getRepository(Product::class);
        $product = $repository->find($productId);
        $repository = $em->getRepository(UserLogin::class);
        $userid = $product->getUser()->getId();
        $user = $repository->find($userid);
        if(!$product) {
            throw $this->createNotFoundException('Sorry, there is no product with this id');
        }
        if(!$user) {
            throw $this->createNotFoundException('Sorry, there is no user attach to this product');
        }
        return $this->render('product/productDetails.html.twig', [
            "product" => $product,
            "user" => $user
        ]);
    }
    /**
     * @Route("/maps/{ville}/{pays}",name="maps")
     **/
    public function maps($ville, $pays) {
        return $this->render('maps.html.twig', [
            "ville" => $ville,
            "pays" =>$pays
        ]);
    }


    /**
     * @Route("/publishproduct", name="publishproduct")
     */
    public function CreateProduct(Request $request, EntityManagerInterface $em, Security $security)
    {
        if( !$security->isGranted('IS_AUTHENTICATED_FULLY') ){
            return $this->redirectToRoute('app_login');
        }

        $formMail = $this->createForm(SendMailFormType::class);
        $formMail->handleRequest($request);
        if ($formMail->isSubmitted() && $formMail->isValid()) {
            $email = $formMail->getData()['email'];
            return $this->redirectToRoute('sendmail', ["email" => $email]);
        }




        $product = new Product();
        $form = $this->createForm(CreateProductFormType::class,$product);
        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
        if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $article = $form->getData(); // On récupère l'article associé
            $article->setUser($security->getUser());
            $article->setPublishdate(New \DateTime());
            $article->clear();
            /** @var UploadedFile $File */
            $Files = $form->get('productImages');

            if ($Files) {
                foreach ($Files as $requestFile){

                    $image = new ProductImage();
                    $File = $requestFile->get('filename')->getData();
                    $originalFilename = pathinfo($File->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = preg_replace('/[^A-Za-z0-9]/', "", $originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $File->guessExtension();

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
                    $image->setProduct($product);
                    $product->addProductImage($image);

                    //$em->persist($image);

                }
            }

            $em->persist($article); // on le persiste
            $em->flush(); // on save

            return $this->redirectToRoute('index'); // Hop redirigé et on sort du controller
        }

        return $this->render('product/publishproduct.html.twig', ['form' => $form->createView(),'formMail' => $formMail->createView()]); // on envoie ensuite le formulaire au template
    }

    /**
     * @Route("/editproduct/{productid}", name="editproduct")
     */
    public function EditProduct(Request $request, EntityManagerInterface $em, Security $security, $productid)
    {
        if( !$security->isGranted('IS_AUTHENTICATED_FULLY') ){
            return $this->redirectToRoute('app_login');
        }
        $product = new Product();
        $product = $em->getRepository(Product::class)->find($productid);
        if($this->getUser() == $product->getUser()) {
            $form = $this->createForm(UpdateProductFormType::class, $product, [
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'category' => $product->getCategory(),
                'state' => $product->getState(),
            ]);
            $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
            if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
                $article = $form->getData(); // On récupère l'article associé
                $article->setUser($security->getUser());
                $article->setPublishdate(New \DateTime());
                //$article->clear();

                $em->persist($article); // on le persiste
                $em->flush(); // on save

                return $this->redirectToRoute('index'); // Hop redirigé et on sort du controller
            }
            return $this->render('product/updateproduct.html.twig', ['form' => $form->createView()]); // on envoie ensuite le formulaire au template
        }
        else {
            return $this->redirectToRoute("index");
        }
    }

    /**
     * @Route("/searchproduct", name="searchproduct")
     */
    public function SearchProduct(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(SearchProductFormType::class);
        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
        if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $repository = $em->getRepository(Product::class);
            $article = $form->getData(); // On récupère l'article associé
            $name = $article["recherche"];
            $names = $repository->findByName($name);
            if(!$names) {
                throw $this->createNotFoundException('Sorry, there is no product with this name');
            }
            return $this->render('test.html.twig', ['form' => $form->createView(), 'result'=>$names]); // Hop redirigé et on sort du controller
        }
        return $this->render('test.html.twig', ['form' => $form->createView()]); // on envoie ensuite le formulaire au template
    }
    /**
     * @Route("/searchproductbycategory/{category}", name="searchproductbycategory")
     */
    public function SearchProductByCategory(Request $request, EntityManagerInterface $em, $category)
    {
        $form = $this->createForm(SearchProductFormType::class);
        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
        if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $repository = $em->getRepository(Product::class);
            $article = $form->getData(); // On récupère l'article associé
            $name = $article["recherche"];
            $names = $repository->findByNameAndCategory($name, $category);
            if(!$names) {
                throw $this->createNotFoundException('Sorry, there is no product with this name');
            }
            return $this->render('test.html.twig', ['form' => $form->createView(), 'result'=>$names]); // Hop redirigé et on sort du controller
        }
        return $this->render('test.html.twig', ['form' => $form->createView()]); // on envoie ensuite le formulaire au template
    }

     /**
     * @Route("/product/immobilier/{productname}")

     */
    public function GetMeubleName($productname,EntityManagerInterface $em){
         $Array = [
            1=>["tête","pied","jambe","rein"],
            2=>"jaaaaj",
            3=>"foo()"
        ];
         $repository = $em->getRepository(Product::class);
         $product = $repository->findByNameAndCategory($productname, "immobilier");
            dd($product);
        // $encoders = array(new JsonEncoder());
        // $normalizers = array(new ObjectNormalizer());
        // $serializer = new Serializer($normalizers, $encoders);
        // $productSerialized = $serializer->serialize($product, 'json');
       
        $response = new Response(json_encode($product));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }



}
