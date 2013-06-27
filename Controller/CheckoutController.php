<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CheckoutController extends Controller
{
    public function addressAction()
    {
        $cart = $this->container->get('msi_store.cart_provider')->getCart();

        $builder = $this->get('form.factory')->createBuilder(new \Msi\StoreBundle\Form\Type\CheckoutAddressType());
        $form = $builder->getForm();

        foreach ($form->all() as $name => $type) {
            $getter = 'get'.ucfirst($name);
            if (null === $cart->$getter() && $this->getUser() && $this->getUser()->getDefaultAddress()) {
                $getter = 'get'.ucfirst(str_replace(['shipping', 'billing'], '', $name));
                $setter = 'set'.ucfirst($name);
                $cart->$setter($this->getUser()->getDefaultAddress()->$getter());
            }
        }

        $form->setData($cart);

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $this->container->get('msi_store.cart_manager')->update($cart);

                return $this->redirect($this->generateUrl('msi_store_checkout_summary'));
            }
        }

        return $this->render('MsiStoreBundle:Checkout:address.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function summaryAction()
    {
        return $this->render('MsiStoreBundle:Checkout:summary.html.twig');
    }

    public function processAction()
    {

    }
}
