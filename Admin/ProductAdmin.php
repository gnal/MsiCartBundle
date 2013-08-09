<?php

namespace Msi\StoreBundle\Admin;

use Msi\AdminBundle\Admin\Admin;
use Msi\AdminBundle\Grid\GridBuilder;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\QueryBuilder;

class ProductAdmin extends Admin
{
    public function configure()
    {
        $this->options = [
            'search_fields' => ['t.name'],
            'order_by' => [
                't.name' => 'ASC',
            ],
        ];
    }

    public function buildGrid(GridBuilder $builder)
    {
        $builder
            ->add('published', 'boolean')
            ->add('image', 'image')
            ->add('name')
            ->add('category')
            ->add('price')
            ->add('discount', 'text', [
                'truncate' => false,
            ])
            ->add('', 'action')
        ;
    }

    public function buildForm(FormBuilder $builder)
    {
        $builder
            ->add('published')
            ->add('category')
            ->add('price', 'money', [
                'currency' => false,
            ])
            ->add('taxable')
            ->add('discountedPrice', 'money', [
                'currency' => false,
            ])
            ->add('discountedFrom', 'date', [
                'input' => 'datetime',
                'format' => 'dd-MM-yyyy',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datepicker',
                ],
            ])
            ->add('discountedTo', 'date', [
                'input' => 'datetime',
                'format' => 'dd-MM-yyyy',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datepicker',
                ],
            ])
            ->add('imageFile', 'file')
        ;
    }

    public function buildTranslationForm(FormBuilder $builder)
    {
        $builder
            ->add('name')
        ;
    }

    public function buildListQuery(QueryBuilder $qb)
    {
        $qb->leftJoin('a.category', 'c');
        $qb->addSelect('c');
        $qb->leftJoin('c.translations', 'ct');
        $qb->addSelect('ct');
    }
}
