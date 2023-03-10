<?php

namespace App\Form;

use App\classe\Search;
use App\Entity\Technology;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('string',TextType::class,[
                'label' => false,
                'required'=>false,
                'attr'=> [
                    'placeholder' => 'Find your course',
                    'class'=> 'form-control me-1']
                
            ])

            ->add('technologies',EntityType::class,[
                'label' => false,
                'required'=>false,
                'class' => Technology::class,
                
               
                'attr' => ['class'=>'form-select js-choice border-0 d-block', 'placeholder' => 'Categories']
            ])

        

         
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection'=>false,
        ]);
    }

    public function getBlockPrefix(){
        return '';
    }
}
