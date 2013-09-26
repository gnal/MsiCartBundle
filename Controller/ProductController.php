<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function listAction()
    {
        $parameters['category'] = $this->get('msi_store.product_category_manager')->find(
            [
                'a.id' => $this->getRequest()->query->get('category'),
            ],
            [],
            [],
            $this->getRequest()->query->get('category') ? true : false
        );

        $qb = $this->get('msi_store.product_manager')->getFindByQueryBuilder(
            [
                'translations.published' => true,
                'translations.locale' => $this->getRequest()->getLocale(),
            ],
            [
                'a.translations' => 'translations',
                'a.category' => 'category',
            ],
            [
                'translations.name' => 'ASC',
            ]
        );

        if ($parameters['category']) {
            $qb->andWhere($qb->expr()->gte('category.lft', ':lft'))->setParameter('lft', $parameters['category']->getLft());
            $qb->andWhere($qb->expr()->lte('category.rgt', ':rgt'))->setParameter('rgt', $parameters['category']->getRgt());
            $qb->andWhere($qb->expr()->eq('category.root', ':root'))->setParameter('root', $parameters['category']->getRoot());
        }

        $parameters['products'] = $qb->getQuery()->execute();

        return $this->render('MsiStoreBundle:Product:list.html.twig', $parameters);
    }

    public function showAction()
    {
        $parameters['product'] = $this->get('msi_store.product_manager')->find(
            [
                'a.id' => $this->getRequest()->attributes->get('id'),
                'translations.published' => true,
            ],
            [
                'a.translations' => 'translations',
            ]
        );

        return $this->render('MsiStoreBundle:Product:show.html.twig', $parameters);
    }

    public function featuredAction()
    {
        $qb = $this->get('msi_store.product_manager')->getMasterQueryBuilder();

        $parameters['products'] = $qb->getQuery()->execute();

        return $this->render('MsiStoreBundle:Product:featured.html.twig', $parameters);
    }
}
