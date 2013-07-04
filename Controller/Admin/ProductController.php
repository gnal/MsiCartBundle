<?php

namespace Msi\StoreBundle\Controller\Admin;

use Msi\CmfBundle\Controller\CoreController;

class ProductController extends CoreController
{
    public function showAction()
    {
        return $this->render('MsiStoreBundle:Product/Admin:show.html.twig');
    }
}
