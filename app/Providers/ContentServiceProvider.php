<?php

namespace App\Providers;

use App\Models\Content;
use http\Client;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\ContentController;
class ContentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // get all the content from the server and populate redis
        try {
            $items = DB::table("content")->where('status', 'active')->get();
            foreach ($items as $item) {
                $key = $item->key;
                if ($item->page != null) {
                    $key .= '.' . $item->page;
                }
                if ($item->language != null) {
                    $key .= '.' . $item->language;
                }
                Redis::set($key, $item->value);
            }
        }catch( \Exception $e ) {
            error_log($e->getMessage());
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('c', function (string $expression) {
            return "<?php echo \App\Http\Controllers\ContentController::translate( $expression); ?>";
        });
    }
}
