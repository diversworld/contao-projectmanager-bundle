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

namespace Diversworld\ContaoProjectmanagerBundle\Model;

use Contao\Model;

class ProjectTaskDependencyModel extends Model
{
    protected static $strTable = 'tl_project_task_dependency';
}
