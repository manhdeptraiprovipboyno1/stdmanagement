<?php

namespace App\Form;

use App\Entity\ClassM;
use App\Entity\Subject;
use App\Entity\Lecturer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\File\File;


class LecturerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => "Lecturer",
                'required' => true,
            ])
            ->add('birthday', DateType::class,
            [
                'label' => "Birthday",
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('nationality', ChoiceType::class,
            [
                'choices' =>
                [
                    "Vietnam" => "Vietnam",
                    "Thailand" => "ThaiLand",
                    "England" => "England",
                    "US" => "US",
                ]
            ])
            ->add('avatar', FileType::class,
            [
                'label' => "Avatar",
                'data_class'=> null,
                'required' => is_null($builder->getData()->getAvatar()),
            ])
            ->add('ClassList', EntityType::class,
            [
                'label' => "Class",
                'class' => ClassM::class,
                'choice_label' => "name",  // hiển thị theo lecturer name để chọn
                'multiple' => true,  // chọn nhiều thì true, chọn 1 là false
                'expanded' => false, //true: checkbox, false: drop-down List
            ])
            ->add('SubjectList', EntityType::class,
            [
                'label' => "Subject",
                'class' => Subject::class,
                'choice_label' => "name",  // hiển thị theo lecturer name để chọn
                'multiple' => true,  // chọn nhiều thì true, chọn 1 là false
                'expanded' => false, //true: checkbox, false: drop-down List
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lecturer::class,
        ]);
    }
}
