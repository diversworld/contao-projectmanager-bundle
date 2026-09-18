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
$GLOBALS['TL_LANG']['tl_project_task']['title_legend'] = "Basisinformationen";
$GLOBALS['TL_LANG']['tl_project_task']['task_legend'] = "Aufgabeninformationen";
$GLOBALS['TL_LANG']['tl_project_task']['date_legend'] = "Datumsinformationen";
$GLOBALS['TL_LANG']['tl_project_task']['details_legend'] = "Detailinformationen";
$GLOBALS['TL_LANG']['tl_project_task']['publish_legend'] = "Veröffentlichen";

/**
* Global operations
*/
$GLOBALS['TL_LANG']['tl_project_task']['new'] = ["Neu", "Ein neues Element anlegen"];

/**
 * Operations
 */
$GLOBALS['TL_LANG']['tl_project_task']['edit'] = "Datensatz mit ID: %s bearbeiten";
$GLOBALS['TL_LANG']['tl_project_task']['copy'] = "Datensatz mit ID: %s kopieren";
$GLOBALS['TL_LANG']['tl_project_task']['delete'] = "Datensatz mit ID: %s löschen";
$GLOBALS['TL_LANG']['tl_project_task']['show'] = "Datensatz mit ID: %s ansehen";

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_project_task']['title'] = ["Aufgabe", "Geben Sie die Bezeichnung der Aufgabe ein."];
$GLOBALS['TL_LANG']['tl_project_task']['alias'] = ["Alias", "Geben Sie den Alias der Aufgabe ein."];
$GLOBALS['TL_LANG']['tl_project_task']['priority'] = ["Priorität", "Geben Sie die Priorität der Aufgabe ein."];
$GLOBALS['TL_LANG']['tl_project_task']['progress'] = ["Fortschritt", "Geben Sie den Bearbeitungsfortschritt ein."];
$GLOBALS['TL_LANG']['tl_project_task']['status'] = ["Status", "Wählen Sie den Status der Aufgabe aus."];
$GLOBALS['TL_LANG']['tl_project_task']['predecessor'] = ["Vorgänger", "Wählen Sie die Aufgaben aus, die vor dieser Aufgabe erledigt werden sollen."];
$GLOBALS['TL_LANG']['tl_project_task']['successor'] = ["Nachfolger", "Wählen Sie die Aufgaben aus, die nach dieser Aufgabe erledigt werden sollen."];
$GLOBALS['TL_LANG']['tl_project_task']['milestone'] = ["Meilenstein", "Geben Sie an, ob die Aufgabe ein Meilenstein ist."];
$GLOBALS['TL_LANG']['tl_project_task']['startDate'] = ["Startdatum", "Geben Sie das Startdatum der Aufgabe an."];
$GLOBALS['TL_LANG']['tl_project_task']['endDate'] = ["Enddatum", "Geben Sie das Enddatum der Aufgabe an."];
$GLOBALS['TL_LANG']['tl_project_task']['description'] = ["Aufgabenbeschreibung", "Beschreiben Sie den Inhalt der AUfgabe. Was ist zu tun."];
$GLOBALS['TL_LANG']['tl_project_task']['addNotes'] = ["Bemerkungen aktivieren", "Hier können Sie das Feld Bemerkungen aktivieren."];
$GLOBALS['TL_LANG']['tl_project_task']['notes'] = ["Bemerkungen", "Geben Sie Bemerkungen zur Aufgabe ein."];
$GLOBALS['TL_LANG']['tl_project_task']['published'] = ["Veröffentlichen", "Geben Sie an, ob die Aufgabe veröffentlicht werden soll."];
$GLOBALS['TL_LANG']['tl_project_task']['start'] = ["ab Datum", "Ab wann soll die Aufgabe veröffentlicht werden."];
$GLOBALS['TL_LANG']['tl_project_task']['stop'] = ["bis Datum", "Bis wann soll die Aufgabe veröffentlicht werden."];

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_project_task']['taskStatus'] = [
    '1' => 'ToDo',
    '2' => 'in Bearbeitung',
    '3' => 'Erledigt'
];
$GLOBALS['TL_LANG']['tl_project_task']['taskPriority'] = [
    '1' => 'Dringend',
    '2' => 'Hoch',
    '3' => 'Normal',
    '4' => 'Niedrig'
];

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_project_task']['customButton'] = "Custom Routine starten";
