<?php

namespace Websailing\SubcolumnsBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Websailing\LegacyCompatBundle\LegacyCompatBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Websailing\SubcolumnsBundle\SubcolumnsBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(SubcolumnsBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, LegacyCompatBundle::class]),
        ];
    }
}
