<?php

namespace App\Http\Controllers;

use App\Models\Deals;
use App\Models\Venues;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return Application|Factory|View
     */
    public function __invoke(): View|Factory|Application
    {
        $flag  = auth()->user()->isAdmin();
        $venueId = null;
        if(auth()->user()->isUser())
        {
            $venueId  = Venues::geVenueByUserId(auth()->id())->venueId;
        }
        $activeVenuesCount = $this->getActiveVenuesCount($flag);
        $inactiveVenuesCount = $this->getInactiveVenuesCount($flag);
        $dealCount = $this->getDealsCount($venueId);
        return view('template.admin.dashboard', compact('activeVenuesCount','inactiveVenuesCount','dealCount'));
    }

    /**
     * @param bool $flag
     * @return mixed
     */
    private function getActiveVenuesCount(bool $flag): mixed
    {
        if($flag)
        {
            return Venues::where('venueStatus',true)->count();
        }
        return [];
    }

    /**
     * @param bool $flag
     * @return mixed
     */
    private function getInactiveVenuesCount(bool $flag): mixed
    {
        if ($flag)
        {
            return Venues::where('venueStatus',false)->count();
        }
        return [];
    }

    /**
     * @param int|null $venueId
     * @return mixed
     */
    private function getDealsCount(int $venueId = null): mixed
    {
        if ($venueId)
        {
            return Deals::dealCountByVenueId($venueId);
        }
        return Deals::count();
    }
}
