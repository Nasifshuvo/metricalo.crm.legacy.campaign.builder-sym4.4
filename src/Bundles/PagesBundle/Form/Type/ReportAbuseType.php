<?php

namespace App\Bundles\PagesBundle\Form\Type;

use App\Bundles\AffiliateBundle\Enum\ClickAbuseTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportAbuseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type', ChoiceType::class, [
                'choices' => ClickAbuseTypeEnum::flipKeysAndLabels(),
            ])
            ->add('email', EmailType::class)
            ->add('description');
    }

    public function setDefaultOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_domain' => 'pages',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id' => 'so29v219',
        ]);
    }

    public function getName(): string
    {
        return 'reportAbuse';
    }
}
