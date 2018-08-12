<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as TaskAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="tblproductdata")
 * @UniqueEntity("productCode")
 * @TaskAssert\ConstraintTask
 */
class Product
{
    const PRODUCT = "Unsuccessful product: %s, %s, %s, %s, %s, %s";
    const FORMAT = "Y-m-d";
    const PREFIX = "set%s";

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="intProductDataId")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, name="strProductCode")
     * @Assert\NotBlank(message="Incorrect data")
     */
    private $productCode;

    /**
     * @ORM\Column(type="string", name="strProductName")
     * @Assert\NotBlank(message="Incorrect data")
     */
    private $productName;

    /**
     * @ORM\Column(type="string", name="strProductDesc")
     * @Assert\NotBlank(message="Incorrect data")
     */
    private $productDescription;

    /**
     * @ORM\Column(name="Added", type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP", name="dtmAdded")
     * @ORM\Version
     */
    private $added;

    /**
     * @ORM\Column(type="integer", name="stock")
     * @Assert\Type(type="integer", message="Incorrect data")
     */
    private $stock;

    /**
     * @ORM\Column(type="float", name="cost")
     * @Assert\Type(type="float", message="Incorrect data")
     * @Assert\LessThan(1000)
     */
    private $costInUSA;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="dtmDiscontinued")
     */
    private $discontinued;

    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP", name="stmTimestamp")
     * @ORM\Version
     */
    private $timestamp;

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            self::PRODUCT,
            $this->getProductCode(),
            $this->getProductName(),
            $this->getProductDescription(),
            $this->getStock(),
            $this->getCostInUSA(),
            $this->getDiscontinued()
        );
    }

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
     * @return null|string
     */
    public function getDiscontinued():?string
    {
        $date = $this->discontinued ? $this->discontinued->format(self::FORMAT) : null;

        return $date;
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
    public function setProductCode(string $productCode):void
    {
        $this->productCode = $productCode;
    }

    /**
     * @param string $productName
     */
    public function setProductName(string $productName):void
    {
        $this->productName = $productName;
    }

    /**
     * @param string $productDescription
     */
    public function setProductDescription(string $productDescription):void
    {
        $this->productDescription = $productDescription;
    }

    /**
     * @param string $stock
     */
    public function setStock($stock):void
    {
        $this->stock = (int) $stock;
    }

    /**
     * @param string $costInUSA
     */
    public function setCostInUSA($costInUSA):void
    {
        $this->costInUSA = (float) $costInUSA;
    }

    /**
     * @param string|null $discontinued
     */
    public function setDiscontinued(string $discontinued = null):void
    {
        $this->discontinued = $discontinued === "yes" ? new \DateTime() : null;
    }

    /**
     * @param array $product
     * @return Product
     */
    public function createFromArray(array $product):Product
    {
        foreach ($product as $key => $value) {
            $methodName = sprintf(self::PREFIX, ucfirst("$key"));
            $this->$methodName($value);
        }

        return $this;
    }
}