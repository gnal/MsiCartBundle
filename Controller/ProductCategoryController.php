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
        $parameters['current_category'] = $this->get('msi_store.product_category_manager')->find(
            [
                'a.id' => $this->getRequest()->query->get('category'),
            ],
            [
                'a.parent' => 'parent',
            ],
            [],
            false
        );

        if ($parameters['current_category']) {
            if ($parameters['current_category']->getParent() && $parameters['current_category']->getParent()->getLvl() === 1) {
                $parameters['current_category'] = $parameters['current_category']->getParent();
            }
        }

        $qb = $this->get('msi_store.product_category_manager')->getMasterQueryBuilder(
            [
                'a.lvl' => 0,
            ],
            [
                'a.children' => 'children',
                'children.children' => 'children_children',

                'children.products' => 'children_products',
                'children_children.products' => 'children_children_products',
            ]
        );

        $parameters['category'] = $qb->getQuery()->getOneOrNullResult();

        return $this->render('MsiStoreBundle:ProductCategory:nav.html.twig', $parameters);
    }
}
