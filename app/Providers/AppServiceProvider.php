<?php

namespace App\Providers;
use App\Http\View\Composers\FooterComposer;
use App\Http\View\Composers\HeaderComposer;
use App\Http\View\Composers\MenuHomePageComposer;
use App\Model\Admin\Banner;
use Illuminate\Support\Facades\Schema; //SoftDelete
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use DB;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.env') != 'local') {
            URL::forceScheme('https');
        }

        $config = \App\Model\Admin\Config::with(['image','image_back','favicon'])->where('id',1)->first();
        $banners = Banner::query()->with('image')->latest()->get();
        view()->share('config', $config);
        view()->share('banners', $banners);

        // \Illuminate\Database\Query\Builder::macro('toRawSql', function(){
		// 	return array_reduce($this->getBindings(), function($sql, $binding){
		// 		return preg_replace('/\?/', is_numeric($binding) ? $binding : "'".$binding."'" , $sql, 1);
		// 	}, $this->toSql());
		// });

		// \Illuminate\Database\Eloquent\Builder::macro('toRawSql', function(){
		// 	return ($this->getQuery()->toRawSql());
		// });

        View::composer(
            'site.partials.header',
            MenuHomePageComposer::class
        );

        View::composer(
            'site.partials.mobile_menu',
            MenuHomePageComposer::class
        );

        View::composer(
            'site.index',
            MenuHomePageComposer::class
        );

        View::composer(
            'site.partials.footer',
            FooterComposer::class
        );

        View::composer(
            'site.contact_us',
            FooterComposer::class
        );

        View::composer(
            'site.partials.before_footer',
            FooterComposer::class
        );

        View::composer(
            'site.partials.header',
            HeaderComposer::class
        );

        View::composer(
            'site.partials.footer',
            HeaderComposer::class
        );

        View::composer(
            'site.layouts.master',
            HeaderComposer::class
        );
    }
}
