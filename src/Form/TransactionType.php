<?php

namespace App\Form;

use App\Entity\Transactions;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descricao', TextType::class, [
                'label' => 'Descrição da movimentação'
            ])
            ->add('valor')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Entrada' => 0,
                    'Saída' => 1
                ],
                'placeholder' => 'Selecione um status',
                'label' => 'Status',
                'required' =>  true
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'descricao',
                'label' => 'Categoria'
            ])
            ->add('date', DateType::class, [
                'label' => 'Data',
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'yyyy-MM-dd',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transactions::class,
        ]);
    }
}