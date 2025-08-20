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

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_project_task']['title_legend']   = "Basic information";
$GLOBALS['TL_LANG']['tl_project_task']['task_legend']    = "Task information";
$GLOBALS['TL_LANG']['tl_project_task']['date_legend']    = "Date information";
$GLOBALS['TL_LANG']['tl_project_task']['details_legend'] = "Detailed information";
$GLOBALS['TL_LANG']['tl_project_task']['publish_legend'] = "Publish";

/**
* Global operations
*/
$GLOBALS['TL_LANG']['tl_project_task']['new'] = ["New", "Create a new element"];

/**
 * Operations
 */
$GLOBALS['TL_LANG']['tl_project_task']['edit']   = "Edit record with ID: %s";
$GLOBALS['TL_LANG']['tl_project_task']['copy']   = "Copy record with ID: %s";
$GLOBALS['TL_LANG']['tl_project_task']['delete'] = "Delete record with ID: %s";
$GLOBALS['TL_LANG']['tl_project_task']['show']   = "Show record with ID: %s";

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_project_task']['title']       = ["Task", "Please enter the task name."];
$GLOBALS['TL_LANG']['tl_project_task']['alias']       = ["Alias", "Please enter the task alias."];
$GLOBALS['TL_LANG']['tl_project_task']['priority']    = ["Priority", "Please enter the task priority."];
$GLOBALS['TL_LANG']['tl_project_task']['progress']    = ["Progress", "Please enter the task progress."];
$GLOBALS['TL_LANG']['tl_project_task']['status']      = ["Status", "Please select the task status."];
$GLOBALS['TL_LANG']['tl_project_task']['predecessor'] = ["Predecessor", "Select the tasks that must be completed before this task."];
$GLOBALS['TL_LANG']['tl_project_task']['successor']   = ["Successor", "Select the tasks that should follow this task."];
$GLOBALS['TL_LANG']['tl_project_task']['milestone']   = ["Milestone", "Specify whether this task is a milestone."];
$GLOBALS['TL_LANG']['tl_project_task']['startDate']   = ["Start date", "Please enter the start date of the task."];
$GLOBALS['TL_LANG']['tl_project_task']['endDate']     = ["End date", "Please enter the end date of the task."];
$GLOBALS['TL_LANG']['tl_project_task']['description'] = ["Task description", "Describe the content of the task. What needs to be done?"];
$GLOBALS['TL_LANG']['tl_project_task']['addNotes']    = ["Enable notes", "Here you can enable the notes field."];
$GLOBALS['TL_LANG']['tl_project_task']['notes']       = ["Notes", "Please enter notes for the task."];
$GLOBALS['TL_LANG']['tl_project_task']['published']   = ["Publish", "Specify whether the task should be published."];
$GLOBALS['TL_LANG']['tl_project_task']['start']       = ["Start date", "From when should the task be published."];
$GLOBALS['TL_LANG']['tl_project_task']['stop']        = ["End date", "Until when should the task be published."];

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_project_task']['firstoption']  = "To do";
$GLOBALS['TL_LANG']['tl_project_task']['secondoption'] = "In progress";
$GLOBALS['TL_LANG']['tl_project_task']['thirdoption']  = "Completed";

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_project_task']['customButton'] = "Start custom routine";
