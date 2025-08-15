<?php

declare(strict_types=1);

/*
 * This file is part of Project Manager.
 *
 * (c) Diversworld Eckhard Becker 2025 <info@diversworld.eu>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/diversworld/contao-projectmanager-bundle
 */

namespace Diversworld\ContaoProjectmanagerBundle\ContaoManager;

use Diversworld\ContaoProjectmanagerBundle\DiversworldContaoProjectmanagerBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouteCollection;

class Plugin implements BundlePluginInterface, RoutingPluginInterface
{
    /**
     * @return array
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(DiversworldContaoProjectmanagerBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }

    /**
     * @return RouteCollection|null
     */
    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        return $resolver
            ->resolve(__DIR__.'/../Controller')
            ->load(__DIR__.'/../Controller');
    }
}
