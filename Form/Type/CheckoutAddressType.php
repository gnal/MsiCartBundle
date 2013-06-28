<?php

namespace Msi\StoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;

class CheckoutAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shippingFirstName', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* First name',
                ],
            ])
            ->add('shippingLastName', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* Last name',
                ],
            ])
            ->add('shippingEmail', 'email', [
                'constraints' => [new NotBlank(), new Email()],
                'attr' => [
                    'placeholder' => '* Email',
                ],
            ])
            ->add('shippingPhone', 'text', [
                'attr' => [
                    'placeholder' => 'Phone',
                ],
            ])
            ->add('shippingPhoneExt', 'text', [
                'constraints' => [new Regex(['pattern' => '@^\d+$@'])],
                'attr' => [
                    'style' => 'width: 50%;',
                    'placeholder' => 'Ext.',
                ],
            ])
            ->add('shippingAddress', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* Address',
                ],
            ])
            ->add('shippingCity', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* City',
                ],
            ])
            ->add('shippingProvince', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* Province',
                ],
            ])
            ->add('shippingCountry', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* Country',
                ],
            ])
            ->add('shippingZip', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* Postal code',
                ],
            ])
            ->add('billingFirstName', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* First name',
                ],
            ])
            ->add('billingLastName', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* Last name',
                ],
            ])
            ->add('billingEmail', 'email', [
                'constraints' => [new NotBlank(), new Email()],
                'attr' => [
                    'placeholder' => '* Email',
                ],
            ])
            ->add('billingPhone', 'text', [
                'attr' => [
                    'placeholder' => 'Phone',
                ],
            ])
            ->add('billingPhoneExt', 'text', [
                'constraints' => [new Regex(['pattern' => '@^\d+$@'])],
                'attr' => [
                    'style' => 'width: 50%;',
                    'placeholder' => 'Ext.',
                ],
            ])
            ->add('billingAddress', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* Address',
                ],
            ])
            ->add('billingCity', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* City',
                ],
            ])
            ->add('billingProvince', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* Province',
                ],
            ])
            ->add('billingCountry', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* Country',
                ],
            ])
            ->add('billingZip', 'text', [
                'constraints' => [new NotBlank()],
                'attr' => [
                    'placeholder' => '* Postal code',
                ],
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Msi\StoreBundle\Entity\Cart',
        ]);
    }

    public function getName()
    {
        return 'msi_store_checkout_address';
    }
}
