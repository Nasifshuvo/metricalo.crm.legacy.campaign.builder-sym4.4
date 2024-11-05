<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Sonata\AdminBundle\Bridge\Exporter\AdminExporter;
use Sonata\AdminBundle\DependencyInjection\Compiler\AliasDeprecatedPublicServicesCompilerPass;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // Use "service" function for creating references to services when dropping support for Symfony 4.4
    // Use "param" function for creating references to parameters when dropping support for Symfony 5.1
    $containerConfigurator->services()

        ->set('sonata.admin.admin_exporter', AdminExporter::class)
            // NEXT_MAJOR: Remove public and sonata.container.private tag.
            ->public()
            ->tag(AliasDeprecatedPublicServicesCompilerPass::PRIVATE_TAG_NAME, ['version' => '3.98'])
            ->args([
                new ReferenceConfigurator('sonata.exporter.exporter'),
            ])
        // NEXT_MAJOR: Remove this alias.
        ->alias('sonata.admin.admin_exporter.do-not-use', 'sonata.admin.admin_exporter')
        ->public();
};
