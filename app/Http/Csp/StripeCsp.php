<?php

namespace App\Http\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Policy;

class StripeCsp extends Policy
{

    public function configure()
    {
        $this->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::DEFAULT, Keyword::SELF)
            ->addDirective(Directive::CONNECT, Keyword::SELF)
            ->addDirective(Directive::STYLE, Keyword::SELF)
            ->addDirective(Directive::FONT, Keyword::SELF)
            ->addDirective(Directive::FRAME, Keyword::SELF)
            ->addDirective(Directive::SCRIPT, Keyword::SELF)
            ->addNonceForDirective(Directive::STYLE)
            ->addNonceForDirective(Directive::SCRIPT);
    }
}
