<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CreateProduct;
use App\Service\ProductsService;
use DateTimeImmutable;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class ProductController extends AbstractController
{
  #[Route('', name: 'app_product_index', methods: ['GET'])]
  public function index(ProductRepository $productRepository): Response
  {
    return $this->render('product/index.html.twig', [
      'products' => $productRepository->findAll(),
    ]);
  }

  #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
  public function new(Request $request, ProductRepository $productRepository, EntityManagerInterface $entityManager, ProductsService $productsService): Response
  {
    if ($request->isMethod('POST')) {
      $products = $request->request->all();
      $skuerrors = [];
      foreach ($products['products'] as $product) {
        if ($productRepository->exists($product[0]) != []) {
          array_push($skuerrors, $product[0]);
        }
      }
      if (count($skuerrors) == 0) {
        foreach ($products['products'] as $product) {
          $newProduct = $productsService->createProductWithAllValues($product[0], $product[1], $product[2]);
          $entityManager->persist($newProduct);
          $entityManager->flush();
        }
        $this->addFlash('resultProductRequest', 'You created the products correctly!');
        return $this->redirectToRoute('app_product_index');
      } else {
        return $this->render('product/new.html.twig', [
          'errors' => $skuerrors
        ]);
      }
    }
    return $this->render('product/new.html.twig');
  }

  #[Route('/edit', name: 'app_products_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, ProductRepository $productRepository, EntityManagerInterface $entityManager, SessionInterface $session, ProductsService $productsService): Response
  {
    if ($request->isMethod('POST')) {
      $anySkuFails = false;
      $products = $request->request->all();
      foreach ($products['updatedProducts'] as $key => $product) {
        // $product[0] = NEW SKU | $product[1] = NEW DESCRIPTION | $product[2] = NEW NAME
        $sku = explode(' |', $products['oldskus'][$key]);
        // if the user doesn't specify a new sku value, that means is a empty string value. so it should update only the other fields. 
        // Also, there's no need to validate any data beccause there isn't any constraints.
        if ($product[0] == '') {
          $oldProduct = $productRepository->findOneBySku($sku[0]);
          $oldProduct = $productsService->editProductWithNoNewSku($oldProduct, $product[2], $product[1]);
          $entityManager->persist($oldProduct);
        } else {
          $oldProduct = $productRepository->findOneBySku($sku[0]);
          if ($productRepository->exists($product[0]) != []) {
            // if any SKU code that the user wants to put, exists in the database, i will not flush any of the persisted entities, and i will return a flash message.
            $anySkuFails = true;
          } else {
            // if doesn't exists any product with the new SKU that the users wants, i will persist the updated entity.
            $oldProduct = $productsService->editProductWithNewSku($oldProduct, $product[0], $product[2], $product[1]);
            $entityManager->persist($oldProduct);
          }
        }
      }
      if ($anySkuFails) {
        $this->addFlash('resultProductRequest', 'Oops... it seems that a new sku that you provided was already in the database.');
        return $this->redirectToRoute('app_product_index');
      } else {
        $entityManager->flush();
        $this->addFlash('resultProductRequest', 'You updated the products correctly!');
        return $this->redirectToRoute('app_product_index');
      }
    }
    return $this->render('product/edit.html.twig', [
      'skus' => $entityManager->getRepository(Product::class)->findAll(),
    ]);
  }
}
