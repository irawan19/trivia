<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('check_credit_master_agent', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $value_master_agent                = $inputs['sub_users_id'];
            $value_credit_master_agent         = $inputs['credit_users'];

            $get_master_agent                  = \App\Master_user::where('id',$value_master_agent)->first();
            $get_value_credit_master_agent     = $get_master_agent->credit_users;
            
            if($get_value_credit_master_agent < $value_credit_master_agent)
                return FALSE;
            else
                return TRUE;
        });

        Validator::extend('check_credit_master_agent_edit', function($attribute, $value, $parameters, $validator){
            $inputs                         = $validator->getData();
            $value_agent                    = $inputs['id_agent'];
            $value_master_agent             = $inputs['sub_users_id'];
            $value_credit_master_agent      = $inputs['credit_users'];

            $get_agent                      = \App\Master_user::where('id',$value_agent)->first();
            $get_value_credit_agent         = $get_agent->credit_users;

            $get_master_agent               = \App\Master_user::where('id',$value_master_agent)->first();
            $get_value_credit_master_agent  = $get_master_agent->credit_users + $get_value_credit_agent;
           
            if($get_value_credit_master_agent < $value_credit_master_agent)
                return FALSE;
            else
                return TRUE;
        });

        Validator::extend('check_credit_groups', function($attribute, $value, $parameters, $validator){
            $inputs                          = $validator->getData();
            $value_agents                    = $inputs['credit_agents'];
            $value_groups                    = $inputs['credit_groups'];
            if($value_agents < $value_groups)
                return FALSE;
            else
                return TRUE; 
        });

        Validator::extend('check_whitespace', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $value_group                = $inputs['name_groups'];
            if(preg_match('/\s/',$value_group) == '')
                return TRUE;
            else
                return FALSE;
        });

        Validator::extend('check_name_group', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $value_agent                = $inputs['users_id'];
            $value_group                = $inputs['name_groups'];
            $get_group                  = \App\Master_group::where('name_groups',$value_group)
                                                            ->where('users_id',$value_agent)
                                                            ->count();
            if($get_group != 0)
                return FALSE;
            else
                return TRUE;
        });

        Validator::extend('check_name_group_edit', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $value_agent                = $inputs['users_id'];
            $value_group                = $inputs['name_groups'];
            $value_id_group             = $inputs['id_groups'];
            $get_group                  = \App\Master_group::where('name_groups',$value_group)
                                                            ->where('users_id',$value_agent)
                                                            ->first();
            if($get_group != '')
            {
                if($get_group->id_groups == $value_id_group)
                   return TRUE;
                else
                    return FALSE;
            }
            else
                return FALSE;
        });

        Validator::extend('check_credit_sessions', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $value_id_group             = $inputs['groups_id'];
            $get_group                  = \App\Master_group::where('id_groups',$value_id_group)->first();
            $credit_group               = $get_group->credit_groups;
            if($credit_group == 0)
                return FALSE;
            else
                return TRUE;
        });

        Validator::extend('check_last_sessions', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $value_id_group             = $inputs['groups_id'];
            $date_now                   = date('Y-m-d H:i:s');
            $check_sessions             = \App\Master_session::where('groups_id',$value_id_group)
                                                                ->where('end_date_sessions','>',$date_now)
                                                                ->count();
            if($check_sessions == 0)
                return TRUE;
            else
                return FALSE;
        });

        Validator::extend('check_last_game', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $value_id_sessions          = $inputs['sessions_id'];
            $date_now                   = date('Y-m-d H:i:s');
            $check_games                = \App\Master_game::where('sessions_id',$value_id_sessions)
                                                                ->where('end_date_games','>',$date_now)
                                                                ->count();
            if($check_games == 0)
                return TRUE;
            else
                return FALSE;
        });

        Validator::extend('check_credit_members', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $value_credit_members       = $inputs['credit_member_sessions'];
            $id_groups                  = $inputs['groups_id'];
            $get_group                  = \App\Master_group::where('id_groups',$id_groups)->first();
            $credit_groups              = $get_group->credit_groups;
            if($credit_groups < $value_credit_members)
                return FALSE;
            else
                return TRUE;
        });

        Validator::extend('check_top_up_agent', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $credit_top_ups             = $inputs['credit_top_ups'];
            $id_admin                   = Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;
            if($id_level_systems == 2)
            {
                $get_credit_master_agent= \App\Master_user::where('id',$id_admin)->first();
                $credit_master_agent    = $get_credit_master_agent->credit_users;
                if($credit_master_agent < $credit_top_ups)
                    return FALSE;
                else
                    return TRUE;
            }
            else
                return TRUE;
        });

        Validator::extend('check_top_up_agent_edit', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $credit_top_ups             = $inputs['credit_top_ups'];
            $id_top_ups                 = $inputs['id_top_ups'];
            
            $id_admin                   = Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;
            if($id_level_systems == 2)
            {
                $get_old_top_ups        = \App\Master_top_up::where('id_top_ups',$id_top_ups)->first();
                $get_credit_top_up      = $get_old_top_ups->credit_top_ups;

                $get_credit_master_agent= \App\Master_user::where('id',$id_admin)->first();
                $credit_master_agent    = $get_credit_master_agent->credit_users + $get_credit_top_up;
                if($credit_master_agent < $credit_top_ups)
                    return FALSE;
                else
                    return TRUE;
            }
            else
                return TRUE;
        });

        Validator::extend('check_top_up_member', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $credit_top_ups             = $inputs['credit_top_ups'];
            $id_agent_master_agent      = Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;
            if($id_level_systems != 1)
            {
                $get_credit_admin   = \App\Master_user::where('id',$id_agent_master_agent)->first();
                $credit_admin       = $get_credit_admin->credit_users;
                if($credit_admin < $credit_top_ups)
                    return FALSE;
                else
                    return TRUE;
            }
            else
                return TRUE;
        });

        Validator::extend('check_top_up_member_edit', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $credit_top_ups             = $inputs['credit_top_ups'];
            $id_top_ups                 = $inputs['id_top_ups'];
            
            $id_agent_master_agent      = Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;
            if($id_level_systems != 1)
            {
                $get_old_top_ups        = \App\Master_top_up::where('id_top_ups',$id_top_ups)->first();
                $get_credit_top_up      = $get_old_top_ups->credit_top_ups;

                $get_credit_master_agent= \App\Master_user::where('id',$id_agent_master_agent)->first();
                $credit_master_agent    = $get_credit_master_agent->credit_users + $get_credit_top_up;
                if($credit_master_agent < $credit_top_ups)
                    return FALSE;
                else
                    return TRUE;
            }
            else
                return TRUE;
        });

        Validator::extend('check_top_up_group', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $credit_top_ups             = $inputs['credit_top_ups'];
            $id_agent_master_agent      = Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;
            if($id_level_systems != 1)
            {
                $get_credit_admin   = \App\Master_user::where('id',$id_agent_master_agent)->first();
                $credit_admin       = $get_credit_admin->credit_users;
                if($credit_admin < $credit_top_ups)
                    return FALSE;
                else
                    return TRUE;
            }
            else
                return TRUE;
        });

        Validator::extend('check_top_up_group_edit', function($attribute, $value, $parameters, $validator){
            $inputs                     = $validator->getData();
            $credit_top_ups             = $inputs['credit_top_ups'];
            $id_top_ups                 = $inputs['id_top_ups'];
            
            $id_agent_master_agent      = Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;
            if($id_level_systems != 1)
            {
                $get_old_top_ups        = \App\Master_top_up::where('id_top_ups',$id_top_ups)->first();
                $get_credit_top_up      = $get_old_top_ups->credit_top_ups;

                $get_credit_master_agent= \App\Master_user::where('id',$id_agent_master_agent)->first();
                $credit_master_agent    = $get_credit_master_agent->credit_users + $get_credit_top_up;
                if($credit_master_agent < $credit_top_ups)
                    return FALSE;
                else
                    return TRUE;
            }
            else
                return TRUE;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
