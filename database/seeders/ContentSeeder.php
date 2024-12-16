<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function Content(): array
    {
        $contents               = [];

        $content['app']         = 'vendifill';
        $content['env']         = 'production';
        $content['env_source']  = 'seed';
        $content['key']         = 'en';
        $content['value']       = 'English';
        $content['default']     = 'English';
        $content['language']    = 'en';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'vendifill';
        $content['env']         = 'production';
        $content['env_source']  = 'seed';
        $content['key']         = 'es';
        $content['value']       = 'Español';
        $content['default']     = 'Español';
        $content['language']    = 'en';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'vendifill';
        $content['env']         = 'production';
        $content['env_source']  = 'seed';
        $content['key']         = 'en';
        $content['value']       = 'English';
        $content['default']     = 'English';
        $content['language']    = 'es';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'vendifill';
        $content['env']         = 'production';
        $content['env_source']  = 'seed';
        $content['key']         = 'es';
        $content['value']       = 'Español';
        $content['default']     = 'Español';
        $content['language']    = 'es';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'select finance';
        $content['env']         = 'production';
        $content['env_source']  = 'seed';
        $content['key']         = 'en';
        $content['value']       = 'English';
        $content['default']     = 'English';
        $content['language']    = 'en';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'select finance';
        $content['env']         = 'production';
        $content['env_source']  = 'seed';
        $content['key']         = 'es';
        $content['value']       = 'Español';
        $content['default']     = 'Español';
        $content['language']    = 'en';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'select finance';
        $content['key']         = 'en';
        $content['env']         = 'production';
        $content['env_source']  = 'seed';
        $content['value']       = 'English';
        $content['default']     = 'English';
        $content['language']    = 'es';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'select finance';
        $content['key']         = 'es';
        $content['env']         = 'production';
        $content['env_source']  = 'seed';
        $content['value']       = 'Español';
        $content['default']     = 'Español';
        $content['language']    = 'es';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        return $contents;
    }
    public function run(): void
    {
        foreach( $this->Content() as $content ){
            Content::create( $content);
        }
    }
}
