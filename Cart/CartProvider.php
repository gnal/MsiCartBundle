<?php

namespace Msi\StoreBundle\Cart;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class CartProvider
{
    private $container;
    private $cart;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getCart()
    {
        if (!$this->cart) {
            $cartManager = $this->container->get('msi_store.cart_manager');

            if ($this->getUser()) {
                $this->cart = $cartManager->findCartByUser($this->getUser());
            } else {
                $this->cart = $cartManager->findCartByCookie($this->container->get('request')->cookies->get('msci'));
            }

            if (!$this->cart) {
                $this->cart = $cartManager->create();
                if ($this->getUser()) {
                    $this->cart->setUser($this->getUser());
                    $cartManager->update($this->cart);
                } else {
                    $cartManager->update($this->cart);
                    $this->container->get('event_dispatcher')->addListener(KernelEvents::RESPONSE, [$this->container->get('msi_store.cookie_listener'), 'onKernelResponse']);
                }
            }
        }

        return $this->cart;
    }

    private function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }
}
