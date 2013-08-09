<?php

namespace Msi\StoreBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AddressListener implements EventSubscriber
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

        if ($metadata->name !== 'Msi\StoreBundle\Entity\Address') {
            return;
        }

        if (!$metadata->hasAssociation('user')) {
            $metadata->mapManyToOne([
                'fieldName'    => 'user',
                'targetEntity' => $this->container->getParameter('fos_user.model.user.class'),
                'inversedBy' => 'addresses',
                'joinColumns' => [
                    [
                        'onDelete' => 'CASCADE',
                    ],
                ],
            ]);
        }
    }
}
