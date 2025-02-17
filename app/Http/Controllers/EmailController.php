<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Mail;
use Illuminate\Mail\Mailable;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel']);
    }

    /**
     * Muestra detalle del registro
     * @param  int $id ID
     */
    public function index(Request $request)
    {
        $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=industry,city,currency');
        $contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);
        $providers = $this->getFromApi('GET', 'providers?company_id='.$company->id);
        $customers = $this->getFromApi('GET', 'customers?company_id='.$company->id);
        $users = $this->getFromApi('GET', 'users?company_id='.$company->id);
        $emailCategories=[];
        if(is_object($company)) {
            $emailCategories = $this->getFromApi('GET', 'email_categories?company_id=' . $company->id . '&include=emails');

        }
        $toSend = array('contacts' => $contacts,'providers' => $providers,'customers' => $customers,'users' => $users);
        $user = $this->getFromApi('GET','users/'.Auth::id());
        $theme = $user->theme;
        if($request->host)
        {
            $clientKey = isset($user->IredMailMail)? $user->IredMailMail->mail:'';
            $secretKey = isset($user->IredMailMail)? $user->IredMailMail->secret:'';
                $taskcontrolId = Auth::id();
            $imapHost = urlencode($request->host);
            $hostKey = env('IREDMAIL_API_HOST');
            $tcApiHost = env('API_PATH');

            return view('email.index',[
                'clientKey' => $clientKey,
                'secretKey' => $secretKey,
                'hostKey' => $hostKey,
                'tcApiHost' => $tcApiHost,
                'imapHost' => $imapHost,
                'userIdKey' => $taskcontrolId,
                'contacts' => $toSend,
                'selectedtheme'  => $theme,
                'company' => $company,
                'emailCategories' => $emailCategories,
                'contacts' => $contacts,
                'toSend' => $toSend,
                'providers' => $providers,
                'customers' => $customers,
                'users' => $users

            ]);
        }
        else
        {
            $clientKey = isset($user->IredMailMail)? $user->IredMailMail->mail:'';
            $secretKey = isset($user->IredMailMail)? $user->IredMailMail->secret:'';
            
            $taskcontrolId = Auth::id();
            $hostKey = env('IREDMAIL_API_HOST');
            $tcApiHost = env('API_PATH');


            return view('email.index',[
                'clientKey' => $clientKey,
                'secretKey' => $secretKey,
                'hostKey' => $hostKey,
                'tcApiHost' => $tcApiHost,
                'userIdKey' => $taskcontrolId,
                'contacts' => $toSend,
                'selectedtheme'  => $theme,
                'company' => $company,
                'emailCategories' => $emailCategories,
                'contacts' => $contacts,
                'toSend' => $toSend,
                'providers' => $providers,
                'customers' => $customers,
                'users' => $users
            ]);
        }
    }
    public function templates()
    {
        // dd(Auth::id());
        $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=industry,city,currency');
        $contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);
        $providers = $this->getFromApi('GET', 'providers?company_id='.$company->id);
        $customers = $this->getFromApi('GET', 'customers?company_id='.$company->id);
        $users = $this->getFromApi('GET', 'users?company_id='.$company->id);

        $emailCategories=[];
        if(is_object($company)) {
            $emailCategories = $this->getFromApi('GET', 'email_categories?company_id=' . $company->id . '&include=emails');

        }
        return view('email/templates', [
            'company' => $company,
            'emailCategories' => $emailCategories,
            'contacts' => $contacts,
            'providers' => $providers,
            'customers' => $customers,
            'users' => $users
        ]);
    }

   public function store(Request $request)
   {
   		// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'title'             => 'required',
			'email_category_id' => 'required',
			'subject'           => 'required',
			'body'              => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'emails', $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.email_store')]
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
     * Form para editar categoria
     */
    public function editCategory($id)
    {
    	$emailCategory = $this->getFromApi('GET', 'email_categories/'.$id);

    	return response()->json([
    		'view' => view('email/editCategory', ['emailCategory' => $emailCategory] )->render()
    	]);
    }

    /**
     * Form para editar
     */
    public function edit($id)
    {
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=industry,city,currency');

    	$emailCategories = $this->getFromApi('GET', 'email_categories?company_id='.$company->id.'&user_id='.Auth::id().'&include=emails');

    	$email = $this->getFromApi('GET', 'emails/'.$id);

    	return response()->json([
    		'view' => view('email/edit', ['email' => $email, 'emailCategories' => $emailCategories] )->render()
    	]);
    }

    /**
     * Actualizo
     */
    public function updateCategory(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'title'     => 'required',
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'email_categories/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.email_store')]
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
     * Actualizo
     */
    public function update(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'title'             => 'required',
			'email_category_id' => 'required',
			'subject'           => 'required',
			'body'              => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'emails/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.email_store')]
	    	)->validate();
    	}
    	else
    	{
    		session()->flash('message', __('general.updated'));
			session()->flash('alert-class', 'success');
    	}

    	return response()->json();
    }

    public function send(Request $request)
    {
try{
   	Mail::to($request->to)->send(new NormalEmail($request->all()));
		//sendTestEmail($request);
var_dump("Mail Enviado");
      //  return redirect()->action('EmailController@index');
}catch(Exception $e){
var_dump($e);

}
}
    /**
     * Elimina
     * @param  int $id ID
     */
    public
    function delete_category($id)
    {
        $res = $this->apiCall('DELETE', 'email_categories/' . $id);

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

        return redirect()->action('EmailController@index');
    }


    /**
     * Elimina
     * @param  int $id ID
     */
    public function delete($id)
    {
        $res = $this->apiCall('DELETE', 'emails/' . $id);

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

        return redirect()->action('EmailController@index');
    }




}
