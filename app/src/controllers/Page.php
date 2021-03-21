<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\View\Requirements;
    use SilverStripe\Forms\Form;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\TextField;
    use SilverStripe\Forms\EmailField;
    use SilverStripe\Forms\TextareaField;
    use SilverStripe\Forms\FormAction;
    use SilverStripe\Forms\RequiredFields;
    use SilverStripe\Control\Email\Email;
    use SilverStripe\Forms\CompositeField;

    class PageController extends ContentController
    {
        private static $allowed_actions = []; 

        protected function init()
        {
            parent::init();
            
            $ThemeDir =  "app/";
            // You can include any CSS or JS required by your project here.
            // css
            Requirements::css('https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css');
            Requirements::css('https://pro.fontawesome.com/releases/v5.10.0/css/all.css');
            Requirements::css($ThemeDir . 'css/style.css');

            // js
            Requirements::javascript('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js');
            Requirements::javascript('https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js');
            Requirements::javascript($ThemeDir . 'js/garlicjs/garlic.js');
            Requirements::javascript($ThemeDir . 'js/style.js');
        }
    }
}
