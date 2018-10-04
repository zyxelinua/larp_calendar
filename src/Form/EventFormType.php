<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\EventType;
use App\Entity\EventCategory;
use App\Entity\Country;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add(
                'type',
                EntityType::class,
                [
                    'class' => EventType::class,
                    'choice_label' => 'name'
                ]
            )
            ->add('description', TextareaType::class)
            ->add('startDate', DateType::class)
            ->add('endDate', DateType::class)
            ->add('location', TextType::class)
            ->add(
                'country',
                EntityType::class,
                [
                    'class' => Country::class,
                    'choice_label' => 'name'
                ]
            )
            ->add('priceMin', IntegerType::class)
            ->add('priceMax', IntegerType::class)
            ->add('priceCurrency', TextType::class)
            ->add(
                'categories',
                EntityType::class,
                [
                    'class' => EventCategory::class,
                    'choice_label' => 'name',
                    'multiple' => true
                ]
            )
            ->add('organizers', TextType::class)
            ->add('organizerContact', TextType::class)
            ->add('contactSite', TextType::class)
            ->add('contactFB', TextType::class)
            ->add('contactOther', TextType::class)
            ->add('save', SubmitType::class)
        ;
    }
}
