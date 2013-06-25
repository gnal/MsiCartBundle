<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CartItemController extends Controller
{
    public function listAction()
    {
        return $this->render('MsiStoreBundle:CartItem:list.html.twig');
    }

    public function newAction()
    {
        $cart = $this->container->get('msi_store.cart_provider')->getCart();
        $product = $this->container->get('msi_store.product_manager')->getOneBy(
            [
                'a.id' => $this->getRequest()->query->get('product'),
                'a.published' => true,
            ]
        );

        foreach ($cart->getItems() as $e) {
            if ($e->getProduct()->getId() === $product->getId()) {
                $item = $e;
            }
        }

        if (!empty($item)) {
            $item->setQuantity($item->getQuantity() + $this->getRequest()->request->get('quantity', 1));
        } else {
            $item = $this->get('msi_store.cart_item_manager')->create();

            $item->setQuantity($this->getRequest()->request->get('quantity', 1));

            $item->setProduct($product);
            $item->setCart($cart);
            $cart->getItems()->add($item);
        }

        $cart->setUpdatedAt(new \DateTime());

        $this->container->get('msi_store.cart_manager')->update($cart);

        return $this->redirect($this->generateUrl('msi_store_product_list'));
    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}
