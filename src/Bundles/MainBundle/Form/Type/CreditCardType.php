<?php
/**
 * Created by PhpStorm.
 * * User: Unknown
 * Date: 1/15/16
 * Time: 2:36 AM
 */

namespace App\Bundles\MainBundle\Form\Type;

use App\Bundles\MainBundle\Entity\CreditCard;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreditCardType extends AbstractType
{
    const TYPE_NAME = 'credit_card';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cardholder_name')
            ->add('raw_number')
            ->add('expiration_year', ChoiceType::class, [
                'choices' => $this->buildYearChoices()
            ])
            ->add('expiration_month', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    '01' => '01',
                    '02' => '02',
                    '03' => '03',
                    '04' => '04',
                    '05' => '05',
                    '06' => '06',
                    '07' => '07',
                    '08' => '08',
                    '09' => '09',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                ]
            ])
            ->add('cvc')
            ->add('extra_data', HiddenType::class, [
                'required' => false
            ])
        ;
    }

    public function buildYearChoices() {
        $yearsBefore = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        $yearsAfter = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") + 15));
        return array_combine(range($yearsBefore, $yearsAfter), range($yearsBefore, $yearsAfter));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CreditCard::class,
            'csrf_protection'   => false,
            'allow_extra_fields' => true
        ));
    }


    public function getName()
    {
        return self::TYPE_NAME;
    }
}