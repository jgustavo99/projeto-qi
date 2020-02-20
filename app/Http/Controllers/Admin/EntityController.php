<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Http\Requests\Admin\EntityRequest;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    /**
     * @var Entity
     */
    public $entityModel;

    /**
     * EntityController constructor.
     *
     * @param Entity $entityModel
     */
    public function __construct(Entity $entityModel)
    {
        $this->entityModel = $entityModel;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $entities = $this->entityModel->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.entity.index', compact('entities'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $entity = $this->entityModel->find($id);

        return view('admin.entity.show', compact('entity'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $entity = $this->entityModel->find($id);

        $entity->user()->delete();
        $entity->delete();

        return redirect()
            ->route('entities.index')
            ->with('success', 'Entidade removida com sucesso!');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $entity = $this->entityModel->find($id);
        $ufs = \App\Models\State::select('abbr')->orderBy('abbr')->get();

        return view('admin.entity.edit', compact('entity', 'ufs'));
    }

    /**
     * @param EntityRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EntityRequest $request, $id)
    {
        $data = array_filter($request->all());
        $entity = $this->entityModel->find($id);

        $verifyDocument = \App\Models\Entity::where('document_type', $data['document_type'])->where('document', preg_replace('/[^0-9]/', '', $data['document']))->count();

        if ($verifyDocument != 0 and $data['document'] != $entity->document) {
            return redirect()
                ->route('entities.index')
                ->with('error', 'Já existe uma entidade com esse documento cadastrada!');
        }

        if (!empty($data['password'])) {
            $data['password'] = \Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (isset($data['image'])) {
            \File::delete(public_path('uploads/' . $entity->image));

            $imageName = md5(mt_rand()).'.'.$data['image']->getClientOriginalExtension();
            $data['image']->move(public_path('uploads/'), $imageName);
            \Image::make(public_path('uploads/' . $imageName))->fit(config('app.upload_width'), config('app.upload_height'))->save(public_path('uploads/' . $imageName));

            $data['image'] = $imageName;
        }

        $updateUser = $entity->user()->update(array_only($data, ['email', 'password']));
        $updateEntity = $entity->update(array_only($data, ['name', 'corporate_name', 'document', 'document_type', 'description_payment', 'phone', 'address', 'neighborhood', 'cep', 'city_id', 'image']));

        return redirect()
            ->route('entities.index')
            ->with('success', 'Dados atualizados com sucesso!');
    }
}
