<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 6/23/2021
 * Time: 10:19 AM
 */

Route::group(['prefix' => 'setting/email'], function () {
    Route::get('/', 'EmailController@index')->name('admin.setting.test-email');

    Route::post('/', 'EmailController@save')->name('admin.setting.email.save');

    Route::post('send-test-mail', 'EmailController@sendTestMail')->name('admin.email.test-email');
});

Route::jwResource('email-template', 'EmailTemplateController');

Route::group(['prefix' => 'logs/email'], function () {
    Route::get('/', 'EmailLogsController@index')->name('admin.logs.email');

    Route::get('/get-data', 'EmailLogsController@getData')->name('admin.logs.email.getdata');

    Route::post('/status', 'EmailLogsController@status')->name('admin.logs.email.status');

    Route::post('/remove', 'EmailLogsController@remove')->name('admin.logs.email.remove');
});
