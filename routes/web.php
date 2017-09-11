<?php
Route::get('/', 'Controller@index')->name('home');
Route::get('/introduction', 'Controller@introduction')->name('introduction');
Route::get('/resume', 'Controller@resume')->name('resume');
Route::get('/contact', 'Controller@contact')->name('contact');
Route::get('/design', 'Controller@design')->name('design');
Route::get('/code', 'Controller@code')->name('code');