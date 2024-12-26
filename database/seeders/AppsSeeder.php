<?php

namespace Database\Seeders;

use App\Models\App;
use App\Models\AppKvStore;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apps = [];
        $app['id'] = 1;
        $app['user_id'] = 1;
        $app['name']    = 'VendiFill';
        $app['status']  = 'Active';
        $apps[] = $app;

        $app['id'] = 2;
        $app['user_id'] = 2;
        $app['name']    = 'Select Finance';
        $app['status']  = 'Active';
        $apps[] = $app;

        $app['id'] = 3;
        $app['user_id'] = 2;
        $app['name']    = 'iframe lease calculator';
        $app['status']  = 'Active';
        $apps[] = $app;

        $app['id'] = 4;
        $app['user_id'] = 2;
        $app['name']    = 'iframe lease products';
        $app['status']  = 'Active';
        $apps[] = $app;

        $app['id'] = 5;
        $app['user_id'] = 2;
        $app['name']    = 'iframe lease product details';
        $app['status']  = 'Active';
        $apps[] = $app;

        foreach( $apps as $app){
            App::create( $app );
        }

        $kvs = [];

        $kv['topic'] = 'config';
        $kv['key'] = 'available_locales';
        $kv['value'] = 'en,es';
        $kv['app_id'] = 1;
        $kvs[] = $kv;

        $kv['topic'] = 'config';
        $kv['key'] = 'available_locales';
        $kv['value'] = 'en,nl';
        $kv['app_id'] = 2;
        $kvs[] = $kv;

        $kv['topic'] = 'config';
        $kv['key'] = 'available_locales';
        $kv['value'] = 'en,nl';
        $kv['app_id'] = 3;
        $kvs[] = $kv;

        $kv['topic'] = 'config';
        $kv['key'] = 'available_locales';
        $kv['value'] = 'en,nl';
        $kv['app_id'] = 4;
        $kvs[] = $kv;

        foreach( $kvs as $kv){
            AppKvStore::create( $kv);
        }

    }
}
