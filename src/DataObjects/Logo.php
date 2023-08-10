<?php

namespace MoritzSauer\LogoElement;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class Logo extends DataObject{

    /*Database*/
    private static $db = [
        'SortOrder' => 'Int',
        'Title' => 'Text',
        'ExternalLink' => 'Text',
        'Content' => 'HTMLText'
    ];

    private static $has_one = [
        'Logo' => Image::class,
        'ColoredLogo' => Image::class,
        'Image' => Image::class,
        'LogoElement' => LogoElement::class,
    ];

    private static $has_many = [

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
            'SortOrder',
            'LogoElementID',
            'Content',
            'ColoredLogo',
            'DetailImage',
        ]);

        /*Get all fields*/
        $schema = DataObject::getSchema();
        $allFields = $schema->fieldSpecs($this);
        $columns = array_keys($allFields);

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Title', 'Titel'),
            TextField::create('ExternalLink', 'Externer Link')
                ->setDescription('Hier kann ein Link auf die entsprechende Seite des Logos eingefügt werden. <br><strong>Wichtig: Mit "https://" pflegen.</strong>'),
            HTMLEditorField::create('Content', 'Inhalt')->setRows(8),
            UploadField::create('Logo', 'Logo'),
            UploadField::create('ColoredLogo', 'Logo (Farbig)')
                ->setDescription('z.B. für einen Hover Effekt'),
            UploadField::create('Image', 'Bild')
                ->setDescription('z.B. für eine Detailansicht'),
        ]);

        /*Remove Fields depending on chosen layout and settings in .yml*/
        foreach ($columns as $field) {
            if (!in_array($field, $this->getReservedFields())) {
                if (!$this->getConfigVariable('FieldsVisibleObject', $field)) {
                    $fields->removeByName($field);
                    $field = str_replace('ID', '', $field);
                    $fields->removeByName($field);
                }
            }
        }

        return $fields;
    }

    /*Getter & Setter*/
    //Write here your getters & setters
    private function getConfigVariable($type, $field){
        return Config::inst()->get('MoritzSauer\LogoElement')[$type][$field];
    }

    private function getReservedFields(): array
    {
        return [
            'Title',
        ];
    }

    /*Helper - Functions*/
    //Write here your helper-functions

    /*Template - Functions*/
    public function cleanedExternalLink(){
        if($this->ExternalLink != ''){
            return str_replace(['https://', 'http://'], '', $this->ExternalLink);
        }
        return '';
    }

    public function showImage(){
        return $this->getConfigVariable('FieldsVisibleObject', 'ImageID') && $this->ImageID > 0;
    }

    public function showModal(){
        return $this->getConfigVariable('Settings', 'showModal') && $this->Content !== '';
    }
}