<?php

namespace WCS\CoavBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ReviewType extends AbstractType
{
    /**
     * {@inheritdoc} including all fields from Review Entity
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class,
                ['attr' =>
                ['maxlength' => 250, 'label' => 'Description']])
            ->add('publicationDate', DateType::class,
                ['data' => new \DateTime('now')])
            ->add('note', IntegerType::class, ['attr' =>
                ['min' => 0, 'max' => 5, 'label' => 'Note']])
            ->add('agreeTerms', CheckboxType::class, ['mapped' => false])
            ->add('userRated', EntityType::class, ['class' => 'WCS\CoavBundle\Entity\User',
                'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')->orderBy('u.lastName', 'ASC');
                },
                'choice_label' => 'phoneNumber'])
            ->add('reviewAuthor');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WCS\CoavBundle\Entity\Review'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'wcs_coavbundle_review';
    }


}
