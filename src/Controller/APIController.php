<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class APIController extends AbstractController
{
     /**
     * @Route("v1/product/{category}/{productname}")
     */
    public function RestApi($category,$productname,EntityManagerInterface $em){
      
        $repository = $em->getRepository(Product::class);
        $product = $repository->findByNameAndCategory($productname, $category);
   
       $encoder = new JsonEncoder();
       $defaultContext = [
           AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
               return $object->getId();
           },
       ];
       $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
       $serializer = new Serializer([$normalizer], [$encoder]);
       return new JsonResponse($serializer->serialize($product, 'json'));
       
   }

     /**
    * @Route("test")
    */
   public function test(){
       $client = HttpClient::create();
       $response = $client->request('GET',"http://localhost:8000/v1/product/immobilier/z");
   //'https://api.themoviedb.org/3/movie/5?api_key=cbe364327a49b1c86ffcc7c688737058&language=fr'
       dd($response);
    }
}
