<?php

namespace Msi\StoreBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CartItemListener implements EventSubscriber
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

        if ($metadata->name !== 'Msi\StoreBundle\Entity\CartItem') {
            return;
        }

        if (!$metadata->hasAssociation('product')) {
            $metadata->mapManyToOne([
                'fieldName'    => 'product',
                'targetEntity' => $this->container->getParameter('msi_store.product.class'),
                'joinColumns' => [
                    [
                        'onDelete' => 'SET NULL',
                    ],
                ],
            ]);
        }
    }
}
