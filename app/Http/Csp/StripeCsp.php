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
            ->addDirective(Directive::CONNECT, 'https://api.stripe.com')
            ->addDirective(Directive::STYLE, [Keyword::SELF, 'fonts.googleapis.com'])
            ->addDirective(Directive::FONT, 'fonts.gstatic.com')
            ->addDirective(Directive::FRAME, 'https://js.stripe.com https://hooks.stripe.com')
            ->addDirective(Directive::SCRIPT, [Keyword::SELF, Keyword::UNSAFE_INLINE, Keyword::UNSAFE_EVAL, 'https://js.stripe.com' ])
            ->addNonceForDirective(Directive::SCRIPT);
    }
}
