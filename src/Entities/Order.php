<?php

namespace Entities;

use DateTime;
use SmartShop\Entity;

/**
 * @Entity
 * @HasLifecycleCallbacks 
 * @Table(name="ss_order")
 */
class Order extends Entity
{
    /**
     * {@inheritdoc}
     */
    protected static $repository = "Entities\Order";

    /** 
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    public $id;

    /**
     * @OneToOne(targetEntity="Cart")
     * @JoinColumn(name="id_cart", referencedColumnName="id")
     */
    public $cart;

    /**
     * @Column(type="float")
     */
    public $total_price;

    /**
     * @Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    public $date_placed;

    /**
     * Creating new order depends on Cart
     * 
     * @param Cart $cart Cart from which order will be created
     * 
     * @return self|false New order ID or false on fail
     */
    public static function create($cart)
    {
        global $entity_manager;

        $order = (new self())
            ->setTotalPrice($cart->getCartTotal())
            ->setCart($cart);

        $entity_manager->persist($order);

        foreach($cart->getCartContents() as $row) {
            $order->createOrderDetail($row);
        }

        return $order;
    }

    /**
     * Creates order detail by Cart content
     * 
     * @param CartContent $cart_content Cart content array
     * 
     * @return 
     */
    public function createOrderDetail($cart_content)
    {
        global $entity_manager;

        $product = Product::getById($cart_content->getIdProduct());
        $order_detail = (new OrderDetail())
            ->setOrder($this)
            ->setIdProduct($product->getId())
            ->setProductName($product->getName())
            ->setProductPrice($product->getPrice())
            ->setQuantity($cart_content->getQuantity());

        $entity_manager->persist($order_detail);
        return $order_detail;
    }

    /** 
     *  @PrePersist 
     */
    public function doStuffOnPrePersist()
    {
        $this->date_placed = new DateTime('NOW');
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set totalPrice.
     *
     * @param float $totalPrice
     *
     * @return Order
     */
    public function setTotalPrice($totalPrice)
    {
        $this->total_price = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice.
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->total_price;
    }

    /**
     * Set datePlaced.
     *
     * @param \DateTime $datePlaced
     *
     * @return Order
     */
    public function setDatePlaced($datePlaced)
    {
        $this->date_placed = $datePlaced;

        return $this;
    }

    /**
     * Get datePlaced.
     *
     * @return \DateTime
     */
    public function getDatePlaced()
    {
        return $this->date_placed;
    }

    /**
     * Set cart.
     *
     * @param \Entities\Cart|null $cart
     *
     * @return Order
     */
    public function setCart(\Entities\Cart $cart = null)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart.
     *
     * @return \Entities\Cart|null
     */
    public function getCart()
    {
        return $this->cart;
    }
}
