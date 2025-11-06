<?php

namespace App\Http\View\Composers;

use App\Model\Admin\Category;
use App\Model\Admin\CategorySpecial;
use App\Model\Admin\Config;
use App\Model\Admin\PostCategory;
use App\Model\Admin\Product;
use App\Model\Admin\Store;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeaderComposer
{
    /**
     * Compose Settings Menu
     * @param View $view
     */
    public function compose(View $view)
    {
        $config = Config::query()->get()->first();
        $cartItems = \Cart::session('cartList')->getContent();
        $totalPriceCart = \Cart::session('cartList')->getTotal();

        // danh mục sản phẩm
        $categories = Category::query()->with('childs')
            ->where('parent_id', 0)
            ->where('show_menu', 1)
            ->orderBy('sort_order')->get();

        $categorySpecial  = CategorySpecial::query()->orderBy('order_number')->get();

        // danh mục blog
        $postsCategory = PostCategory::query()
            ->where('type', PostCategory::TYPE_POST)
            ->where('parent_id', 0)->orderBy('sort_order')->get();

        $wishlistItems = \Cart::session('wishlist')->getContent();

        $view->with(['config' => $config, 'cartItems' => $cartItems,
            'totalPriceCart' => $totalPriceCart,
            'categories' => $categories, 'postsCategory' => $postsCategory,
            'categorySpecial' => $categorySpecial,
            'wishlistItems' => $wishlistItems
        ]);
    }
}
