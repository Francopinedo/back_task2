<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

class UserTransformer extends TransformerAbstract
{

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'address' => $user->address,
            'office_phone' => $user->office_phone,
            'home_phone' => $user->home_phone,
            'cell_phone' => $user->cell_phone,
            'country_id' => $user->country_id,
            'city_id' => $user->city_id,
            'profile_image_path' => $user->profile_image_path,
            'sidebar' => $user->sidebar,
            'theme' => $user->theme,
            'workplace' => $user->workplace,
            'office_id' => $user->office_id,
            'seniority_id' => $user->seniority_id,
            'workgroup_id' => $user->workgroup_id,
            'company_role_id' => $user->company_role_id,
            'project_role_id' => $user->project_role_id,
            'IredMailMail' => $user->IredMailMail,
            'RocketChatUser' => $user->RocketChatUser,
            'ChatRooms' => $user->ChatRooms,
            'timezone'  => $user->timezone
        ];
    }
}
