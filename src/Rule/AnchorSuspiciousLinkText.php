<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;
use Taheralfayad\IsItDescriptive\DescriptivenessModel;

/**
*  Suspicious link text.
*  a (anchor) element cannot contain any of the following text (English): \"click here\""
*	@link http://quail-lib.org/test-info/aSuspiciousLinkText
*/
class AnchorSuspiciousLinkText extends BaseRule
{
    
    var $strings = array('en' => array('click here', 'click', 'more', 'here'),
    'es' => array('clic aqu&iacute;', 'clic', 'haga clic', 'm&aacute;s', 'aqu&iacute;'));
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        $model = new DescriptivenessModel();
        foreach ($this->getAllElements('a') as $a) {
            if ($this->translation() == 'es'){
                if((in_array(strtolower(trim($a->nodeValue)), $this->translation()) || $a->nodeValue == $a->getAttribute('href')) && $a->getAttribute('href') != "") {
                    $this->setIssue($a);
                }
            }
            else if (isset($a->nodeValue) && $model->isDescriptive($a->nodeValue) == "1")
                $this->setIssue($a);
            $this->totalTests++;
        }

        return count($this->issues);
    }

}
