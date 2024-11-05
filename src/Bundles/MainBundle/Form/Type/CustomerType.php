<?php

namespace App\Bundles\MainBundle\Form\Type;

use App\Bundles\Common\Symfony\Utils\Common;
use App\Bundles\MainBundle\Entity\Customer;
use Common\Utils\LocationUtils;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

/**
 * @DI\FormType
 */
class CustomerType extends AbstractType
{
    const TYPE_NAME = 'customer';
    const VALIDATION_GROUP = 'default_form';

    use ContainerAwareTrait;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* \Locale::setDefault('fr_FR'); Determines country locale, not possible to pass */
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('email')
            ->add('phone', null, [
                'required' => false
            ])
            ->add('address', null, [
                'required' => false
            ])
            ->add('postcode', null, [
                'required' => false
            ])
            ->add('state', ChoiceType::class, $this->getStates($options['countryCode']))
            ->add('city', null, [
                'required' => false
            ])
            ->add('accepting_newsletter', CheckboxType::class, [
                'required' => false
            ])
        ;

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($options) {
                $data = $event->getData();

                $data = $this->removeAccents($data, 'first_name');
                $data = $this->removeNonAlpha($data, 'first_name');
                $data = $this->removeMiddleName($data, 'first_name', 'first');
                $data = $this->consistentInput($data, 'first_name');

                $data = $this->removeAccents($data, 'last_name');
                $data = $this->removeNonAlpha($data, 'last_name');
                $data = $this->removeMiddleName($data, 'last_name', 'last');
                $data = $this->consistentInput($data, 'last_name');

                $data = $this->consistentInput($data, 'email');

                $data = $this->removeAccents($data, 'city');
                $data = $this->removeNonAlphaNummeric($data, 'city');
                $data = $this->consistentInput($data, 'city');

                $data = $this->removeAccents($data, 'address');
                $data = $this->removeNonAlphaNummeric($data, 'address');
                $data = $this->enforceCharacterLimit($data, 'address', 45);
                $data = $this->consistentInput($data, 'address');

                $data = $this->removeNonAlphaNummeric($data, 'postcode');
                $data = $this->upperCase($data, 'postcode');

                $event->setData($data);
            }
        );
    }

    private function getStates($countryCode) {
        $states = [
            'AF' => [
                'Badakhshan' => 'BD',
                'Badghis' => 'BG',
                'Baghlan' => 'BN',
                'Balkh' => 'BK',
                'Bamian' => 'BM',
                'Daykondi' => 'DK',
                'Farah' => 'FR',
                'Faryab' => 'FY',
                'Ghazni' => 'GZ',
                'Ghowr' => 'GW',
                'Helmand' => 'HM',
                'Herat' => 'HR',
                'Jowzjan' => 'JJ',
                'Kabul' => 'KB',
                'Kandahar' => 'KD',
                'Kapisa' => 'KP',
                'Khost' => 'KH',
                'Konar' => 'KR',
                'Kondoz' => 'KZ',
                'Laghman' => 'LG',
                'Lowgar' => 'LG',
                'Nangarhar' => 'NH',
                'Nimruz' => 'NZ',
                'Nurestan' => 'NR',
                'Oruzgan' => 'OZ',
                'Paktia' => 'PT',
                'Paktika' => 'PK',
                'Panjshir' => 'PJ',
                'Parvan' => 'PV',
                'Samangan' => 'SM',
                'Sar-e Pol' => 'SP',
                'Takhar' => 'TK',
                'Vardak' => 'VD',
                'Zabol' => 'ZB',
            ],
            'US' => [
                'Alabama' => 'AL',
                'Alaska' => 'AK',
                'Arizona' => 'AZ',
                'Arkansas' => 'AR',
                'California' => 'CA',
                'Colorado' => 'CO',
                'Connecticut' => 'CT',
                'Delaware' => 'DE',
                'District of Columbia' => 'DC',
                'Florida' => 'FL',
                'Georgia' => 'GA',
                'Hawaii' => 'HI',
                'Idaho' => 'ID',
                'Illinois' => 'IL',
                'Indiana' => 'IN',
                'Iowa' => 'IA',
                'Kansas' => 'KS',
                'Kentucky' => 'KY',
                'Louisiana' => 'LA',
                'Maine' => 'ME',
                'Maryland' => 'MD',
                'Massachusetts' => 'MA',
                'Michigan' => 'MI',
                'Minnesota' => 'MN',
                'Mississippi' => 'MS',
                'Missouri' => 'MO',
                'Montana' => 'MT',
                'Nebraska' => 'NE',
                'Nevada' => 'NV',
                'New Hampshire' => 'NH',
                'New Jersey' => 'NJ',
                'New Mexico' => 'NM',
                'New York' => 'NY',
                'North Carolina' => 'NC',
                'North Dakota' => 'ND',
                'Ohio' => 'OH',
                'Oklahoma' => 'OK',
                'Oregon' => 'OR',
                'Pennsylvania' => 'PA',
                'Rhode Island' => 'RI',
                'South Carolina' => 'SC',
                'South Dakota' => 'SD',
                'Tennessee' => 'TN',
                'Texas' => 'TX',
                'Utah' => 'UT',
                'Vermont' => 'VT',
                'Virginia' => 'VA',
                'Washington' => 'WA',
                'West Virginia' => 'WV',
                'Wisconsin' => 'WI',
                'Wyoming' => 'WY',
            ],
            'AU' => [
                'Australian Capital Territory' => 'ACT',
                'New South Wales' => 'NSW',
                'Northern Territory' => 'NT',
                'Queensland' => 'QLD',
                'South Australia' => 'SA',
                'Tasmania' => 'TAS',
                'Victoria' => 'VIC',
                'Western Australia' => 'WA',
            ],
            'AT' => [
                'Burgenland' => 'BU',
                'Kaernten' => 'KA',
                'Niederoesterreich' => 'NO',
                'Oberoesterreich' => 'OO',
                'Salzburg' => 'SA',
                'Steiermark' => 'ST',
                'Tirol' => 'TI',
                'Vorarlberg' => 'VO',
                'Wien' => 'WI',
            ],
            'BR' => [
                'Acre' => 'AC',
                'Alagoas' => 'AL',
                'Amapa' => 'AP',
                'Amazonas' => 'AM',
                'Bahia' => 'BA',
                'Ceara' => 'CE',
                'Distrito Federal' => 'DF',
                'Espirito Santo' => 'ES',
                'Goias' => 'GO',
                'Maranhao' => 'MA',
                'Mato Grosso' => 'MT',
                'Mato Grosso do Sul' => 'MS',
                'Minas Gerais' => 'MG',
                'Para' => 'PA',
                'Paraiba' => 'PB',
                'Parana' => 'PR',
                'Pernambuco' => 'PE',
                'Piaui' => 'PI',
                'Rio de Janeiro' => 'RJ',
                'Rio Grande do Norte' => 'RN',
                'Rio Grande do Sul' => 'RS',
                'Rondonia' => 'RO',
                'Roraima' => 'RR',
                'Santa Catarina' => 'SC',
                'Sao Paulo' => 'SP',
                'Sergipe' => 'SE',
                'Tocantins' => 'TO',
            ],
            'DE' => [
                'Baden-Wuerttemberg' => 'BW',
                'Bayern' => 'BY',
                'Berlin' => 'BE',
                'Brandenburg' => 'BB',
                'Bremen' => 'HB',
                'Hamburg' => 'HH',
                'Hessen' => 'HE',
                'Mecklenburg-Vorpommern' => 'MV',
                'Niedersachsen' => 'NI',
                'Nordrhein-Westfalen' => 'NW',
                'Rheinland-Pfalz' => 'RP',
                'Saarland' => 'SL',
                'Sachsen' => 'SN',
                'Sachsen-Anhalt' => 'ST',
                'Schleswig-Holstein' => 'SH',
                'Thueringen' => 'TH',
            ],
            'IN' => [
                'Andaman and Nicobar Islands' => 'AN',
                'Andhra Pradesh' => 'AP',
                'Arunachal Pradesh' => 'AR',
                'Assam' => 'AS',
                'Bihar' => 'BR',
                'Chandigarh' => 'CH',
                'Chhattisgarh' => 'CT',
                'Dadra and Nagar Haveli' => 'DN',
                'Daman and Diu' => 'DD',
                'Delhi' => 'DL',
                'Goa' => 'GA',
                'Gujarat' => 'GJ',
                'Haryana' => 'HR',
                'Himachal Pradesh' => 'HP',
                'Jammu and Kashmir' => 'JK',
                'Jharkhand' => 'JH',
                'Karnataka' => 'KA',
                'Kerala' => 'KL',
                'Ladakh' => 'LA',
                'Lakshadweep' => 'LD',
                'Madhya Pradesh' => 'MP',
                'Maharashtra' => 'MH',
                'Manipur' => 'MN',
                'Meghalaya' => 'ML',
                'Mizoram' => 'MZ',
                'Nagaland' => 'NL',
                'Orissa' => 'OR',
                'Pondicherry' => 'PY',
                'Punjab' => 'PB',
                'Rajasthan' => 'RJ',
                'Sikkim' => 'SK',
                'Tamil Nadu' => 'TN',
                'Telangana' => 'TG',
                'Tripura' => 'TR',
                'Uttaranchal' => 'UT',
                'Uttar Pradesh' => 'UP',
                'West Bengal' => 'WB',
            ],
            'NG' => [
                'Abia' => 'AB',
                'Abuja Federal Capital' => 'FC',
                'Adamawa' => 'AD',
                'Akwa Ibom' => 'AK',
                'Anambra' => 'AN',
                'Bauchi' => 'BA',
                'Bayelsa' => 'BY',
                'Benue' => 'BE',
                'Borno' => 'BO',
                'Cross River' => 'CR',
                'Delta' => 'DE',
                'Ebonyi' => 'EB',
                'Edo' => 'ED',
                'Ekiti' => 'EK',
                'Enugu' => 'EN',
                'Gombe' => 'GO',
                'Imo' => 'IM',
                'Jigawa' => 'JI',
                'Kaduna' => 'KD',
                'Kano' => 'KN',
                'Katsina' => 'KT',
                'Kebbi' => 'KE',
                'Kogi' => 'KO',
                'Kwara' => 'KW',
                'Lagos' => 'LA',
                'Nassarawa' => 'NA',
                'Niger' => 'NI',
                'Ogun' => 'OG',
                'Ondo' => 'ON',
                'Osun' => 'OS',
                'Oyo' => 'OY',
                'Plateau' => 'PL',
                'Rivers' => 'RI',
                'Sokoto' => 'SO',
                'Taraba' => 'TA',
                'Yobe' => 'YO',
                'Zamfara' => 'ZA',
            ],
            'NZ' => [
                'Auckland' => 'AKL',
                'Bay of Plenty' => 'BOP',
                'Canterbury' => 'CAN',
                'Chatham Islands' => 'CIT',
                'Gisborne' => 'GIS',
                "Hawke's Bay" => 'HKB',
                'Manawatu-Wanganui' => 'MWT',
                'Marlborough' => 'MBH',
                'Nelson' => 'NSN',
                'Northland' => 'NTL',
                'Otago' => 'OTA',
                'Southland' => 'STL',
                'Taranaki' => 'TKI',
                'Tasman' => 'TAS',
                'Waikato' => 'WKO',
                'Wellington' => 'WGN',
                'West Coast' => 'WTC',
            ],
            'MM' => [
                'Ayeyarwady' => 'AY',
                'Bago' => 'BG',
                'Magway' => 'MG',
                'Mandalay' => 'MD',
                'Sagaing' => 'SG',
                'Tanintharyi' => 'TN',
                'Yangon' => 'YG',
                'Chin State' => 'CN',
                'Kachin State' => 'KC',
                'Kayin State' => 'KI',
                'Kayah State' => 'KH',
                'Mon State' => 'MN',
                'Rakhine State' => 'RK',
                'Shan State' => 'SN',
            ],
            'FM' => [
                'Chuuk' => 'CHK',
                'Kosrae' => 'KSA',
                'Pohnpei' => 'PNI',
                'Yap' => 'YAP',
            ],
            'PW' => [
                'Aimeliik' => 'AIM',
                'Airai' => 'AIR',
                'Angaur' => 'ANG',
                'Hatohobei' => 'HAT',
                'Koror' => 'KOR',
                'Melekeok' => 'MEL',
                'Ngaraard' => 'NGR',
                'Ngarchelong' => 'NGE',
                'Ngardmau' => 'NGM',
                'Ngatpang' => 'NGT',
                'Ngchesar' => 'NGC',
                'Ngeremlengui' => 'NRM',
                'Ngiwal' => 'NGI',
                'Peleliu' => 'PEL',
            ],
        ];

        if (array_key_exists($countryCode, $states)) {
            return
            [
                'required' => false,
                'choices' => array_flip($states[$countryCode]),
                'data' => reset($states[$countryCode])
            ];
        }

        return [];
    }

    private function consistentInput($data, $key) {
        if (!array_key_exists($key, $data))
            return $data;

        $data[$key] = ucfirst(strtolower(trim($data[$key])));
        return $data;
    }

    private function removeNonAlpha($data, $key) {

        if (!array_key_exists($key, $data))
            return $data;

        $data[$key] = preg_replace("/[^A-Za-z ]/", '', $data[$key]);

        return $data;
    }

    private function removeNonAlphaNummeric($data, $key) {

        if (!array_key_exists($key, $data))
            return $data;

        $data[$key] = preg_replace("/[^A-Za-z0-9 ]/", '', $data[$key]);

        return $data;
    }

    private function upperCase($data, $key) {

        if (!array_key_exists($key, $data))
            return $data;

        $data[$key] = strtoupper($data[$key]);

        return $data;
    }


    private function removeAccents($data, $key) {

        if (!array_key_exists($key, $data))
            return $data;

        $data[$key] = Common::removeAccents($data[$key]);

        return $data;
    }

    private function removeMiddleName($data, $key, $preserve = 'first') {
        if (!array_key_exists($key, $data))
            return $data;

        $data[$key] = trim($data[$key]);

        if (strpos($data[$key], ' ') !== false) {
            $parts = explode(' ', $data[$key]);

            if ($preserve == 'first') {
                $data[$key] = $parts[0];
            } else {
                $data[$key] = end($parts);
            }
        }

        return $data;
    }

    private function enforceCharacterLimit($data, $key, $n) {

        $data[$key] = Common::characterLimiter($data[$key], $n);

        // Force if its still to long
        if (strlen($data[$key]) > $n)
        {
            $data[$key] = substr($data[$key],0, $n);
        }

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