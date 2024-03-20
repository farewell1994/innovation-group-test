<?php

namespace App\Form\Type\Bonus;

use App\Entity\Bonus\Bonus;
use App\Enum\Bonus\BonusTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class BonusFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [new NotBlank()],
                'documentation' => [
                    'description' => 'Name of bonus',
                ],
            ])
            ->add('type', EnumType::class, [
                'class' => BonusTypeEnum::class,
                'constraints' => [new NotBlank()],
                'documentation' => [
                    'description' => 'Type of bonus',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bonus::class,
            'csrf_protection' => false,
        ]);
    }
}
