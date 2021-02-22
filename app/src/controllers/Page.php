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
            Requirements::css($ThemeDir . 'css/style.css');

            // js
            Requirements::javascript('https://code.jquery.com/jquery-3.5.1.slim.min.js');
            Requirements::javascript('https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js');
        }
    }
}
