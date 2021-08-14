<?php
// src/Form/Type/ContactType.php
namespace App\Form\Type;

use App\Entity\Contact;
use App\Entity\Department;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'required' => true,
            ])
            ->add('firstName', TextType::class, [
                'required' => true,
            ])
            ->add('mail', TextType::class, [
                'required' => true,
            ])
            ->add('message', TextType::class, [
                'required' => false,
            ])
            ->add('department', ChoiceType::class, [
                'required' => true,
                'choices' => $options['departments'],
                'choice_label' => function(?Department $department) {
                    return $department ? $department->getName() : '';
                },
                'mapped' => false,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'departments' => [],
        ]);
    }
}