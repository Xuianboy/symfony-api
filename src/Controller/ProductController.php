<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class ProductController extends AbstractController
{
    private $serializer;
    private $productRepository;
    private $doctrine;


    public function __construct(SerializerInterface $serializer, ProductRepository $productRepository, ManagerRegistry $doctrine)
    {
        $this->serializer = $serializer;
        $this->productRepository = $productRepository;
        $this->doctrine = $doctrine;
    }

    #[Route('/product', name: 'product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @return Response
     */
    public function showAllProducts()
    {
        $product = $this->productRepository->findAll();

        $json = $this->serializer->serialize($product,'json',['groups' => 'show_product']);

        return new Response($json,Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return Response
     */
    public function showOneProducts($id)
    {
        $product = $this->productRepository->find($id);

        if (!$product){
            throw $this->createNotFoundException('No products found for id = '.$id);
        }

        $json = $this->serializer->serialize($product, 'json',['groups' => 'show_product']);
        return new Response($json,Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createProducts(Request $request): Response
    {
        $entityManager = $this->doctrine->getManager();
        $json = $request->getContent();

        $product_object = $this->serializer->deserialize($json, Product::class, 'json');


        $entityManager->merge($product_object);
        $entityManager->flush();

        /*$arrJson = $request->toArray();
        $entityManager = $doctrine->getManager();

        $product = new Product();
        if (isset($arrJson)) {
            $product->setName($arrJson['name']);
            $product->setDescription($arrJson['description']);
            $product->setPrice($arrJson['price']);
            $product->setCategory($arrJson['category_id']);

            $entityManager->persist($product);
            $entityManager->flush();

            $errors = $validator->validate($product);
            if(count($errors) > 1){
                return new Response((string) $errors,400);
            }
            return new Response('Create product! with Id:='.$product->getId(),Response::HTTP_CREATED);
        }else{
            return new Response('Errors in data, please again try',Response::HTTP_BAD_REQUEST);
        }*/
        return new Response('Created new product!',Response::HTTP_CREATED);
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function updateProducts($id, Request $request)
    {
        $product = $this->productRepository->find($id);
        $get_json = $request->getContent();

        $json_array = json_decode($get_json,true);

        $product->setName($json_array["name"]);
        $product->setDescription($json_array["description"]);
        $product->setPrice($json_array["price"]);
        $product->getCategory()->setName($json_array["category"]["name"]);

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return new Response('Update success for id='.$id, Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function deleteProducts(int $id)
    {
        $entityManager = $this->doctrine->getManager();
        $product = $this->productRepository->find($id);

        $entityManager->remove($product);
        $entityManager->flush();

        return new Response("Delete product with id=".$id, Response::HTTP_ACCEPTED);
    }



}
