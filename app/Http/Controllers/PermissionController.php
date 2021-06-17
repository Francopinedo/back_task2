<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=industry,city,currency');

    	$companyRoles = $this->getFromApi('GET', 'company_roles?company_id='.$company->id.
            '&include[]=role.permissionRoles.permission&include[]=role.directoryRoles.directory');
    	$permissions = $this->getFromApi('GET', 'permissions');
    	$directories = $this->getFromApi('GET', 'directories');

    	// creo un array con los IDs de los permisos activos por cada company_role
    	$activePermissionsIds = [];
    	$activeDirectoriesIdsRead = [];
    	$activeDirectoriesIdsWrite = [];
    	foreach ($companyRoles as $companyRole)
    	{
    		foreach ($companyRole->role->data->permissionRoles->data as $permissionRole)
    		{
    			if (!empty($permissionRole))
    			{
    				$activePermissionsIds[$companyRole->id][] = $permissionRole->permission->data->id;
    			}
    		}

            foreach ($companyRole->role->data->directoryRoles->data as $directoryRoles)
            {
                if (!empty($directoryRoles))
                {
                    if(isset($directoryRoles->write) && $directoryRoles->write==1){
                        $activeDirectoriesIdsWrite[$companyRole->id][] = $directoryRoles->directory->data->id;
                    }
                    if(isset($directoryRoles->read) &&$directoryRoles->read==1){
                        $activeDirectoriesIdsRead[$companyRole->id][] = $directoryRoles->directory->data->id;
                    }

                }
            }
    	}


    	$final_directories=array();
        $finalfolders=array();
        $finalsubfolders=array();
    	//var_dump($directories);
    	foreach ($directories as $directory){

            $dir = (Array) $directory;
            $folders= $this->getFromApi('GET', 'directories?parent='.$directory->id);

            foreach ($folders as $folder){
                $fold = (Array) $folder;

                $subfolders= $this->getFromApi('GET', 'directories?parent='.$folder->id);

                foreach ($subfolders as $subfolder) {
                    $subfold = (Array)$subfolder;

                    array_push($finalsubfolders, $subfold);
                }

                $fold['subfolders']=$finalsubfolders;

                array_push($finalfolders, $fold);

            }
            $dir['folders']=$finalfolders;

            array_push($final_directories,$dir);
        }

        return view('permission/index', [
        	'companyRoles' => $companyRoles,
        	'directories' => $final_directories,
        	'permissions'  => $permissions,
        	'activePermissionsIds'  => $activePermissionsIds,
        	'activeDirectoriesIdsWrite'  => $activeDirectoriesIdsWrite,
        	'activeDirectoriesIdsRead'  => $activeDirectoriesIdsRead
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$city = $this->getFromApi('GET', 'cities/'.$id);

    	$res = $this->apiCall('GET', 'countries');
    	$countries = json_decode($res->getBody()->__toString())->data;

    	return response()->json([
    		'view' => view('city/edit', ['city' => $city, 'countries' => $countries] )->render()
    	]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'name'       => 'required',
			'location_name'   => 'required',
			'country_id' => 'required'
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('POST', 'cities', $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.city_store')]
	    	)->validate();
    	}
    	else
    	{
    		session()->flash('message', __('general.added'));
			session()->flash('alert-class', 'success');
    	}

    	return response()->json();
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'name'     => 'required',
			'location_name'   => 'required',
			'country_id' => 'required'
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'cities/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.city_store')]
	    	)->validate();
    	}
    	else
    	{
    		session()->flash('message', __('general.updated'));
			session()->flash('alert-class', 'success');
    	}

    	return response()->json();
    }

    /**
     * Elimina
     * @param  int $id ID
     */
    public function delete($id)
    {
    	$res = $this->apiCall('DELETE', 'cities/'.$id);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	session()->flash('message', __('api_errors.delete'));
			session()->flash('alert-class', 'danger');

	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.delete')]
	    	)->validate();

    	}
    	else
    	{
    		session()->flash('message', __('general.deleted'));
			session()->flash('alert-class', 'success');
    	}

    	return redirect()->action('CityController@index');
    }
}
