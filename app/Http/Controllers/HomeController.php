<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->get('termo')) {
            $campaigns = $this->campaignModel
                ->has('entity')
                ->where(function ($query) use ($request) {
                    $query->where('title', 'LIKE', '%'.$request->get('termo').'%')
                    ->orWhere(function ($queryOR) use ($request) {
                        $queryOR->whereHas('entity', function ($querySql) use ($request) {
                            $querySql->where("name", "LIKE", "%{$request->get('termo')}%");
                        });
                    });
                })
                ->where('status',1)
                ->orderBy('created_at', 'DESC')
                ->paginate(9, ['*'], 'pagina');
        } else {
            $campaigns = $this->campaignModel->has('entity')->where('status',1)->orderBy('created_at', 'DESC')->paginate(9, ['*'], 'pagina');
        }

        return view('home.index', compact('campaigns'));
    }
}
