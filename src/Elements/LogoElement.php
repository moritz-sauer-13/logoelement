<?php

namespace MoritzSauer\LogoElement;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class LogoElement extends BaseElement{

    /*Database*/
    private static $db = [

    ];

    private static $has_one = [

    ];

    private static $has_many = [
        'Logos' => Logo::class
    ];

    private static $many_many = [

    ];

    private static $many_many_extraFields = [

    ];

    /*CMS*/
    private static $summary_fields = [

    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Logos'
        ]);

        $fields->addFieldsToTab('Root.Main', [
            GridField::create(
                'Logos',
                'Logos',
                $this->Logos()->sort('SortOrder ASC'),
                GridFieldConfig_RecordEditor::create(30)
                    ->addComponent(GridFieldOrderableRows::create('SortOrder'))
            ),
        ]);

        return $fields;
    }

    /*Getter & Setter*/
    //Write here your getters & setters
    private function getConfigVariable($type, $field){
        return Config::inst()->get('MoritzSauer\LogoElement')[$type][$field];
    }

    /*Helper - Functions*/
    //Write here your helper-functions

    public function getType()
    {
        return 'Logo Element';
    }

    /*Template - Functions*/
    public function sortedLogos(){
        return $this->Logos()->sort('SortOrder ASC');
    }
}