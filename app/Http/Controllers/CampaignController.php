<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * @var Campaign
     */
    public $campaignModel;

    /**
     * HomeController constructor.
     *
     * @param Campaign $campaignModel
     */
    public function __construct(Campaign $campaignModel)
    {
        $this->campaignModel = $campaignModel;
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $slug)
    {
        $campaign = $this->campaignModel->has('entity')->where('slug', $slug)->where('status', 1)->firstOrFail();

        return view('campaign.show', compact('campaign'));
    }
}
