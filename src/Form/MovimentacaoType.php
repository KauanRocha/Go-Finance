<?php

namespace App\Form;

use App\Entity\Movimentacao;
use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MovimentacaoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descricaomovimentacao', TextType::class, [
                'label' => 'Descrição da movimentação'
            ])
            ->add('quantia')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Entrada' => 0,
                    'Saída' => 1
                ],
                'placeholder' => 'Selecione um status',
                'label' => 'Status',
                'required' =>  true
            ])
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'descricaocategoria'
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movimentacao::class,
        ]);
    }
}
