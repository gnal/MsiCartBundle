<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CheckoutController extends Controller
{
    public function addressAction()
    {
        if ('POST' === $this->getRequest()->getMethod()) {
            return $this->redirect($this->generateUrl('msi_store_checkout_summary'));
        }

        return $this->render('MsiStoreBundle:Checkout:address.html.twig');
    }

    public function summaryAction()
    {
        return $this->render('MsiStoreBundle:Checkout:summary.html.twig');
    }

    public function processAction()
    {

    }
}
