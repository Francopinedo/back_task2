<?php

namespace App\Http\Controllers;

use App\CompanyChatRoom;
use App\CompanyChatRoom_Projects;
use App\CompanyChatRoom_Users;
use App\CompanyChatRoom_Workgroups;
use App\Customer;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use App\Workgroup;
use Illuminate\Http\Request;
use App\RocketChatUser;
use Transformers\CompanyChatRoomTransformer;
use Transformers\RocketchatUserTransformer;


class RocketchatController extends Controller {

    public function showRocketChatUsers()
    {
        $rcUsers = RocketChatUser::all();
        return $this->response->collection($rcUsers,new RocketchatUserTransformer);
    }

    public function showRocketChatChannels()
    {
        $rcChannels = CompanyChatRoom::all();
        return $this->response->collection($rcChannels,new CompanyChatRoomTransformer);
    }

    public function storeAdmin(Request $request)
    {
        if (!$request->has('name'))
        {
            return $this->response->error('Faltan datos', 450);
        }

        $name = $request->name;
        $company = Company::where('name','=',$name)->firstOrFail();
        $usr = str_replace(' ','', $name);
        $domain = $usr.".taskcontrol.net";
        $mail = "admin@".$domain;
        $password = $usr.date('dd.mm.yyyy');
        $path = env('MAILCHAT_USER_PATH').$usr.'admin';

        $rcUser = new RocketChatUser();
        $rcUser->rcuser = $mail;
        $rcUser->rcpass = $password;
        $rcUser->rcpath = $path;
        $rcUser->user_id = null;
        $rcUser->company_id = $company->id;
        $rcUser->save();

        return $this->response->item($rcUser,new RocketchatUserTransformer);
    }
    public function storeUser(Request $request)
    {
        if (!$request->has('name'))
        {
            return $this->response->error('Faltan datos', 450);
        }

        $name = $request->name;
        $company = Company::find($request->company_id);
        $user = User::where('email','=', $request->email)->first();
        $usr = str_replace(' ','', $name);
        $domain = $company->Domain->domain;
        $mail = $usr."@".$domain;
        $password = $usr.date('dd.mm.yyyy');
        $path = env('MAILCHAT_USER_PATH').$usr.'.'.$domain;

        $rcUser = new RocketChatUser();
        $rcUser->rcuser = $mail;
        $rcUser->rcpass = $password;
        $rcUser->rcpath = $path;
        $rcUser->user_id = $user->id;
        $rcUser->company_id = $company->id;
        $rcUser->save();

        $rcChatRoomUser = new CompanyChatRoom_Users();
        $rcChatRoomUser->companychatroom_id = 1;
        $rcChatRoomUser->user_id = $user->id;
        $rcChatRoomUser->save();

        return $this->response->item($rcUser,new RocketchatUserTransformer);
    }
    public function storeGeneralChannel (Request $request)
    {
        if($request->roomName)
        {
            $roomName = $request->roomName;
        }
        else
        {
            $roomName = "General";
        }
        $name = $request->name;
        $company = Company::where('name','=',$name)->firstOrFail();
        $domain = $company->Domain;
        $mails = $domain->mails;
        $chatroomName = str_replace(' ','', $name);

        $rcChatRoom = new CompanyChatRoom();
        $rcChatRoomUser = new CompanyChatRoom_Users();
        $rcChatRoom->name = $chatroomName.$roomName;
        $rcChatRoom->fullname = $chatroomName.$roomName;
        $rcChatRoom->path = env('MAILCHAT_PATH').$chatroomName.$roomName;
        $rcChatRoom->type = 'general';
        $rcChatRoom->save();

        foreach ($mails as $mail)
        {
            $rcChatRoomUser->companychatroom_id = $rcChatRoom->id;
            $rcChatRoomUser->user_id = $mail->user->id;
            $rcChatRoomUser->save();
        }


        return $this->response->item($rcChatRoom,new CompanyChatRoomTransformer);
    }
    public function storeWorkGroupChannel (Request $request)
    {
        $name = $request->title;
        $workGroup = Workgroup::where('title','=',$name)->firstOrFail();
        $company = Company::find($request->company_id);
        $domain = $company->Domain;
        $mails = $domain->mails;
        $usr = str_replace(' ','', $name);

        $rcChatRoom = new CompanyChatRoom();
        $rcChatRoom->name = $usr;
        $rcChatRoom->fullname = $usr.$domain->domain;
        $rcChatRoom->path = env('MAILCHAT_PATH').$usr.$domain->domain;
        $rcChatRoom->type = 'workgroup';
        $rcChatRoom->save();
        $rcChatRoomRel = new CompanyChatRoom_Workgroups();
        $rcChatRoomRel->companychatroom_id = $rcChatRoom->id;
        $rcChatRoomRel->workgroup_id = $workGroup->id;
        $rcChatRoomRel->save();

        return $this->response->item($rcChatRoom,new CompanyChatRoomTransformer);
    }
    public function storeProjectChannel (Request $request)
    {
        $name = $request->name;
        $project = Project::where('name','=',$name)->firstOrFail();
        $customer = Customer::find($project->customer_id);
        $custName = str_replace(' ','', $customer->name);
        $formatName = str_replace(' ','', $name);
        $path = env('MAILCHAT_PATH').$formatName.$custName;

        $rcChatRoom = new CompanyChatRoom();
        $rcChatRoom->name = $formatName;
        $rcChatRoom->fullname = $formatName.$custName;
        $rcChatRoom->path = $path;
        $rcChatRoom->type = 'project';
        $rcChatRoom->save();
        $rcChatRoomRel = new CompanyChatRoom_Projects();
        $rcChatRoomRel->companychatroom_id = $rcChatRoom->id;
        $rcChatRoomRel->project_id = $project->id;
        $rcChatRoomRel->save();

        return $this->response->item($rcChatRoom,new CompanyChatRoomTransformer);
    }
    public function joinGeneralRooms(Request $request)
    {
        $user = User::where('email','=',$request->email)->firstOrFail();
        $generalRooms = CompanyChatRoom::where('type','=','general')->get();
        $rcChatRoomUser = new CompanyChatRoom_Users();

        foreach ($generalRooms as $room)
        {
            if($user->ChatRooms)
            {
                foreach ($user->ChatRooms as $userRoom)
                {
                    if($userRoom->name != $room->name)
                    {
                        $rcChatRoomUser->companychatroom_id = $room->id;
                        $rcChatRoomUser->user_id = $user->id;
                        $rcChatRoomUser->save();
                    }
                }
            }
            else
            {
                // $rcChatRoomUser = new CompanyChatRoom_Users();
                $rcChatRoomUser->companychatroom_id = $room->id;
                $rcChatRoomUser->user_id = $user->id;
                $rcChatRoomUser->save();
            }

        }

        return response()->json($rcChatRoomUser);
    }
}