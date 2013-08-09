<?php

namespace Msi\StoreBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductListener implements EventSubscriber
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(EventArgs $e)
    {
        $metadata = $e->getClassMetadata();

        if ($metadata->name !== $this->container->getParameter('msi_store.product.class')) {
            return;
        }

        if (!$metadata->hasAssociation('category')) {
            $metadata->mapManyToOne([
                'fieldName'    => 'category',
                'targetEntity' => 'Msi\StoreBundle\Entity\ProductCategory',
                'inversedBy' => 'products',
                'joinColumns' => [
                    [
                        'onDelete' => 'SET NULL',
                    ],
                ],
            ]);
        }

        if (!$metadata->hasAssociation('images')) {
            $metadata->mapOneToMany([
                'fieldName'    => 'images',
                'targetEntity' => 'Msi\StoreBundle\Entity\ProductImage',
                'mappedBy' => 'product',
                'orderBy' => ['position' => 'ASC'],
            ]);
        }
    }
}
