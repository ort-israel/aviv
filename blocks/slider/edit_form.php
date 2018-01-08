<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Simple slider block for Moodle
 *
 * @package   block_slider
 * @copyright 2015 Kamil Łuczak    www.limsko.pl     kamil@limsko.pl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_slider_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        // A sample string variable with a default value.
        $mform->addElement('text', 'config_text', get_string('header', 'block_slider'));
        $mform->setDefault('config_text', '');
        $mform->setType('config_text', PARAM_RAW);
        //slider width
        $mform->addElement('text', 'config_width', get_string('width', 'block_slider'));
        $mform->setDefault('config_width', '940');
        $mform->setType('config_width', PARAM_RAW);
        //slider height
        $mform->addElement('text', 'config_height', get_string('height', 'block_slider'));
        $mform->setDefault('config_height', '528');
        $mform->setType('config_height', PARAM_RAW);
        //slider int
        $mform->addElement('text', 'config_interval', get_string('int', 'block_slider'));
        $mform->setDefault('config_interval', '5000');
        $mform->setType('config_interval', PARAM_RAW);
        $mform->addElement('select', 'config_effect', get_string('effect', 'block_slider'), array('fade','slide'), null);
        $mform->addElement('advcheckbox', 'config_navigation', get_string('nav', 'block_slider'), get_string('nav_desc', 'block_slider'), array('group' => 1), array(0, 1));
        $mform->setDefault('config_navigation', 1);
        $mform->addElement('advcheckbox', 'config_pagination', get_string('pag', 'block_slider'), get_string('pag_desc', 'block_slider'), array('group' => 1), array(0, 1));
        $mform->setDefault('config_pagination', 1);
		  $mform->addElement('advcheckbox', 'config_autoplay', get_string('auto_play', 'block_slider'), get_string('auto_play_desc', 'block_slider'), array('group' => 1), array(0, 1));	
        $mform->setDefault('config_autoplay', 1);
        $mform->addElement('filemanager', 'config_attachments', get_string('images', 'block_slider'), null,
        array('subdirs' => 0, 'maxbytes' => 5000000, 'maxfiles' => 10,
        'accepted_types' => array('.png', '.jpg', '.gif') ));
    }

    function set_data($defaults) {

        if (empty($entry->id)) {
            $entry = new stdClass;
            $entry->id = null;
        }

        $draftitemid = file_get_submitted_draft_itemid('config_attachments');

        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_slider', 'content', 0,
        array('subdirs'=>true));

        $entry->attachments = $draftitemid;

        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_attachments, $this->block->context->id, 'block_slider', 'content', 0, 
            array('subdirs' => true));
        }
    }
}