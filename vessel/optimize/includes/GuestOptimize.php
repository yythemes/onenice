<?php
namespace vessel\optimize\includes;

use function vessel\optimize_get as get;

class GuestOptimize
{
    public function __construct()
    {
        // wordpress
        get('disable_admin_bar') && add_filter('show_admin_bar', '__return_false');

    }
}