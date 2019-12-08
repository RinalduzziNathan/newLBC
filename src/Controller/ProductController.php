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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    /**
     * @Route("/shop",name="shop")
     **/
    public function categories(EntityManagerInterface $em, Request $request) {
        $formMail = $this->createForm(SendMailFormType::class);
        $formMail->handleRequest($request);
        if ($formMail->isSubmitted() && $formMail->isValid()) {
            $email = $formMail->getData()['email'];
            return $this->redirectToRoute('sendmail', ["email" => $email]);
        }

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_ANONYMOUSLY ')) {
            dd("connecetd");
        }
        $repository = $em->getRepository(Product::class);
        $products = $repository->findAll();
        if(!$products) {
            throw $this->createNotFoundException('Sorry, there is no product');
        }

        $formSearch = $this->createForm(SearchProductFormType::class);
        $formSearch->handleRequest($request); // On récupère le formulaire envoyé dans la requête

        if ($formSearch->isSubmitted() && $formSearch->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $repository = $em->getRepository(Product::class);
            $article = $formSearch->getData(); // On récupère l'article associé
            $name = $article["recherche"];
            $names = $repository->findByName($name);
            if(!$names) {
                throw $this->createNotFoundException('Sorry, there is no product with this name');
            }
            return $this->render('product/recherche.html.twig', ['formSearch' => $formSearch->createView(), 'formMail' => $formMail->createView(), 'result'=>$names]); // Hop redirigé et on sort du controller
        }


        return $this->render('product/categories.html.twig', [
            'formSearch' => $formSearch->createView(),
            "products" => $products,
            'formMail' => $formMail->createView()
        ]);
    }
    /**
     * @Route("/deleteproduct/{productid}", name="deleteproduct")
     */
    public function DeleteProduct(Request $request, EntityManagerInterface $em, Security $security, $productid)
    {
        if( !$security->isGranted('IS_AUTHENTICATED_FULLY') ){
            return $this->redirectToRoute('app_login');
        }
        $product = $em->getRepository(Product::class)->find($productid);
        if($product==null){
            return $this->redirectToRoute('index'); 
        }
        
        if($this->getUser() == $product->getUser()) {
            $em->remove($product); 
            $em->flush();
        }
        return $this->redirectToRoute('index'); 
    }
    /**
     * @Route("/product/{productId}",name="productDetails")
     **/
    public function productDetails(EntityManagerInterface $em, Request $request, $productId) {
        $formMail = $this->createForm(SendMailFormType::class);
        $formMail->handleRequest($request);
        if ($formMail->isSubmitted() && $formMail->isValid()) {
            $email = $formMail->getData()['email'];
            return $this->redirectToRoute('sendmail', ["email" => $email]);
        }

        $formSearch = $this->createForm(SearchProductFormType::class);
        $formSearch->handleRequest($request); // On récupère le formulaire envoyé dans la requête

        $repository = $em->getRepository(Product::class);
        $product = $repository->find($productId);
        if($product==null){
            return $this->redirectToRoute('index'); 
        }
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
            "user" => $user,
            'formMail' => $formMail->createView(),
            'formSearch' => $formSearch->createView()
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

        $formMail = $this->createForm(SendMailFormType::class);
        $formMail->handleRequest($request);
        if ($formMail->isSubmitted() && $formMail->isValid()) {
            $email = $formMail->getData()['email'];
            return $this->redirectToRoute('sendmail', ["email" => $email]);
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
            return $this->render('product/updateproduct.html.twig', ['form' => $form->createView(), 'formMail' => $formMail->createView()]); // on envoie ensuite le formulaire au template
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
            return $this->render('recherche.html.twig', ['formSearch' => $formSearch->createView(), 'formMail' => $formMail->createView(), 'result'=>$names]); // Hop redirigé et on sort du controller
        }

        return $this->render('recherche.html.twig', ['formSearch' => $formSearch->createView(), 'formMail' => $formMail->createView()]); // on envoie ensuite le formulaire au template
    }
    /**
     * @Route("/searchproductbycategory/{category}", name="searchproductbycategory")
     */
    public function SearchProductByCategory(Request $request, EntityManagerInterface $em, $category)
    {
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
            $names = $repository->findByNameAndCategory($name, $category);
            if(!$names) {
                throw $this->createNotFoundException('Sorry, there is no product with this name');
            }
            return $this->render('recherche.html.twig', ['formSearch' => $formSearch->createView(), 'formMail' => $formMail->createView(), 'result'=>$names]); // Hop redirigé et on sort du controller
        }
        return $this->render('recherche.html.twig', ['formSearch' => $formSearch->createView(), 'formMail' => $formMail->createView()]); // on envoie ensuite le formulaire au template
    }

     /**
     * @Route("v1/product/{category}/{productname}")
     */
    public function RestApi($category,$productname,EntityManagerInterface $em){
      
         $repository = $em->getRepository(Product::class);
         $product = $repository->findByNameAndCategory($productname, "immobilier");
    
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);
        //dd($product);
        return new JsonResponse($serializer->serialize($product, 'json'));
        
    }

      /**
     * @Route("test")
     */
    public function test(){
        $client = HttpClient::create();
        $response = $client->request('GET',"http://localhost:8000/v1/product/immobilier/z");
    //'https://api.themoviedb.org/3/movie/5?api_key=cbe364327a49b1c86ffcc7c688737058&language=fr'
     
    }
}
