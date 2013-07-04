<?php

namespace Msi\StoreBundle\Admin;

use Msi\CmfBundle\Admin\Admin;
use Msi\CmfBundle\Grid\GridBuilder;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\QueryBuilder;

class CartAdmin extends Admin
{
    public function buildGrid(GridBuilder $builder)
    {
        $builder
            ->add('id')
            ->add('frozenAt', 'date', [
                'format' => 'd/m/Y',
            ])
            ->add('shippingName')
            ->add('billingName')
            ->add('total')
            ->add('status')
            ->add('', 'action')
        ;
    }

    public function buildForm(FormBuilder $builder)
    {
        $builder
            ->add('status')
        ;
    }

    public function buildListQuery(QueryBuilder $qb)
    {
        $qb->andWhere($qb->expr()->isNotNull('a.status'));
    }
}
