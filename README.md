# template-builder

# DOCKER + INSTRUCTIONS:

- Install Docker and docker compose to your OS.
- docker compose up -d
- rename .env.example to .env in a root directory.
- docker exec -it template-builder-php-1 php composer.phar install (if it gives errors, check the running container name by applying the command “docker ps -a”. Then modify template-builder-php-1 part from the command according to your container name).

SAMPLES:

- Copy "templates/samples" into "templates/page_template_dynamic" folder.

INSTALLATION:

You must be on php 7.4 on your docker container please confirm with the command "php -v"
Go to the project root and run "php bin/console composer.phar install"

You must receive a template folder, and a valid .env file to run the project.

php composer.phar install

# USAGE:

- checkout page
- please wait page
- thank you
- landing

See placehodlers:
- /placeholders

The template system uses TWIG; you can read more about the various twig functions here:
https://twig.symfony.com/doc/3.x/functions/index.html

Please see the example checkout template included in the project.

The 3 preview URL's are:

/order
/please-wait
/thank-you

The templates can be configured in the top of src/App/MainBundle/Controller/DefaultController.php

    protected $checkoutTemplate = 'new_checkout_page';

    protected $thankYouTemplate = 'template_name';

    protected $pleaseWaitTemplate = 'template_name';

The templates can be found in: app/Resources/views/templates

# HELPER OBJECTS:

- pageText.get(configKey)
- description: Must be used on all text in the template, so its translatable, and editable in the admin panel.
- When a key is defined in the config.yml, that key can be used to display the text.

- The text should be written freely as the english translation.
- example: pageText.get('This is some cool text')

- placeholders can be used for example:
- pageText.get('%descriptor% will be displayed on your bank statement as a charge form %company_name%')
- Will output: 'www.website.com will be displayed on your bank statement as a charge form Acme Corp Ltd'
- For a full list of placeholders you can use, go to "/placeholders"

- If you want to define a large input area, you must use the full configuration for a textarea in the config file:
- - field:
    key: "Bottom Section Text"
    type: textarea

You can see this in the config.yml of the example checkout template


- pageTheme.getImage(configKey)
- This is used to display an image, which is defined in config.yml

- only use PNG images


# Making Email Templates (step by step, If above usage example is not enough):
- Follow DOCKER + INSTRUCTIONS part and prepare your environment.
- Make a html according to the provided mockup. Use mostly tables(as divs break in smaller screen sizes and all email clients don't support all css), the css/js should be in the same file or use inline css. Images must be hosted on imgur or free image hosting service. Use the image url in src field of img tag.
- Go to app/Resources/views/templates/email/ folder and if there are any folders, copy and paste it there. Then rename it. There is a folder naming convention: crm_year_email_type_extras. For example, desert media crm subscription renew email will be like this: dm_2023_subscription_renew_benset
- Open src/App/MainBundle/Controller/DefaultController.php and find the line protected $emailTemplate = and replace the variable’s value with your folder name.
- Reload the browser page and it will show an email template.
- Now open the folder you renamed, there will be a file index.html.twig replace all contents inside the file with the html template you’ve built.
- Now follow previous folders of the same type of email in the emails/ folder. There are already twig code examples with variables/texts. Copy those and use those in appropriate places of your template.
- Your twig template should not have any static texts. All static texts need to be covered with codes like this {{ pageText.get('INVOICE') }} as static texts are not translatable.
- Once all is done, and you have checked everything and those are correct, open a free chatGPT account if you don’t have one already.
- In the template, there should be long lines like this : {{ pageText.get('When the promotional period concludes, your account will be billed %order_subscription_price% every %order_subscription_interval_days% days.') }}
- Now copy this part 'When the promotional period concludes, your account will be billed %order_subscription_price% every %order_subscription_interval_days% days.'  and ask chatgpt to “use different words but the line should have the same meaning” and replace the text of your template with the output of chatgpt.
- When everything is done and correct, inform your seniors for checking and uploading.



# Release notes:

- 2024-03-03

Most recent changes to template building:

1. The template config.yml builder now parses included templates, this means that you can use pageText.get('') inside of form includes, or other includes, and it will automatically be inserted into config.yml ready for user input from the admin panel, or auto-translation.
2. As 99% of changes related to _customer_form's were related to checkboxes, and their text, it is now possible to include the terms_section from the landing page, this way you avoid copying the entire shared form, if you just need to change the checkboxes.
   Example:

{% set termsCheckboxSection = '@AppUpgrade/Template/_shared/_customer_form/_terms/_main_terms.html.twig' %}

{% include '@AppUpgrade/Template/_shared/_customer_form/_master_form_2024.html.twig' with {
'termsCheckboxSection': termsCheckboxSection,
} %}

You should stick to using _master_form_2024 at all times, unless there is very good reason to changing it.

3. Modernized mobile phone input with country prefix has been added to _master_form_2024, this is the new standard and should always be used to ease phone number input.

4. You can toggle direct signup vs vertical by uncommenting / commenting In landingAction:
   // toggle direct signup vs vertical
   //$campaign->vertical = null;
   //$campaign->setContest(false);

- 2024-06-11

