<?php

namespace MyApp\JobOwnerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('projectname')
            ->add('activityarea')
            ->add('projectdescription')
            ->add('startdate')
            ->add('enddate')
            ->add('price')
            ->add('payment', ChoiceType::class, array(
                'choices'  => array(
                    'Virement' => 'Virement',
                    'titre interbancaire' => 'titre interbancaire',
                )))
            ->add('experiencelevel', ChoiceType::class, array(
                'choices'  => array(
                    'Senior' => 'Senior',
                    'Junior' => 'junior',
                )))
            ->add('requiredskills');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\JobOwnerBundle\Entity\Project'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'myapp_jobownerbundle_project';
    }


}
