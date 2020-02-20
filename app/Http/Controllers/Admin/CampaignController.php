<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignDonor;
use App\Http\Requests\Admin\CampaignRequest;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * @var Campaign
     */
    public $campaignModel;

    /**
     * @var CampaignDonor
     */
    public $campaignDonorModel;

    /**
     * CampaignController constructor.
     *
     * @param Campaign $campaignModel
     * @param CampaignDonor $campaignDonorModel
     */
    public function __construct(Campaign $campaignModel, CampaignDonor $campaignDonorModel)
    {
        $this->campaignModel = $campaignModel;
        $this->campaignDonorModel = $campaignDonorModel;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $campaigns = $this->campaignModel->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.campaign.index', compact('campaigns'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $campaign = $this->campaignModel->find($id);

        return view('admin.campaign.show', compact('campaign'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmDonation($id)
    {
        $donor = $this->campaignDonorModel->find($id);

        $donor->status = 2;
        $donor->confirmed_at = \Carbon\Carbon::now();
        $donor->save();

        return redirect()
            ->route('admin.campaigns.show', [$donor->campaign_id])
            ->with('success', 'Pagamento confirmado com sucesso!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelDonation($id)
    {
        $donor = $this->campaignDonorModel->find($id);

        $donor->status = 3;
        $donor->save();

        return redirect()
            ->route('admin.campaigns.show', [$donor->campaign_id])
            ->with('success', 'Pagamento cancelado com sucesso!');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $campaign = $this->campaignModel->find($id);

        return view('admin.campaign.edit', compact('campaign'));
    }

    /**
     * @param CampaignRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CampaignRequest $request, $id)
    {
        $campaign = $this->campaignModel->find($id);
        $data = $request->all();

        $close_at = \Carbon\Carbon::parse($request->get('close_at'))->format('Y-m-d');

        if ($close_at <= \Carbon\Carbon::now()->format('Y-m-d')) {
            return redirect()
                ->route('campaigns.create')
                ->with('error', 'Data de vencimento não pode ser menor ou igual a data atual!');
        }

        if (isset($data['image'])) {
            \File::delete(public_path('uploads/campaigns/' . $campaign->image));

            $imageName = md5(mt_rand()).'.'.$data['image']->getClientOriginalExtension();
            $data['image']->move(public_path('uploads/campaigns/'), $imageName);
            \Image::make(public_path('uploads/campaigns/' . $imageName))->fit(config('app.upload_campaign_width'), config('app.upload_campaign_height'))->save(public_path('uploads/campaigns/' . $imageName));
            $data['image'] = $imageName;
        }

        $data['amount_goal'] = preg_replace('/[^0-9]/', '', $data['amount_goal']) / 100;

        $update = $campaign->update($data);

        if (!$update) {
            return redirect()
                ->route('admin.campaigns.index')
                ->with('error', 'Erro ao atualizar campanha!');
        }

        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'Campanha atualizada com sucesso!');
    }
}
