<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CheckoutController extends Controller
{
    public function addressAction()
    {
        if ($this->getCart()->isEmpty()) {
            throw new AccessDeniedException();
        }

        $builder = $this->get('form.factory')->createBuilder(new \Msi\StoreBundle\Form\Type\CheckoutAddressType());
        $form = $builder->getForm();

        foreach ($form->all() as $name => $type) {
            $getter = 'get'.ucfirst($name);
            if (null === $this->getCart()->$getter() && $this->getUser() && $this->getUser()->getDefaultAddress()) {
                $getter = 'get'.ucfirst(str_replace(['shipping', 'billing'], '', $name));
                $setter = 'set'.ucfirst($name);
                $this->getCart()->$setter($this->getUser()->getDefaultAddress()->$getter());
            }
        }

        $form->setData($this->getCart());

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $this->get('msi_store.cart_manager')->update($this->getCart());

                return $this->redirect($this->generateUrl('msi_store_checkout_summary'));
            }
        }

        return $this->render('MsiStoreBundle:Checkout:address.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function loadAddressesAction()
    {
        $addresses = $this->get('msi_store.address_manager')->getFindByQueryBuilder(
            [
                'a.user' => $this->getUser(),
            ]
        )->getQuery()->getArrayResult();

        return $this->render('MsiStoreBundle:Checkout:loadAddresses.html.twig', ['addresses' => $addresses]);
    }

    public function pickAddressAction()
    {
        $address = $this->get('msi_store.address_manager')->getFindByQueryBuilder(
            [
                'a.user' => $this->getUser(),
                'a.id' => $this->getRequest()->query->get('address'),
            ]
        )->getQuery()->getArrayResult()[0];

        return new JsonResponse($address);
    }

    public function summaryAction()
    {
        if ($this->getCart()->isEmpty() || !$this->getCart()->isAddressed()) {
            throw new AccessDeniedException();
        }

        return $this->render('MsiStoreBundle:Checkout:summary.html.twig');
    }

    public function processAction()
    {
        if ($this->getCart()->isEmpty() || !$this->getCart()->isAddressed()) {
            throw new AccessDeniedException();
        }

        $strat = $this->get('msi_store.addition_strategy');

        if (!$this->getCart()->getShippingAddress()) {
            return $this->redirect($this->generateUrl('msi_store_checkout_address'));
        }

        $this->getCart()
            ->setFrozenAt(new \DateTime())
            ->setIp($this->getRequest()->getClientIp())
            ->setStatus($this->get('msi_store.cart_status_manager')->getOneBy(['a.id' => 1]))
            ->setSubtotal($strat->cartSubtotal($this->getCart()))
            ->setPstTotal($strat->pstTotal($this->getCart()))
            ->setGstTotal($strat->gstTotal($this->getCart()))
            ->setTotal($strat->cartTotal($this->getCart()))
        ;

        foreach ($this->getCart()->getItems() as $item) {
            $product = $item->getProduct();
            $item
                ->setName($product->getTranslation()->getName())
                ->setPrice($product->getPrice())
                ->setTotal($strat->cartItemTotal($item))
            ;
        }

        $this->container->get('msi_store.cart_manager')->update($this->getCart());

        return $this->redirect($this->generateUrl('msi_store_checkout_thankyou'));
    }

    public function thankyouAction()
    {
        return $this->render('MsiStoreBundle:Checkout:thankyou.html.twig');
    }

    private function getCart()
    {
        return $this->get('msi_store.cart_provider')->getCart();
    }
}
