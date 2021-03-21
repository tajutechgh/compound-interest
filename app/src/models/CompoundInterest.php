<?php

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\Member;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Versioned\Versioned;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\GridField\GridFieldViewButton;

class CompoundInterest extends DataObject
{
  private static $db = [
    'InitialDeposit' => 'Varchar',
    'Rate' => 'Varchar',
    'CompoundFrequency' => 'Varchar',
    'TimeYear' => 'Varchar',
    'TimeMonth' => 'Varchar',
    'CompoundInterest' => 'Varchar',
    'DepositAmount' => 'Varchar',
    'DepositCompound' => 'Varchar',
    'DepositAnnualInflationRate' => 'Varchar',
    'WithdrawalAmount' => 'Varchar',
    'WithdrawalCompound' => 'Varchar',
    'WithdrawalAnnualInflationRate' => 'Varchar',
    'DepositMadeAt' => 'Varchar',
    'WithdrawalMadeAt' => 'Varchar',
  ];

  private static $has_one = [];

  private static $owns = [];

  private static $extensions = [
    Versioned::class,
  ];

  private static $summary_fields = [
    'InitialDeposit' => 'Initial Deposit',
    'Rate' => 'Rate',
    'CompoundFrequency' => 'Compound Frequency',
    'Time' => 'Time',
    'CompoundInterest' => 'Compound Interest',
  ];
}