<?php

namespace Database\Seeders;

use App\Models\App;
use App\Models\AppKvStore;
use App\Models\Mimetype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Symfony\Component\Mime\MimeTypes;

class MimeTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mimetypes = [];

        $mimetype['mimetype'] = 'text/plain';
        $mimetypes[] = $mimetype;

        $mimetype['mimetype'] = 'text/html';
        $mimetypes[] = $mimetype;

        $mimetype['mimetype'] = 'application/pdf';
        $mimetypes[] = $mimetype;

        $mimetype['mimetype'] = 'application/json';
        $mimetypes[] = $mimetype;

        $mimetype['mimetype'] = 'application/xml';
        $mimetypes[] = $mimetype;

        $mimetype['mimetype'] = 'image/jpeg';
        $mimetypes[] = $mimetype;
        $mimetype['mimetype'] = 'image/jpg';
        $mimetypes[] = $mimetype;
        $mimetype['mimetype'] = 'image/png';
        $mimetypes[] = $mimetype;
        $mimetype['mimetype'] = 'image/webp';
        $mimetypes[] = $mimetype;
        $mimetype['mimetype'] = 'image/svg';
        $mimetypes[] = $mimetype;

        foreach( $mimetypes as $mimetype){
            Mimetype::create( $mimetype);
        }

    }
}
