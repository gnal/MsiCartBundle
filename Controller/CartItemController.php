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

    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}
