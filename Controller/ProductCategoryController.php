<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductCategoryController extends Controller
{
    public function showAction()
    {
        $parameters['category'] = $this->get('msi_store.product_category_manager')->find(
            [
                'a.id' => $this->getRequest()->attributes->get('id'),
            ]
        );

        return $this->render('MsiStoreBundle:ProductCategory:show.html.twig', $parameters);
    }

    public function navAction()
    {
        $parameters['category'] = $this->get('msi_store.product_category_manager')->find(
            [
                'a.lvl' => 0,
            ]
        );

        return $this->render('MsiStoreBundle:ProductCategory:nav.html.twig', $parameters);
    }
}
