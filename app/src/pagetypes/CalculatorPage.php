<?php

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class CalculatorPage extends Page
{
    // home page has many sliders and gallery
    private static $has_many = [];

    // home page owns the sliders
    private static $owns = [];
}
