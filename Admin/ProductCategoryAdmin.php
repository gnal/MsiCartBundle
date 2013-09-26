<?php

namespace Msi\StoreBundle\Admin;

use Msi\AdminBundle\Admin\Admin;
use Msi\AdminBundle\Grid\GridBuilder;
use Symfony\Component\Form\FormBuilder;

class ProductCategoryAdmin extends Admin
{
    public function configure()
    {
        $this->options = [
            'search_fields' => ['t.name'],
            'order_by' => [
                'a.root' => 'ASC',
                'a.lft' => 'ASC',
            ],
            'index_template' => 'MsiStoreBundle:ProductCategory/Admin:index.html.twig',
            'controller' => 'MsiStoreBundle:Admin/ProductCategory:',
        ];
    }

    public function buildGrid(GridBuilder $builder)
    {
        $builder
            ->add('published', 'boolean')
            ->add('name', 'tree')
            ->add('', 'action')
        ;
    }

    public function buildForm(FormBuilder $builder)
    {
        // $qb = $this->container->get('msi_store.product_category_manager')->getMasterQueryBuilder();

        // $qb->andWhere($qb->expr()->neq('a.id', $this->getObject()->getId()));

        // $parents = $qb->getQuery()->execute();

        $builder
            ->add('published')
            ->add('parent', 'entity', [
                'class' => 'MsiStoreBundle:ProductCategory',
                // 'choices' => $parents,
                'empty_value' => 'None',
                'required' => false,
            ])
        ;
    }

    public function buildTranslationForm(FormBuilder $builder)
    {
        $builder
            ->add('name')
            ->add('content')
        ;
    }
}
