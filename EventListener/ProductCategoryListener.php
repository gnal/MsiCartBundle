<?php

namespace Msi\StoreBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductCategoryListener implements EventSubscriber
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

        if ($metadata->name !== 'Msi\StoreBundle\Entity\ProductCategory') {
            return;
        }

        if (!$metadata->hasAssociation('products')) {
            $metadata->mapOneToMany([
                'fieldName'    => 'products',
                'targetEntity' => $this->container->getParameter('msi_store.product.class'),
                'mappedBy' => 'category',
            ]);
        }
    }
}
