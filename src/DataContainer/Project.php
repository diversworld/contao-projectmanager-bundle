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

namespace Diversworld\ContaoProjectmanagerBundle\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\DataContainer;
use Contao\Input;
use Contao\System;

#[AsCallback(table: 'tl_project', target: 'edit.buttons', priority: 100)]
class Project
{

    public function __construct(
        private readonly ContaoFramework $framework,
    ) {
    }

    public function __invoke(array $arrButtons, DataContainer $dc): array
    {
        $inputAdapter = $this->framework->getAdapter(Input::class);
        $systemAdapter = $this->framework->getAdapter(System::class);

        $systemAdapter->loadLanguageFile('tl_project');

        if ('edit' === $inputAdapter->get('act')) {
            $projectId = (int) $dc->id;

            // Link-Button: öffnet direkt das Gantt-Diagramm für das aktuelle Projekt
            $arrButtons['ganttButton'] = sprintf(
                '<a href="contao?do=project_collection&table=tl_project&key=gantt&id=%d" id="ganttDiagram" class="tl_submit ganttDiagram" accesskey="x">%s</a>',
                $projectId,
                $GLOBALS['TL_LANG']['tl_project']['ganttButton'] ?? 'Gantt-Diagramm'
            );
        }

        return $arrButtons;
    }
}
