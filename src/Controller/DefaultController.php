<?php

namespace App\Controller;

use App\Bundles\AffiliateBundle\Entity\ClickAbuseCase;
use App\Bundles\MainBundle\Entity\Campaign;
use App\Bundles\MainBundle\Entity\CampaignDesign;
use App\Bundles\MainBundle\Entity\CreditCard;
use App\Bundles\MainBundle\Entity\Customer;
use App\Bundles\MainBundle\Entity\Lead;
use App\Bundles\MainBundle\Entity\MerchantAccount;
use App\Bundles\MainBundle\Entity\Order;
use App\Bundles\MainBundle\Entity\Product;
use App\Bundles\MainBundle\Entity\Service;
use App\Bundles\MainBundle\Entity\SkillGameItem;
use App\Bundles\MainBundle\Entity\Subscription;
use App\Bundles\MainBundle\Entity\WebsiteUser;
use App\Bundles\MainBundle\Enum\OrderStatusEnum;
use App\Bundles\MainBundle\Form\Type\CreditCardType;
use App\Bundles\MainBundle\Form\Type\CustomerType;
use App\Bundles\UpgradeBundle\Entity\PageTemplate\CheckoutPage;
use App\Bundles\UpgradeBundle\Entity\PageTemplate\EmailPage;
use App\Bundles\UpgradeBundle\Entity\PageTemplate\LandingPage;
use App\Bundles\UpgradeBundle\Entity\PageTemplate\PleaseWaitPage;
use App\Bundles\UpgradeBundle\Entity\PageTemplate\ReportAbusePage;
use App\Bundles\UpgradeBundle\Entity\PageTemplate\ThankYouPage;
use App\Bundles\UpgradeBundle\Manager\Template\DemoPageManager;
use App\Bundles\UpgradeBundle\Manager\Template\ImageManager;
use App\Bundles\UpgradeBundle\Manager\Template\TemplateManager;
use App\Bundles\UpgradeBundle\Model\PageTemplate\PageText;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as FW;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    protected $landingTemplate = 'default_signup_v1_2024';

    protected $checkoutTemplate = 'reviews_green_2022';

    protected $thankYouTemplate = 'green_thank_you_2022';

    protected $pleaseWaitTemplate = 'green_please_wait_2022';

    protected $emailTemplate = 'default_welcome_email';

    protected $reportAbuseTemplate = 'default_2024';

    /** other option EmailPasswordCustomerType */
    protected $formType = CustomerType::class;

    /* Options
        CustomerType::class,
        EmailPasswordCustomerType::class
    */

    protected TemplateManager $templateManager;

    /**
     * @var ImageManager
     */
    public ImageManager $imageManager;

    /**
     * @var DemoPageManager
     */
    protected DemoPageManager $demoManager;

    public function __construct(
        ContainerInterface $container
    )
    {
        $this->imageManager = $container->get('app.manager.template_image_manager');
        $this->demoManager = $container->get('app.manager.demo_page_manager');
        $this->templateManager = $container->get('app.manager.template_manager');
    }

    /**
     * @FW\Route("/", name="app.front.navigation")
     */
    public function indexAction(Request $request)
    {
        $routes = [
            'landing' => $this->generateUrl('app.front.landing'),
            'checkout' => $this->generateUrl('app.front.order.new'),
            'please_wait' => $this->generateUrl('app.front.order.awaiting.confirmation'),
            'thank_you' => $this->generateUrl('app.front.order.thankyou'),
            'email' => $this->generateUrl('app.front.email'),
            'report_abuse' => $this->generateUrl('report_abuse'),

            'placeholders' => $this->generateUrl('app.front.placeholders')
        ];

        return $this->render('navigation.html.twig', [
            'routes' => $routes
        ]);
    }

    /**
     * @FW\Route("/landing", name="app.front.landing")
     */
    public function landingAction(Request $request)
    {
        $page = $this->demoManager->createPage(new LandingPage(), $this->landingTemplate);
        $tm = $this->templateManager;
        $tm->generateConfig($page);

        $campaign = new Campaign();
        $campaign->slug = 'demo';
        $campaign->skillGameItem = 'Demo Item';
        $campaign->vertical = 'some Vertical';

        // toggle direct signup vs vertical
        //$campaign->vertical = null;
        //$campaign->setContest(false);

        $text = $page->getText($request->getLocale());
        $text->addTemplateVar('lead', new Lead())
            ->addTemplateVar('product', new Product())
            ->addTemplateVar('service', new Service())
            ->addTemplateVar('merchantAccount', new MerchantAccount())
            ->addTemplateVar('campaign', $campaign)
            ->addTemplateVar('skill_game_item', new SkillGameItem())
            ->addTemplateVar('contest_expiration_date', '2022-12-12');

        $imageManager = $this->imageManager;

        return $this->render(
            $tm->getPageTemplatePath($page),
            [
                'page'          => $page,
                'pageText'      => $text->onloadtext($tm),
                'pageTheme'     => $page->getTheme()->onloadImages($imageManager),

                'customerForm'  => $this->createCustomerForm()->createView(),
                'service'       => new Service(),
                'campaign'      => $campaign,
                'product'       => new Product(),
                'lead'          => new Lead(),

                'generalTermsAndConditions' => 'Demo service terms and conditions',
                'skillGameTerms'            => 'Demo skill game terms and conditions',
                'privacyPolicyTerms'        => 'Demo Privacy Policy',
                'skill_game_expiration_date'  => '2022-12-12',
            ]
        );
    }

    /**
     * @FW\Route("/order", name="app.front.order.new")
     */
    public function newAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            dump($request->request->all());
            die();
        }

        $page = $this->demoManager->createPage(new CheckoutPage(), $this->checkoutTemplate);
        $tm = $this->templateManager;
        $tm->generateConfig($page);

        $text = $page->getText($request->getLocale());
        $text->addTemplateVar('service', new Service())
            ->addTemplateVar('order', new Order())
            ->addTemplateVar('lead', new Lead())
            ->addTemplateVar('campaign', new Campaign())
            ->addTemplateVar('campaign_design', new CampaignDesign())
            ->addTemplateVar('product' ,new Product())
            ->addTemplateVar('checkout_background', null)
            ->addTemplateVar('order_redirect', null)
            ->addTemplateVar('descriptor', 'website.com +1234')
            ->addTemplateVar('contest_expires_datetime', '2020/10/10');

        $params = [
            'page' => $page,
            'pageText' => $text->onloadtext($this->imageManager->tm),
            'pageTheme' => $page->getTheme()->onloadImages($this->imageManager),
            'payment_form' => $this->createPaymentForm()->createView(),

            /** For Legacy Templates **/
            'product' => new Product(),
            'lead' => new Lead(),
            'service' => new Service(),
            'order' => new Order(),
            'campaign' => new Campaign(),
            'campaign_design' => new CampaignDesign(),
            'descriptor' => 'website.com +1234',
            'contest_expires_datetime' => '2020/10/10'
        ];

        return $this->render('page_template_dynamic/checkout/'.$page->getTemplate().'/index.html.twig', $params);
    }

    /**
     * @FW\Route("/please-wait", name="app.front.order.awaiting.confirmation")
     */
    public function awaitingConfirmationAction(Request $request)
    {
        $page = $this->demoManager->createPage(new PleaseWaitPage(), $this->pleaseWaitTemplate);
        $tm = $this->templateManager;
        $tm->generateConfig($page);

        $text = $page->getText($request->getLocale());
        $text->addTemplateVar('service', new Service())
            ->addTemplateVar('order', new Order())
            ->addTemplateVar('lead', new Lead())
            ->addTemplateVar('campaign', new Campaign())
            ->addTemplateVar('campaign_design', new CampaignDesign())
            ->addTemplateVar('product' ,new Product())
            ->addTemplateVar('checkout_background', null)
            ->addTemplateVar('order_redirect', null)
            ->addTemplateVar('descriptor', 'website.com +1234')
            ->addTemplateVar('contest_expires_datetime', '2020/10/10');

        $params = [
            'page' => $page,
            'pageText' => $text->onloadtext($this->imageManager->tm),
            'pageTheme' => $page->getTheme()->onloadImages($this->imageManager),
            'checkout_background' => null,
            'block_redirect' => true, // Toggle this to test failed
            'embedded' => 0,

            /** For Legacy Templates **/
            'service' => new Service(),
            'lead' => new Lead(),
            'merchantAccount' => new MerchantAccount(),
            'order' => new Order(),
            'order_status_ok' => OrderStatusEnum::COMPLETED,
            'order_status_failed' => [OrderStatusEnum::FAILED, OrderStatusEnum::UNPAID],
            'refresh_timer' => [6500, 6500, 5]
        ];

        return $this->render('page_template_dynamic/please_wait/'.$page->getTemplate().'/index.html.twig', $params);
    }

    /**
     * @FW\Route("/thank-you", name="app.front.order.thankyou")
     */
    public function thankyouAction(Request $request)
    {
        $page = $this->demoManager->createPage(new ThankYouPage(), $this->thankYouTemplate);
        $tm = $this->templateManager;
        $tm->generateConfig($page);

        $text = $page->getText($request->getLocale());
        $text->addTemplateVar('service', new Service())
            ->addTemplateVar('lead', new Lead())
            ->addTemplateVar('campaign_design', new CampaignDesign())
            ->addTemplateVar('merchant_account', new MerchantAccount())
            ->addTemplateVar('order_redirect', null)
            ->addTemplateVar('descriptor', 'website.com +1234');

        $params = [
            'page' => $page,
            'pageText' => $text->onloadtext($this->imageManager->tm),
            'pageTheme' => $page->getTheme()->onloadImages($this->imageManager),
            'embedded' => 0,

            /** For Legacy Templates **/
            'service' => new Service(),
            'lead' => new Lead(),
            'campaign_design' => new CampaignDesign(),
            'merchantAccount' => new MerchantAccount(),
            'checkout_background' => null,
            'order_redirect' => null
        ];

        return $this->render('page_template_dynamic/thank_you/'.$page->getTemplate().'/index.html.twig', $params);
    }


    /**
     * @FW\Route("/email-invoice", name="app.front.email")
     */
    public function emailAction(Request $request)
    {
        $page = $this->demoManager->createPage(new EmailPage(), $this->emailTemplate);

        $tm = $this->templateManager;
        $tm->generateConfig($page);

        $text = $page->getText($request->getLocale());
        $text->addTemplateVar('order', new Order())
            ->addTemplateVar('lead', new Lead())
            ->addTemplateVar('customer', new Customer())
            ->addTemplateVar('subscription', new Subscription())
            ->addTemplateVar('product', new Product())
            ->addTemplateVar('service', new Service())
            ->addTemplateVar('campaign_design', new CampaignDesign())
            ->addTemplateVar('merchant_account', new MerchantAccount())
            ->addTemplateVar('website_user', new WebsiteUser())
            ->addTemplateVar('descriptor', 'website.com +1234')

            ->addTemplateVar('subscription_cancellation_link', 'https://google.com/cancel')
            ->addTemplateVar('website_terms_and_conditions_link', 'https://google.com/terms');

        $order = new Order();
        $order->setProduct(new Product());

        $params = [
            'page' => $page,
            'pageText' => $text->onloadtext($this->imageManager->tm),
            'pageTheme' => $page->getTheme()->onloadImages($this->imageManager),

            /** For Legacy Templates **/
            'order' => $order,
            'terms_and_conditions' => 'TERMS AND CONDITIONS CONTENT'
        ];

        return $this->render('page_template_dynamic/email/'.$page->getTemplate().'/index.html.twig', $params);
    }

    /**
     * @FW\Route("/report-abuse", name="report_abuse")
     */
    public function reportAbuseAction(Request $request)
    {
        $page = $this->demoManager->createPage(new ReportAbusePage(), $this->reportAbuseTemplate);

        $tm = $this->templateManager;
        $tm->generateConfig($page);

        $text = $page->getText($request->getLocale());
        $text->addTemplateVar('service', new Service())
            ->addTemplateVar('abuse_case_id', 'CASE-1234')
            ->addTemplateVar('lead', new Lead());

        $order = new Order();
        $order->setProduct(new Product());



        $form = $this->createForm('reportAbuse', new ClickAbuseCase(), [
            'csrf_protection' => true,
        ]);

        $params = [
            'page' => $page,
            'pageText' => $text->onloadtext($this->imageManager->tm),
            'pageTheme' => $page->getTheme()->onloadImages($this->imageManager),
            'reportAbuseForm' => $form->createView(),
        ];

        return $this->render('page_template_dynamic/report_abuse/'.$page->getTemplate().'/index.html.twig', $params);
    }

    /**
     * @FW\Route("/submit-form", name="app.front.campaign.new")
     */
    public function newCampaignAction(Request $request)
    {
        dump($request->request->all());
        die();
    }

    /**
     * @FW\Route("/placeholders", name="app.front.placeholders")
     */
    public function showPlaceholdersAction()
    {
        return $this->render('placeholders.html.twig', [
            'placeholders' => PageText::$replacementMap
        ]);

    }

    private function createPaymentForm()
    {
        return $this->createForm(CreditCardType::class, new CreditCard());
    }

    private function createCustomerForm()
    {
        return $this->createForm($this->formType, new Customer(),
            [
                'validation_groups' => [$this->formType::VALIDATION_GROUP],
                'countryCode' => 'GB'
            ]);
    }


    /**
     * @FW\Route("/enter-contest", name="enter_contest")
     */
    public function enterContestAction() {
    }

    /**
     * @FW\Route("/ddc", name="app.funnel.device-data-collect")
     */
    public function ddcAction() {
    }
}