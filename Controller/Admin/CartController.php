<?php

namespace Msi\StoreBundle\Controller\Admin;

use Msi\CmfBundle\Controller\CoreController;

class CartController extends CoreController
{
    public function showAction()
    {
        return $this->render('MsiStoreBundle:Cart/Admin:show.html.twig');
    }
}
