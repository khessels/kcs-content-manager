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

        $content['user_id']     = 1;
        $content['key']         = 'english';
        $content['value']       = 'English';
        $content['language']    = 'en';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['user_id']     = 1;
        $content['key']         = 'spanish';
        $content['value']       = 'Spanish';
        $content['language']    = 'en';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['user_id']     = 1;
        $content['key']         = 'english';
        $content['value']       = 'Inglis';
        $content['language']    = 'es';
        $content['mimetype']    = 'text/plain';
        $contents[] = $content;

        $content['user_id']     = 1;
        $content['key']         = 'spanish';
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
