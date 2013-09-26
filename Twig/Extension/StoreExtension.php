<?php

namespace Msi\StoreBundle\Twig\Extension;

class StoreExtension extends \Twig_Extension
{
    private $environment;
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getName()
    {
        return 'msi_store';
    }

    public function getGlobals()
    {
        $globals = [];

        if (!$this->container->isScopeActive('request')) {
            return $globals;
        }

        if (!$this->container->get('request')->hasNamespace(['admin'])) {
            $globals['cart'] = $this->container->get('msi_store.cart_provider')->getCart();
            $globals['additionStrategy'] = $this->container->get('msi_store.addition_strategy');
        }

        return $globals;
    }
}
