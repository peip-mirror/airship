<?php
declare(strict_types=1);
namespace Airship\Cabin\Bridge;

use Airship\Engine\Security\Filter\{
    BoolFilter,
    InputFilterContainer,
    IntFilter,
    StringFilter
};

/**
 * Class ConfigFilter
 * @package Airship\Cabin\Bridge
 */
class ConfigFilter extends InputFilterContainer
{
    /**
     * ConfigFilter constructor.
     *
     * Specifies the filter rules for the cabin configuration POST rules.
     */
    public function __construct()
    {
        $this
            /* config_extra */
            ->addFilter('config_extra.board.enabled', new BoolFilter())
            ->addFilter('config_extra.recaptcha.secret-key', new StringFilter())
            ->addFilter('config_extra.recaptcha.site-key', new StringFilter())
            ->addFilter('config_extra.password-reset.enabled', new BoolFilter())
            ->addFilter('config_extra.password-reset.ttl', new IntFilter())
            ->addFilter('config_extra.file.cache', new IntFilter())
            ->addFilter('config_extra.two-factor.label', new StringFilter())
            ->addFilter('config_extra.two-factor.issuer', new StringFilter())
            ->addFilter(
                'config_extra.two-factor.length',
                (new IntFilter())->addCallback(
                    function ($var): int {
                        if ($var < 6) {
                            return 6;
                        } elseif ($var > 8) {
                            return 8;
                        }
                        return (int) $var;
                    }
                )
            )
            ->addFilter(
                'config_extra.two-factor.period',
                (new IntFilter())->addCallback(
                    function ($var): int {
                        if ($var < 30) {
                            return 30;
                        }
                        return (int) $var;
                    }
                )
            )
            /* twig_vars */
            ->addFilter('twig_vars.active-motif', new StringFilter())
            ->addFilter('twig_vars.title', new StringFilter())
            ->addFilter('twig_vars.tagline', new StringFilter())
        ;
    }
}
