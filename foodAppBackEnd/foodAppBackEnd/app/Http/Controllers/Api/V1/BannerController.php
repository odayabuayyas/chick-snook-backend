<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Banner;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getBanners(): JsonResponse
    {
        $banners = Banner::with(['product.rating','product.branch_product'])->active()->get();
        foreach($banners as $banner){
            $banner['product'] = isset($banner['product']) ? Helpers::product_data_formatting($banner['product']) : null;
        }

        return response()->json($banners, 200);
    }
}
