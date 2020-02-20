<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\ProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $ufs = \App\Models\State::select('abbr')->orderBy('abbr')->get();

        return view('panel.profile', compact('user', 'ufs'));
    }

    /**
     * @param ProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        if (!auth()->user()->is_entity) {
            $data = $request->all();

            if (!empty($data['password'])) {
                $data['password'] = \Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $update = auth()->user()->update(array_except($data, ['document']));

            return redirect()
                ->route('profile')
                ->with('success', 'Dados atualizados com sucesso!');
        } else {
            $data = $request->all();

            if (!empty($data['password'])) {
                $data['password'] = \Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            if (isset($data['image'])) {
                \File::delete(public_path('uploads/' . auth()->user()->entity->image));

                $imageName = md5(mt_rand()).'.'.$data['image']->getClientOriginalExtension();
                $data['image']->move(public_path('uploads/'), $imageName);
                \Image::make(public_path('uploads/' . $imageName))->fit(config('app.upload_width'), config('app.upload_height'))->save(public_path('uploads/' . $imageName));

                $data['image'] = $imageName;
            }

            $updateUser = auth()->user()->update(array_only($data, ['email', 'password']));
            $updateEntity = auth()->user()->entity->update(array_only($data, ['name','description_payment', 'phone', 'address', 'neighborhood', 'cep', 'city_id', 'image']));

            return redirect()
                ->route('profile')
                ->with('success', 'Dados atualizados com sucesso!');
        }
    }
}
