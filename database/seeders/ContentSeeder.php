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
        $content['key']         = 'en';
        $content['value']       = 'English';
        $content['language']    = 'en';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'vendifill';
        $content['key']         = 'es';
        $content['value']       = 'Español';
        $content['language']    = 'en';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'vendifill';
        $content['key']         = 'en';
        $content['value']       = 'English';
        $content['language']    = 'es';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'vendifill';
        $content['key']         = 'es';
        $content['value']       = 'Español';
        $content['language']    = 'es';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'select finance';
        $content['key']         = 'en';
        $content['value']       = 'English';
        $content['language']    = 'en';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'select finance';
        $content['key']         = 'es';
        $content['value']       = 'Español';
        $content['language']    = 'en';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'select finance';
        $content['key']         = 'en';
        $content['value']       = 'English';
        $content['language']    = 'es';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['app']         = 'select finance';
        $content['key']         = 'es';
        $content['value']       = 'Español';
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
