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

namespace Diversworld\ContaoProjectmanagerBundle;

use Diversworld\ContaoProjectmanagerBundle\DependencyInjection\DiversworldContaoProjectmanagerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DiversworldContaoProjectmanagerBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension(): DiversworldContaoProjectmanagerExtension
    {
        return new DiversworldContaoProjectmanagerExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }
}
