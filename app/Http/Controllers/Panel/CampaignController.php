<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CampaignRequest;
use App\Models\Campaign;
use App\Models\CampaignDonor;
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
        $campaigns = $this->campaignModel->where('entity_id', auth()->user()->entity->id)->orderBy('created_at', 'DESC')->paginate(20);

        return view('panel.campaign.index', compact('campaigns'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $close_at  = \Carbon\Carbon::now()->addDays(90)->format('Y-m-d');

        return view('panel.campaign.create', compact('close_at'));
    }

    /**
     * @param CampaignRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CampaignRequest $request)
    {
        $data = $request->all();

        $close_at = \Carbon\Carbon::parse($request->get('close_at'))->format('Y-m-d');

        if ($close_at <= \Carbon\Carbon::now()->format('Y-m-d')) {
            return redirect()
                ->route('campaigns.create')
                ->with('error', 'Data de vencimento não pode ser menor ou igual a data atual!');
        }

        $imageName = md5(mt_rand()).'.'.$data['image']->getClientOriginalExtension();
        $data['image']->move(public_path('uploads/campaigns'), $imageName);
        \Image::make(public_path('uploads/campaigns/' . $imageName))->fit(config('app.upload_campaign_width'), config('app.upload_campaign_height'))->save(public_path('uploads/campaigns/' . $imageName));

        $data['entity_id'] = auth()->user()->entity->id;
        $data['image'] = $imageName;
        $data['amount_goal'] = preg_replace('/[^0-9]/', '', $data['amount_goal']) / 100;
        $data['status'] = 1;

        $campaign = $this->campaignModel->create($data);

        if (!$campaign) {
            return redirect()
                ->route('campaigns.create')
                ->with('error', 'Erro ao cadastrar campanha!');
        }

        return redirect()
            ->route('campaigns.index')
            ->with('success', 'Campanha cadastrada com sucesso!');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $campaign = $this->campaignModel->where('id', $id)->where('entity_id', auth()->user()->entity->id)->where('status', 1)->firstOrFail();

        return view('panel.campaign.edit', compact('campaign'));
    }

    /**
     * @param CampaignRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CampaignRequest $request, $id)
    {
        $campaign = $this->campaignModel->where('id', $id)->where('entity_id', auth()->user()->entity->id)->firstOrFail();
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
                ->route('campaigns.index')
                ->with('error', 'Erro ao atualizar campanha!');
        }

        return redirect()
            ->route('campaigns.index')
            ->with('success', 'Campanha atualizada com sucesso!');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $campaign = $this->campaignModel->where('id', $id)->where('entity_id', auth()->user()->entity->id)->firstOrFail();
        $donors = $campaign->donors()->orderBy('created_at', 'DESC')->orderBy('status', 'ASC')->paginate(20);

        return view('panel.campaign.show', compact('campaign', 'donors'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmDonation($id)
    {
        $entity_id = auth()->user()->entity->id;

        $donor = $this->campaignDonorModel->whereHas('campaign', function($q) use ($entity_id) {
            $q->where('entity_id', $entity_id);
        })->find($id);

        $donor->status = 2;
        $donor->confirmed_at = \Carbon\Carbon::now();
        $donor->save();

        return redirect()
            ->route('campaigns.show', [$donor->campaign_id])
            ->with('success', 'Pagamento confirmado com sucesso!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelDonation($id)
    {
        $entity_id = auth()->user()->entity->id;

        $donor = $this->campaignDonorModel->whereHas('campaign', function($q) use ($entity_id) {
            $q->where('entity_id', $entity_id);
        })->where('status', 1)->find($id);

        $donor->status = 3;
        $donor->save();

        return redirect()
            ->route('campaigns.show', [$donor->campaign_id])
            ->with('success', 'Pagamento cancelado com sucesso!');
    }
}
