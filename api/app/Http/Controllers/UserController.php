<?php

namespace App\Http\Controllers;

use App\Events\UserRegisteredEvent;
use App\Models\CompanyUser;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Company;
use App\Models\CompanyRole;
use App\Models\PermissionRole;
use DB;
use Illuminate\Http\Request;
use Transformers\UserTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de usuarios
 *
 * @Resource("Group User")
 */
class UserController extends Controller
{

    /**
     * Obtener usuarios
     *
     * @Get("users{?company_id,with_office}")
     * @Parameters({
     *      @Parameter("company_id", type="integer", required=true, description="ID de una compañia", default=null),
     *      @Parameter("with_office", type="integer", required=false, description="0 para todos, 1 para los que tienen oficina", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "name": "string",
     *            "email": "string",
     *            "address": "string",
     *            "office_phone": "string",
     *            "home_phone": "string",
     *            "cell_phone": "string",
     *            "country_id": 'int',
     *            "city_id": "int",
     *            "profile_image_path": "string",
     *            "office_id": "int"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = User::select('users.id', 'users.name', 'users.email', 'users.address', 'users.office_phone',
            'users.home_phone', 'users.cell_phone', 'users.country_id', 'users.city_id', 'users.profile_image_path', 'users.office_id');

        if ($request->has('company_id')) {
            $query->join('company_users', 'company_users.user_id', '=', 'users.id');
            $query->where('company_users.company_id', $request->company_id);
            $query->whereNotNull('users.workgroup_id');
        }

        if ($request->has('with_office') && $request->with_office == '1') {
            $query->whereNotNull('users.office_id');
        }


 if ($request->has('name')) {
            $query->whereRaw('lower(`name`) like ?',$request->name);
        }


 if ($request->has('email')) {
            $query->where('users.email', $request->email);
        }
       

        if ($request->has('office_id')) {
            $query->where('users.office_id', $request->office_id);
        }

        if ($request->has('city_id')) {
            $query->where('users.city_id', $request->city_id);
        }
        if ($request->has('company_role_id')) {
            $query->where('users.company_role_id', $request->company_role_id);
        }

        if ($request->has('project_role_id')) {
            $query->where('users.project_role_id', $request->project_role_id);
        }


        if ($request->has('seniority_id')) {
            $query->where('users.seniority_id', $request->seniority_id);
        }


        if ($request->has('workplace')) {
            $query->where('users.workplace', $request->workplace);
        }

        if ($request->has('project_id')) {
            $query->join('team_users', 'team_users.user_id', '=', 'users.id');
            $query->where('team_users.project_id', $request->project_id);
        }

        if ($request->has('role_name')) {
            $query->join('project_roles', 'project_roles.id', '=', 'users.project_role_id');
            $query->where('project_roles.title', $request->role_name);
        }

        $users = $query->get();

        return $this->response->collection($users, new UserTransformer);
    }

      public
    function index_export(Request $request)
    {
        $query = DB::table('users')
            ->select(
                'users.name', 'users.email', 'users.address', 'users.office_phone',
                'users.home_phone', 'users.cell_phone', 'countries.name AS country_name',
                'cities.name AS city_name', 'offices.title AS office_name', 'company_roles.title AS role_name',
                'project_roles.title AS project_role_name',
                'seniorities.title as seniority', 'offices.hours_by_day',
                 'users.workplace',
                'workgroups.title AS workgroup_title', 'roles.slug')
            ->leftjoin('countries', 'countries.id', '=', 'users.country_id')
            ->leftjoin('cities', 'cities.id', '=', 'users.city_id')
            ->leftjoin('offices', 'offices.id', '=', 'users.office_id')
            ->leftjoin('seniorities', 'seniorities.id', '=', 'users.seniority_id')
            ->leftjoin('company_roles', 'company_roles.id', '=', 'users.company_role_id')
            ->leftjoin('project_roles', 'project_roles.id', '=', 'users.project_role_id')
            ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftjoin('roles', 'role_user.role_id', '=', 'roles.id')
            ->leftjoin('workgroups', 'workgroups.id', '=', 'users.workgroup_id');

        if ($request->has('company_id')) {
            $query->join('company_users', 'company_users.user_id', '=', 'users.id');
            $query->where('company_users.company_id', $request->company_id);
            $query->whereNotNull('users.workgroup_id');
        }


        if ($request->has('user_id') && $request->user_id == 'false') {
            $query->where('roles.slug', '<>', 'admin');

            $query->whereNull('users.user_id');

        }

        $users = $query->get();

          return response()->json(array('data' => $users));
    }

    /**
     * Crear usuario
     *
     * @Post("users")
     * @Request({
     *      "name": "string",
     *      "email": "string",
     *      "password": "string",
     *      "address": "string",
     *        "office_phone": "string",
     *        "home_phone": "string",
     *        "cell_phone": "string",
     *        "country_id": "int",
     *        "city_id": "int",
     *        "profile_image_path": "string (opt)"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "name": "string",
     *            "email": "string",
     *            "address": "string",
     *            "office_phone": "string",
     *            "home_phone": "string",
     *            "cell_phone": "string",
     *            "country_id": "int",
     *            "city_id": "int",
     *            "profile_image_path": "string"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear el usuario"}})
     * })
     */
    public
    function store(Request $request)
    {
        if (!$request->has('name') || !$request->has('email') || !$request->has('password')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();
        $data['password'] = app('hash')->make($data['password']);

        $user = User::create($data);

        if ($user) {
            if (!$request->has('company_id')) {
                event(new UserRegisteredEvent($user));
            } else {

                CompanyUser::create(['company_id' => $request->company_id, 'user_id' => $user->id]);

                if ($request->has('company_role_id') && !empty($request->company_role_id)) {

                    $role = Role::where('company_role_id', $request->company_role_id)->first();
                    RoleUser::create(['role_id' => $role->id, 'user_id' => $user->id]);
                }
            }
            return $this->response->item($user, new UserTransformer);
        } else {
            return $this->response->error('Error al crear el usuario', 451);
        }
    }
    public
    function storeAdmin(Request $request)
    {
        if (!$request->has('name')) {
            return $this->response->error('Faltan datos', 450);
        }

        $name = $request->name;
        $company = Company::where('name','=',$name)->firstOrFail();
        $domain = $company->domain;
        $mail = $domain->mails->first();
        $rcuser = $company->RocketChatUsers->first();
        $address = $request->address;
        $password = $name.date('dd.mm.yyyy');
        $passwordHashed = app('hash')->make('secret');
        /*
         * Create admin en base al nombre de la comania
         * nombre:"comania"Admin
         * direccion:direccion de la compania
         * mail:mail de iredmail previamente autogenerado
         * telefonos: los de la compania
         * password: secret
         */
        $user = new User();
        $user->name = $name." Admin";
        $user->address = $address;
        $user->email = $mail->mail;
        $user->office_phone = $request->phone;
        $user->home_phone = $request->phone;
        $user->cell_phone = $request->phone;
        $user->password = $passwordHashed;
        $user->save();
        //setea el mainuser del la compania
        $company->user_id = $user->id;
        $company->save();
        //crea relacion entre la compania y el usuario
        CompanyUser::create(['company_id' => $company->id, 'user_id' => $user->id]);
        //selecciona el companyRole en base al id de la compania y al titulo del rol
        $companyRole = CompanyRole::where('company_id',$company->id)->where('title','Admin')->firstOrFail();
        //selecciona el rol del usuario en base al id del companyrol
        $role = Role::where('company_role_id',$companyRole->id)->firstOrFail();
        //crea relacion entre el rol y el usuario
        RoleUser::create(['role_id' => 3, 'user_id' => $user->id]);
        //vincula el mail de iredmail con el usuario
        $adminRules = [1,2,14,13,12,11,10,9,8,7,6,5,4,3,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,34];


        foreach ($adminRules as $rule)
        {
            PermissionRole::create(['permission_id' => $rule,'role_id' => $role->id]);
        }
        $mail->user_id = $user->id;
        $mail->save();

        $rcuser->user_id = $user->id;
        $rcuser->save();



        if(!$user)
        {
            return $this->response->error('Error al crear el usuario', 451);
        }
        else
        {
            return $this->response->item($user, new UserTransformer);
        }
    }

    /**
     * Obtener usuarios
     *
     * @Get("users/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID del usuario", default=1),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "name": "string",
     *            "email": "string",
     *            "address": "string",
     *            "office_phone": "string",
     *            "home_phone": "string",
     *            "cell_phone": "string",
     *            "country_id": "int",
     *            "city_id": "int",
     *            "profile_image_path": "string"
     *    })
     * })
     */
    public
    function show($id)
    {
        $user = User::where('users.id','=',$id)->leftJoin('cities', 'cities.id', '=', 'users.city_id')
            ->leftJoin('countries', 'countries.id', '=', 'cities.country_id')->first(['users.*', 'countries.id as country_id']);

        return $this->response->item($user, new UserTransformer);
    }

    /**
     * Editar usuario
     *
     * @Patch("users/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *      "name": "string",
     *      "email": "string",
     *      "password": "string",
     *      "address": "string",
     *        "office_phone": "string",
     *        "home_phone": "string",
     *        "cell_phone": "string",
     *        "country_id": "int",
     *        "city_id": "int",
     *        "profile_image_path": "string (opt)",
     *        "company_role_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "name": "string",
     *            "email": "string",
     *            "address": "string",
     *            "office_phone": "string",
     *            "home_phone": "string",
     *            "cell_phone": "string",
     *            "country_id": "int",
     *            "city_id": "int",
     *            "profile_image_path": "string"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe el usuario"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar el usuario"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public
    function update(Request $request, $id)
    {
        $user = User::find($id);

        if ($user == NULL) {
            return $this->response->error('No existe el usuario', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        if (!empty($data['password'])) {
            $data['password'] = app('hash')->make($data['password']);
        }

        $user->update($data);

        if ($user) {
            if ($request->has('company_role_id')) {
                $role = Role::where('company_role_id', $request->company_role_id)->first();
                if (is_object($role) && isset($role->id)) {
                    $roleUser = RoleUser::where('user_id', $user->id)->first();
                    if (is_object($roleUser)) {
                        $roleUser->update(['role_id' => $role->id]);
                    } else {

                        RoleUser::create(['role_id' => $role->id, 'user_id' => $user->id]);
                    }

                }

            }
            return $this->response->item($user, new UserTransformer);
        } else {
            return $this->response->error('Error al editar el usuario', 451);
        }
    }

    /**
     * Elimina un usuario
     *
     * @Delete("users/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID del usuario.", default=null),
     * })
     * @Transaction({
     *   	@Response(204),
     *   	@Response(460, body={"error": {"message": "No existe la imagen que se quiere destruir"}})
     * })
     */
    public
    function destroy($id)
    {
        $user = User::find($id);

        if ($user == NULL) {
            return $this->response->error('No existe el usuario', 450);
        }
//return $user;
        $user->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener usuarios
     *
     * Con formato listo para datatables con ajax
     * @Get("users/datatables{?company_id}")
     * @Parameters({
     *      @Parameter("company_id", type="integer", required=true, description="ID de una compañia", default=null),
     * })
     */
    public
    function datatables(Request $request)
    {
        $query = DB::table('users')
            ->select(
                'users.id', 'users.name', 'users.email', 'users.address', 'users.office_phone',
                'users.home_phone', 'users.cell_phone', 'users.country_id', 'users.city_id', 'users.profile_image_path', 'countries.name AS country_name',
                'cities.name AS city_name', 'offices.title AS office_name', 'company_roles.title AS role_name',
                'project_roles.title AS project_role_name',
                'seniorities.title as seniority', 'offices.hours_by_day', 'users.workplace', 'users.timezone',
                'workgroups.title AS workgroup_title', 'roles.slug')
            ->leftjoin('countries', 'countries.id', '=', 'users.country_id')
            ->leftjoin('cities', 'cities.id', '=', 'users.city_id')
            ->leftjoin('offices', 'offices.id', '=', 'users.office_id')
            ->leftjoin('seniorities', 'seniorities.id', '=', 'users.seniority_id')
            ->leftjoin('company_roles', 'company_roles.id', '=', 'users.company_role_id')
            ->leftjoin('project_roles', 'project_roles.id', '=', 'users.project_role_id')
            ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftjoin('roles', 'role_user.role_id', '=', 'roles.id')
            ->leftjoin('workgroups', 'workgroups.id', '=', 'users.workgroup_id');

        if ($request->has('company_id') && $request->company_id != '') {
            $query->join('company_users', 'company_users.user_id', '=', 'users.id');
            $query->where('company_users.company_id', $request->company_id);

        }


        if ($request->has('user_id') && $request->user_id == 'false') {
            $query->where('roles.slug', '<>', 'admin');

            $query->whereNull('users.user_id');

        }

        $users = $query->get();

        return Datatables::of($users)->make(true);
    }

}

?>
