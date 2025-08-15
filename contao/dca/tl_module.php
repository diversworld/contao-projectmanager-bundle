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

use Diversworld\ContaoProjectmanagerBundle\Controller\FrontendModule\ProjectListingController;

/**
 * Frontend modules
 */
$GLOBALS['TL_DCA']['tl_module']['palettes'][ProjectListingController::TYPE] = '{title_legend},name,headline,type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';
