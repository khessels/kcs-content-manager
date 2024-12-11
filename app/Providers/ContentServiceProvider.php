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
            if( (int) config('kcs-content-manager.expire') > 0) {
                $app = config('kcs-content-manager.app');
                // we do not want to read multiple times in a short time span.
                $redisSet = Redis::get($app . '.redis-set');
                if (!$redisSet) {

                    $response = Http::withHeaders([
                        'Authentication' => 'bearer ' . config('kcs-content-manager.token'),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'x-app' => $app
                    ])
                        ->get(config('kcs-content-manager.domain') . '/api/management/content');
                    $items = $response->json();
                    foreach ($items as $item) {
                        if ($item['key'] == 'nav.service') {
                            $s = ' ';
                        }
                        $key = $item['key'];
                        if ($item['page'] != null) {
                            $key .= '.' . $item['page'];
                        }
                        if ($item['language'] != null) {
                            $key .= '.' . $item['language'];
                        }
                        if ($item['value'] !== null) {
                            Redis::set($app . '.' . $key, $item['value']);
                            Redis::set($app . '.id.' . $item['id'], $app . '.' . $key);
                        }
                    }
                    Redis::set($app . '.redis-set', true, (int) config('kcs-content-manager.expire'));
                }
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
