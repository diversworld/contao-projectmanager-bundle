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
 * Backend modules
 */
$GLOBALS['TL_LANG']['MOD']['project_modules'] = 'Project Manager';
$GLOBALS['TL_LANG']['MOD']['project_collection'] = ['Projektaufgaben', 'Verwaltung von Projektaufgaben'];
$GLOBALS['TL_LANG']['MOD']['project_gantt'] = ['Gantt Diagramm', 'Gantt Diagramm des Projekts'];

/**
 * Frontend modules
 */
$GLOBALS['TL_LANG']['FMD']['project_modules'] = 'Projektaufgaben';
$GLOBALS['TL_LANG']['FMD'][ProjectListingController::TYPE] = ['Projektaufgaben', 'Verwaltung von Projektaufgaben'];

