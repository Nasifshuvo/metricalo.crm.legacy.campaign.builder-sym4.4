<?php

namespace App\Bundles\MainBundle\Form\Type;

use App\Bundles\MainBundle\Entity\Customer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @DI\FormType
 */
class EmailPasswordCustomerType extends AbstractType
{
    const TYPE_NAME = 'email_password_customer';
    const VALIDATION_GROUP = 'email_password_form';

    use ContainerAwareTrait;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 6]),
                ],
            ])
            ->add('accepting_newsletter', CheckboxType::class, [
                'required' => false
            ]);

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($options) {
                $data = $event->getData();

                $data = $this->consistentInput($data, 'email');

                $event->setData($data);
            }
        );
    }

    private function consistentInput($data, $key)
    {
        if (!array_key_exists($key, $data))
            return $data;

        $data[$key] = ucfirst(strtolower(trim($data[$key])));
        return $data;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'translation_domain' => 'form_customer',
                'data_class' => Customer::class,
                'csrf_protection' => true,
                'allow_extra_fields' => true,
            ]
        );
        $resolver->setRequired(array(
            'countryCode'
        ));
    }

    public function getName()
    {
        return self::TYPE_NAME;
    }
}
