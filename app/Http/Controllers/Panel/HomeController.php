<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\CampaignDonor;
use App\Models\Campaign;

class HomeController extends Controller
{
    /**
     * @var CampaignDonor
     */
    public $campaignDonorModel;

    /**
     * @var Campaign
     */
    public $campaignModel;

    /**
     * HomeController constructor.
     *
     * @param CampaignDonor $campaignDonor
     * @param Campaign $campaignModel
     */
    public function __construct(CampaignDonor $campaignDonor, Campaign $campaignModel)
    {
        $this->campaignDonorModel = $campaignDonor;
        $this->campaignModel = $campaignModel;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (auth()->user()->is_entity == 0) {
            $confirmed_donations = $this->campaignDonorModel->where('user_id', auth()->user()->id)->where('status', 2)->count();
            $pending_donations = $this->campaignDonorModel->where('user_id', auth()->user()->id)->where('status', 1)->count();

            $data = [
                'confirmed_donations' => $confirmed_donations,
                'pending_donations' => $pending_donations
            ];
        } else {
            $total_campaign = $this->campaignModel->where('entity_id', auth()->user()->entity->id)->where('status', 1)->count();
            $campaign_current = $this->campaignModel->where('entity_id', auth()->user()->entity->id)->where('status', 1)->orderBy('created_at', 'DESC')->first();

            if (!$campaign_current) {
                $total = 0.00;
            } else {
                $total = $this->campaignDonorModel->where('campaign_id', $campaign_current->id)->where('status', 2)->sum('amount');
            }
            $data = [
                'total_campaign' => $total_campaign,
                'total' => $total
            ];
        }

        return view('panel.home', compact('data'));
    }
}
