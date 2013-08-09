<?php

namespace Msi\StoreBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LoginListener
{
    protected $user;
    protected $cartManager;

    public function __construct($cartManager)
    {
        $this->cartManager = $cartManager;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->user = $event->getAuthenticationToken()->getUser();
        $event->getDispatcher()->addListener(KernelEvents::RESPONSE, [$this, 'onKernelResponse']);
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->cookies->has('msci')) {
            $cart = $this->cartManager->findCartByCookie($request->cookies->get('msci'));
            if ($cart) {
                // if the user already had a cart but made a new one while not logged, we delete his old one
                $old = $this->cartManager->findCartByUser($this->user);
                if ($old) {
                    $this->cartManager->delete($old);
                }
                $cart->setUser($this->user);
                $this->cartManager->update($cart);
            }
            $event->getResponse()->headers->clearCookie('msci');
        }
        // $this->cartManager->collectGarbage();
    }
}
