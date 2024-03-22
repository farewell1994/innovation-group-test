<?php

declare(strict_types=1);

namespace App\Form\Type\Client;

use App\Entity\Client\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [new NotBlank(), new Email()],
                'documentation' => [
                    'description' => 'Client email',
                ],
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [new NotBlank(), new LessThan('now')],
                'documentation' => [
                    'description' => 'Client birthday (Y-m-d)',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'csrf_protection' => false,
        ]);
    }
}
