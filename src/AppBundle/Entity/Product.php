<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Product
{
    /**
     * @Assert\NotBlank(message="Incorrect data")
     */
    private $productCode;

    /**
     * @Assert\NotBlank(message="Incorrect data")
     */
    private $productName;

    /**
     * @Assert\NotBlank(message="Incorrect data")
     */
    private $productDescription;

    /**
     * @Assert\Type(type="integer", message="Incorrect data")
     */
    private $stock;

    /**
     * @Assert\Type(type="float", message="Incorrect data")
     */
    private $costInUSA;

    /**
     * @var
     */
    private $discontinued;

    public function getProductCode()
    {
        return $this->productCode;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function getProductDescription()
    {
        return $this->productDescription;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getCostInUSA()
    {
        return $this->costInUSA;
    }

    public function getDiscontinued()
    {
        return $this->discontinued;
    }

    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;
    }

    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    public function setProductDescription($productDescription)
    {
        $this->productDescription = $productDescription;
    }

    public function setStock($stock)
    {
        $this->stock = (integer) $stock;
    }

    public function setCostInUSA( $costInUSA)
    {
        $this->costInUSA = (float) $costInUSA;
    }

    public function setDiscontinued($discontinued)
    {
        if($discontinued === "yes") {
            $this->discontinued = date('Y-m-d H:i');
        } else {
            $this->discontinued = null;
        }
    }
}