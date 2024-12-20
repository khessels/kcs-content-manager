<?php

namespace App\Providers;

use App\Models\Content;
use http\Client;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Lang;
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

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // get all the content from the server and populate redis
        try {
            $this->app = config('kcs-content-manager.app');
            $path = storage_path('app/kcs-content-manager.resources.' . Lang::locale());
            try{
                $content = file_get_contents( $path );
            }catch(\Exception $e){
                $content = "[]";
            }
            Blade::directive('c', function (string $expression) use ( $content) {
                return "<?php echo \App\Http\Controllers\ContentController::translate(  $expression, '" . $content . "'); ?>";
            });
        }catch( \Exception $e ) {
            error_log($e->getMessage());
        }
    }
}
