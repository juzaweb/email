<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 8/15/2021
 * Time: 5:53 PM
 */

namespace Juzaweb\Email;

use Illuminate\Support\Facades\Route;

class Email
{
    protected static $namespace = 'Juzaweb\Email\Http\Controllers';

    public static function adminRoutes()
    {
        Route::namespace(self::$namespace)
            ->group(__DIR__ . '/routes/admin.php');
    }
}