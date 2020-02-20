<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\CampaignDonor;
use App\Models\Campaign;
use App\Http\Requests\Panel\DonateRequest;
use Illuminate\Http\Request;

class DonationController extends Controller
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
     * DonationController constructor.
     *
     * @param CampaignDonor $campaignDonorModel
     * @param Campaign $campaignModel
     */
    public function __construct(CampaignDonor $campaignDonorModel, Campaign $campaignModel)
    {
        $this->campaignDonorModel = $campaignDonorModel;
        $this->campaignModel = $campaignModel;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $donors = $this->campaignDonorModel->where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->orderBy('status', 'ASC')->paginate(20);

        return view('panel.donor.index', compact('donors'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function donateView($slug)
    {
        $campaign = $this->campaignModel->has('entity')->where('slug', $slug)->where('status', 1)->firstOrFail();

        return view('panel.donor.donate', compact('campaign'));
    }

    /**
     * @param DonateRequest $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function donate(DonateRequest $request, $slug)
    {
        $campaign = $this->campaignModel->has('entity')->where('slug', $slug)->where('status', 1)->firstOrFail();

        $create = $this->campaignDonorModel->create([
            'campaign_id' => $campaign->id,
            'user_id' => auth()->user()->id,
            'status' => 1,
            'amount' => preg_replace('/[^0-9]/', '', $request->get('amount')) / 100
        ]);

        return redirect()
            ->route('donations.index')
            ->with('donate', "Operação realizada com sucesso! <br/> Instruções de pagamento: <br/>" . nl2br(e($campaign->entity->description_payment)));
    }
}
