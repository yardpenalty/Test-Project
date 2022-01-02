<?php

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopperQueueController extends Controller
{
    /**
     * @var StoreService
     */
    protected $store;

    /**
     * @var LocationService
     */
    protected $location;

    /**
     * @var UserService
     */
    protected $shopper;

    /**
     * StoreController constructor.
     * @param StoreService $store
     * @param LocationService $location
     * @param ShopperService $shopper
     */
    public function __construct(StoreService $store,LocationService $location, ShopperService $shopper)
    {
        $this->store = $store;
        $this->shopper = $shopper;

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = $this->user->show(
            [
                'id' => Auth::user()->id
            ],
            ['Stores']
        );

        return view('stores.index')
            ->with('stores', $user['stores'] ?? null);
    }
    /**
     * @param Location $location
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function public(Location $location)
    {
        return view('stores.location.public')
            ->with('location', $location);
    }
	
     /**
     * @param LocationStoreRequest $request
     * @param string $storeUuid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LocationStoreRequest $request, string $storeUuid): \Illuminate\Http\RedirectResponse
    {
        $this->location->create([
            'location_name' => $request->location_name,
            'shopper_limit' => $request->shopper_limit,
            'store_id' => $storeUuid
        ]);

        return redirect()->route('store.store', ['store' => $storeUuid]);
    }

    /**
     * @param LocationQueueRequest $request
     * @param string $storeUuid
     * @param string $locationUuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function queue(LocationQueueRequest $request, string $storeUuid, string $locationUuid)
    {
        $location = $this->location->show(
            [
                'uuid' => $locationUuid
            ],
            [
                'Shoppers',
                'Shoppers.Status'
            ]
        );

        $shoppers = null;

        if( isset($location['shoppers']) && count($location['shoppers']) >= 1 ){
            $shoppers = $this->location->getShoppers($location['shoppers']);
        }

        return view('stores.location.queue')
            ->with('location', $location)
            ->with('shoppers', $shoppers);
    }
}
