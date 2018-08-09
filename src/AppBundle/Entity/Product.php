<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Products")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank(message="Incorrect data")
     */
    private $productCode;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Incorrect data")
     */
    private $productName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Incorrect data")
     */
    private $productDescription;

    /**
     * @ORM\Column(name="Added", type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     * @ORM\Version
     */
    private $added;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type(type="integer", message="Incorrect data")
     */
    private $stock;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type(type="float", message="Incorrect data")
     */
    private $costInUSA;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $discontinued;

    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     * @ORM\Version
     */
    private $timestamp;

    /**
     * @return int
     */
    public function getProductId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProductCode():string
    {
        return $this->productCode;
    }

    /**
     * @return string
     */
    public function getProductName():string
    {
        return $this->productName;
    }

    /**
     * @return string
     */
    public function getProductDescription():string
    {
        return $this->productDescription;
    }

    /**
     * @return \DateTime
     */
    public function getAdded():\DateTime
    {
        return $this->added;
    }

    /**
     * @return int
     */
    public function getStock():int
    {
        return $this->stock;
    }

    /**
     * @return float
     */
    public function getCostInUSA():float
    {
        return $this->costInUSA;
    }

    /**
     * @return \DateTime
     */
    public function getDiscontinued():\DateTime
    {
        return $this->discontinued;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp():\DateTime
    {
        return $this->timestamp;
    }

    /**
     * @param string $productCode
     */
    public function setProductCode(string $productCode)
    {
        $this->productCode = $productCode;
    }

    /**
     * @param string $productName
     */
    public function setProductName(string $productName)
    {
        $this->productName = $productName;
    }

    /**
     * @param string $productDescription
     */
    public function setProductDescription(string $productDescription)
    {
        $this->productDescription = $productDescription;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock)
    {
        $this->stock = $stock;
    }

    /**
     * @param float $costInUSA
     */
    public function setCostInUSA(float $costInUSA)
    {
        $this->costInUSA = $costInUSA;
    }

    /**
     * @param string $discontinued
     */
    public function setDiscontinued(string $discontinued)
    {
        if($discontinued === "yes") {
            $this->discontinued = date('Y-m-d H:i');
        } else {
            $this->discontinued = null;
        }
    }
}