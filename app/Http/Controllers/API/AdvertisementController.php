<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function getAllAdvertisements(Request $request)
    {
        $company = $request->user()->company;
        $advertisements = $company->advertisements()->get();

        $advertisements->transform(function ($advertisement) {
            return $advertisement->makeHidden([
                'created_at',
                'updated_at',
                'laravel_through_key',
                'user_id'
            ]);
        });

        return response()->json([
            'advertisements' => $advertisements,
        ]);
    }

    public function getAdvertisement(Request $request, int $advertisementId)
    {
        $company = $request->user()->company;
        $advertisement = $company->advertisements()->findOrFail($advertisementId);

        $advertisement->makeHidden([
            'created_at',
            'updated_at',
            'laravel_through_key',
            'user_id'
        ]);

        return response()->json([
            'advertisement' => $advertisement,
        ]);
    }
}
