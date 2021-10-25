<?php

namespace App\Form;

use App\Entity\Subject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Entity\Lecturer;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => "I am handsome lecturer",
                'required' => true,
            ])
            ->add('abbre', IntegerType::class,
            [
                'label' => "Abbre",
                'required' => true,
            ])
            ->add('lecturer', EntityType::class,
            [
                'label' => "Lecturer",
                'class' => Lecturer::class,
                'choice_label' => "name",  // hiển thị theo lecturer name đẻ chọn
                'multiple' => false,  // chọn nhiều thì true, chọn 1 là false
                'expanded' => false,       //true: checkbox, false: drop-down List
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subject::class,
        ]);
    }
}
