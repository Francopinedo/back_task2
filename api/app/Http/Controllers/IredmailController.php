<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\IredmailDomain;
use App\IredmailMail;
use App\Models\Company;
use App\Models\User;
use Transformers\IredmailDomainTransformer;
use Transformers\IredmailMailTransformer;


class IredmailController extends Controller {

    public function storeDomain(Request $request)
    {
        if (!$request->has('name'))
        {
            return $this->response->error('Faltan datos', 450);
        }

        $name = $request->name;
        $company = Company::where('name','=',$name)->firstOrFail();
        $name = str_replace(' ', '', $name);
        $domainName = $name.'.'."taskcontrol.net";
        $domain = new IredmailDomain();

        $domain->domain = $domainName;
        $domain->company_id = $company->id;

        $domain->save();

        return response()->json($domain);
    }
    //Show domain selected by company_id
    public function showDomain($id)
    {
        $company = Company::find($id);
        $domain = $company->domain;
        return $this->response->item($domain, new IredmailDomainTransformer());
    }
    //Show domain selected by user_id
    public function showUserDomain($mail)
    {
        $user = User::where('email','=',$mail)->first();
        return response($user);
        $mail = $user->IredMailMail;
        $domain = IredmailDomain::find($mail->iredmail_domain_id);
        return $this->response->item($domain, new IredmailDomainTransformer());
    }
    //Show mail selected by  user_id
    public function showMail($id)
    {
        $user = User::find($id);
        $mail = $user->IredMailMail;
        return $this->response->item($mail, new IredmailMailTransformer());
    }
    //Create User mail
    public function storeMail(Request $request)
    {
        if (!$request->has('name'))
        {
            return $this->response->error('Faltan datos', 450);
        }
        $user = User::where('email','=', $request->email)->first();
        $userNameData = $request->name;
        $userName = str_replace(' ', '', $userNameData);
        $company = Company::find($request->company_id);
        $domain = $company->domain;
        $email = $userName."@".$domain->domain;
        $secret = $userName.date('dd.mm.yyyy');

        $mail = new IredmailMail();

        $mail->mail = $email;
        $mail->iredmail_domain_id = $domain->id;
        $mail->user_id = $user->id;
        $mail->secret = $secret;

        $mail->save();

        return response()->json($mail);
    }

    //Create Admin mail
    public function storeAdminMail(Request $request)
    {
        $userName = "admin";
        $name = $request->name;
        $company = Company::where('name','=',$name)->firstOrFail();
        $domain = $company->domain;
        $email = $userName."@".$domain->domain;
        $name = str_replace(' ','', $name);
        $secret = $name.date('dd.mm.yyyy');

        $mail = new IredmailMail();

        $mail->mail = $email;
        $mail->iredmail_domain_id = $domain->id;
        $mail->user_id = 1;
        $mail->secret = $secret;

        $mail->save();

        return response()->json($mail);
    }

    //Get-all
    public function getDomains()
    {
        $domains = IredmailDomain::all();
        return $this->response->collection($domains, new IredmailDomainTransformer());
    }
    public function getMails()
    {
        $mails = IredmailMail::all();
        return response()->json($mails);
    }
}