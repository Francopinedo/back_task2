<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Validator;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Muestra listado de usuarios
     */
    public function show()
    {
        $user = User::find(Auth::id());
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        if(!empty($company)){
            $res = $this->apiCall('GET', 'cities?company_id=' .$company->id);
	   }else{
	       $res = $this->apiCall('GET', 'cities');
	   }
        $cities = json_decode($res->getBody()->__toString())->data;
        $file='';
        if(Storage::disk('public')->has('users/profile/'.$user->id."/".$user->profile_image_path)){
            $file = Storage::disk('public')->url('app/public/users/profile/'.$user->id."/".$user->profile_image_path);

        }  

        if(Auth::user()->hasRole('admin')) {
            $res = $this->apiCall('GET', 'languages');
        }else{
            $res = $this->apiCall('GET', 'languages?company_id=' . $company->id);
        }
        $languages = json_decode($res->getBody()->__toString())->data;

        return view('profile/edit', [
            'cities' => $cities,
            'languages' => $languages,
            'user' => $user,
            'file' => $user->profile_image_path,//$file,
        ]);
    }

    /**
     * Form para editar
     */
    public function edit()
    {
        $user = User::find(Auth::id());
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $res = $this->apiCall('GET', 'cities?company_id=' . $company->id);
        $cities = json_decode($res->getBody()->__toString())->data;
        $file = Storage::disk('public')->get('app/public/users/profile/'.$user->id."/".$user->profile_image_path);

        $file = Storage::disk('public')->get('app/public/users/profile/'.$user->id."/".$user->profile_image_path);
        $res = $this->apiCall('GET', 'languages?company_id=' . $company->id);
        $languages = json_decode($res->getBody()->__toString())->data;
        return view('profile/edit', [
            'cities' => $cities,
            'file' => $user->profile_image_path,//$file,
            'user' => $user
        ]);
    }


    /**
     * Actualizo
     */
    public function update(Request $request)
    {
  	$user = User::find(Auth::id());
       
        

        $file = $request->file('profile_image_path');

        // validacion del formulario
        $validator =Validator::make($request->all(), [

            'name' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();
// dd($request->tooltip);

	   if(isset($data['tooltip']) && $data['tooltip']!=null )
           {
            $data['tooltip']='1';
           }else{
            $data['tooltip']='0';
           }
//return $data;
        $data['profile_image_path'] =($file!=null || $file!='') ? $file->getClientOriginalName() : $user->profile_image_path;
        $res = $this->apiCall('PATCH', 'users/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.users_store')]
            )->validate();
        } else {


            $destinationPath = "assets/img/users/profile/" . $data['id'].'/';
            // echo $file->getClientOriginalName();
	
            if($file!=null || $file!='') {
                $file->move(($destinationPath), $file->getClientOriginalName());

            }

            session()->flash('message', __('general.updated'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();
    }


    public function upload(Request $request, $id)
    {
        try {
            var_dump($request);
            $file = $request->file('profile_image_path');

            // validacion del formulario
            $validator =Validator::make($request->all(), [

                'profile_image_path' => 'required',
            ]);

            if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();
            $data['profile_image_path'] = !isNull($file) ? $file->getClientOriginalName() : '';
            //$res = $this->apiCall('PATCH', 'users/' . $id, $data);


            $destinationPath = "assets/img/users/profile/" . $id.'/';
            // echo $file->getClientOriginalName();
 	if($file!=null || $file!='') {
                $file->move(($destinationPath), $file->getClientOriginalName());

            }



        } catch (FileException $exception) {

            return response()->json(array('success' => false, 'message' => 'Error uplading file'));
        }

        return response()->json(array('success' => true));
    }


    /**
     * Elimina
     * @param  int $id ID
     */
    public function delete($id)
    {
        $res = $this->apiCall('DELETE', 'users/' . $id);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            session()->flash('message', __('api_errors.delete'));
            session()->flash('alert-class', 'danger');

            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.delete')]
            )->validate();

        } else {
            session()->flash('message', __('general.deleted'));
            session()->flash('alert-class', 'success');
        }

        return redirect()->action('UsersController@index');
    }
}
