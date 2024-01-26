<?php
namespace App\Service;

use App\Entity\Product;
use DateTime;
use DateTimeImmutable;

class ProductsService
{
  public function createProductWithAllValues($sku, $productName, $description = null): Product
  {
    $newProduct = new Product();
    $newProduct->setSku($sku);
    $newProduct->setProductName($productName);
    $newProduct->setDescription($description);
    $newProduct->setCreatedAt(new DateTimeImmutable());
    return $newProduct;
  }

  public function editProductWithNoNewSku(Product $oldProduct, $productName, $description = null): Product
  {
    if ($productName != '') {
      $oldProduct->setProductName($productName);
    }
    if ($description != '') {
      $oldProduct->setDescription($description);
    }
    $oldProduct->setUpdateAt(new DateTime);
    return $oldProduct;
  }

  public function editProductWithNewSku(Product $oldProduct, $sku, $productName, $description = null): Product
  {
    $oldProduct->setSku($sku);
    if ($description != '') {
      $oldProduct->setDescription($description);
    }
    if ($productName != '') {
      $oldProduct->setProductName($productName);
    }
    $oldProduct->setUpdateAt(new DateTime);
    return $oldProduct;
  }
}
