<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Shwetech;

class WhatsappBotController extends Controller
{
    public $successStatus   = 200;
    public $errorStatus     = 400;

    //PRIVATE MESSAGE BOT
        public function create_group()
        {
            //PARAMETER
                $get_group_name     = request('wa_group_name');
                $get_phone_number   = request('wa_ph_number');
                $get_credit_group   = request('credit_group');

            if($get_group_name != '')
            {
                if($get_phone_number != '')
                {
                    if(preg_match('/\s/',$get_group_name) == '')
                    {
                        $get_agent = \App\Master_user::where('phone_number_users',$get_phone_number)->first();
                        if($get_agent != '')
                        {
                            if($get_agent->level_systems_id == 3)
                            {
                                $id_agent                   = $get_agent->id;
                                $get_master_agent           = \App\Master_user::where('id',$get_agent->sub_users_id)->first();
                                $get_phone_master_agent     = $get_master_agent->phone_number_users;
                                $max_groups                 = $get_agent->max_group_users;
                                $credit_users               = $get_agent->credit_users;
                                $check_total_group_created  = \App\Master_group::where('users_id',$id_agent)
                                                                                ->count();
                                if($check_total_group_created < $max_groups)
                                {
                                    if (is_numeric($get_credit_group))
                                    {
                                        if($get_credit_group == '')
                                        {
                                            if($credit_users != 0)
                                            {
                                                $check_group_name   = \App\Master_group::where('users_id',$id_agent)
                                                                                        ->where('name_groups',$get_group_name)
                                                                                        ->count();
                                                if($check_group_name == 0)
                                                {
                                                    $groups_data = [
                                                        'users_id'          => $id_agent,
                                                        'credit_groups'     => $credit_users,
                                                        'whatsapp_group_id' => '',
                                                        'name_groups'       => $get_group_name,
                                                        'created_on_groups' => date('Y-m-d H:i:s'),
                                                    ];
                                                    \App\Master_group::insert($groups_data);

                                                    $credit_agent_data = [
                                                        'credit_users' => 0
                                                    ];
                                                    \App\Master_user::where('id',$id_agent)->update($credit_agent_data);

                                                    $success_data = [
                                                        "target"    => "private",
                                                        "response"  => "Great! Your ".$get_group_name." has successfully created",
                                                        "value"     => $get_phone_number,
                                                    ];
                                                    return response()->json(["success" => $success_data], $this->successStatus);
                                                }
                                                else
                                                {
                                                    $error_data = [
                                                        "target"    => "private",
                                                        "response"  => "Group already exits. Please find another name for your group",
                                                        "value"     => $get_phone_number,
                                                    ];
                                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                                }
                                            }
                                            else
                                            {
                                                $error_data = [
                                                    "target"    => "private",
                                                    "response"  => "Your credit is 0.you can't create group anymore. Please top up to your master agent - ".$get_phone_master_agent,
                                                    "value"     => $get_phone_number,
                                                ];
                                                return response()->json(["error" => $error_data], $this->errorStatus);
                                            }
                                        }
                                        else
                                        {
                                            if($get_credit_group <= $credit_users)
                                            {
                                                $check_group_name = \App\Master_group::where('users_id',$id_agent)
                                                                                        ->where('name_groups',$get_group_name)
                                                                                        ->count();
                                                if($check_group_name == 0)
                                                {
                                                    $calculate_credit_group = $credit_users - $get_credit_group;

                                                    $groups_data = [
                                                        'users_id'          => $id_agent,
                                                        'credit_groups'     => $get_credit_group,
                                                        'whatsapp_group_id' => '',
                                                        'name_groups'       => $get_group_name,
                                                        'created_on_groups' => date('Y-m-d H:i:s'),
                                                    ];
                                                    \App\Master_group::insert($groups_data);

                                                    $credit_agent_data = [
                                                        'credit_users' => $calculate_credit_group
                                                    ];
                                                    \App\Master_user::where('id',$id_agent)->update($credit_agent_data);

                                                    $success_data = [
                                                        "target"    => "private",
                                                        "response"  => "Great! Your ".$get_group_name." has successfully created",
                                                        "value"     => $get_phone_number
                                                    ];
                                                    return response()->json(["success" => $success_data], $this->successStatus);
                                                }
                                                else
                                                {
                                                    $error_data = [
                                                        "target"    => "private",
                                                        "response"  => "Group already exist. Please find another name for your group",
                                                        "value"     => $get_phone_number
                                                    ];
                                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                                }
                                            }
                                            else
                                            {
                                                $error_data = [
                                                    "target"    => "private",
                                                    "response"  => "Your credit is not enough. your current credit is ".$credit_users,
                                                    "value"     => $get_phone_number,
                                                ];
                                                return response()->json(["error" => $error_data], $this->errorStatus);
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => "Credit should be a number",
                                            "value"     => $get_phone_number
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "Your group has reached the limit",
                                        "value"     => $get_group_name,
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "Your not agent",
                                    "value"     => $get_phone_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "Number Not listed",
                                "value"     => $get_phone_number,
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "Name must not have spaces",
                            "value"     => $get_phone_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "You must enter the phone number",
                        "value"     => "",
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "You must enter the group name",
                    "value"     => $get_phone_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

    //PRIVATE MESSAGE BOT
        public function update_group()
        {
            //PARAMETER
                $get_group_id      = request('wa_group_id');
                $get_group_name    = request('wa_group_name');
                $get_ph_number     = request('wa_ph_number');

            if($get_group_id != '')
            {
                if($get_group_name != '')
                {
                    if($get_ph_number != '')
                    {
                        $get_group = \App\Master_group::join('users','users_id','=','users.id')
                                                        ->where('name_groups',$get_group_name)
                                                        ->where('phone_number_users',$get_ph_number)
                                                        ->first();
                        if($get_group != '')
                        {
                            $get_group_name = $get_group->name_groups;
                            if($get_group->phone_number_users == $get_ph_number)
                            {
                                $id_group = $get_group->id_groups;
                                $group_data = [
                                    'whatsapp_group_id' => $get_group_id
                                ];
                                \App\Master_group::where('id_groups',$id_group)->update($group_data);

                                $success_data = [
                                    "target"    => "private",
                                    "response"  => "Group ID has been updated successfully",
                                    "value"     => $get_ph_number,
                                ];
                                return response()->json(['success' => $success_data], $this->successStatus);
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "Your not agent in ".$get_group_name." group",
                                    "value"     => $get_ph_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "Unlisted group",
                                "value"     => $get_ph_number,
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "You must enter the phone number",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "You must enter the group name",
                        "value"     => "",
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "You must enter the whatsapp group id",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

    //PRIVATE MESSAGE BOT
        public function create_sessions()
        {
            //PARAMETER
                $get_group_name     = request('wa_group_name');
                $get_ph_number      = request('wa_ph_number');
                $get_credit_member  = request('credit_member');
                $get_duration       = request('day_duration');

            $date_now                   = date('Y-m-d H:i:s');
            if($get_group_name != '')
            {
                if($get_ph_number != '')
                {
                    if($get_credit_member != '')
                    {
                        $get_group                  = \App\Master_group::join('users','users_id','=','users.id')
                                                                        ->where('name_groups',$get_group_name)
                                                                        ->first();
                        if($get_group != '')
                        {                              
                            $id_group                   = $get_group->id_groups;
                            if($get_group->phone_number_users == $get_ph_number)
                            {
                                $credit_groups              = $get_group->credit_groups;
                                if($credit_groups > 0)
                                {
                                    if($credit_groups >= $get_credit_member)
                                    {
                                        $check_sessions = \App\Master_session::where('end_date_sessions', '>' ,$date_now)->count();
                                        if($check_sessions == 0)
                                        {
                                            $get_start_date         = date('Y-m-d H:i:s');
                                            if($get_duration != '')
                                            {
                                                if(is_numeric($get_duration))
                                                    $get_end_date       = date('Y-m-d H:i:s',strtotime('+'.$get_duration.' days',strtotime($get_start_date)));
                                                else
                                                {
                                                    $error_data = [
                                                        "target"    => "private",
                                                        "response"  => $get_group_name."\n Day should be a number",
                                                        "value"     => $get_ph_number
                                                    ];
                                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                                }
                                            }
                                            else
                                            {
                                                $get_app_configuration  = \App\Master_app_configuration::first();
                                                $get_duration           = $get_app_configuration->sessions_days_duration_app_configurations;
                                                $get_end_date           = date('Y-m-d H:i:s',strtotime('+'.$get_duration.' days',strtotime($get_start_date)));
                                            }

                                            if(strtotime($date_now) < strtotime($get_start_date) && strtotime($date_now) < strtotime($get_end_date))
                                                $status                 = '0';
                                            elseif(strtotime($date_now) >= strtotime($get_start_date) && strtotime($date_now) <= strtotime($get_end_date))
                                                $status                 = '1';
                                            elseif(strtotime($date_now) >= strtotime($get_start_date) && strtotime($date_now) >= strtotime($get_end_date))
                                                $status                 = '2';

                                            $data = [
                                                'groups_id'             => $id_group,
                                                'start_date_sessions'   => $get_start_date,
                                                'end_date_sessions'     => $get_end_date,
                                                'credit_member_sessions'=> $get_credit_member,
                                                'status_active_sessions'=> $status,
                                            ];
                                            \App\Master_session::insert($data);

                                            $success_data = [
                                                "target"    => "private",
                                                "response"  => $get_group_name."\n Great! Your sessions has successfully created. This sessions started at ".Shwetech::changeDBToDatetime($get_start_date)." end finished at ".Shwetech::changeDBToDatetime($get_end_date),
                                                "value"     => $get_ph_number,
                                            ];
                                            return response()->json(["success" => $success_data], $this->successStatus);
                                        }
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => "You have an active session",
                                            "value"     => $get_ph_number,
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => "Credit group not enough",
                                            "value"     => $get_ph_number,
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                elseif($credit_groups <= 0)
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => $get_group_name."\n Credit group not enough",
                                        "value"     => $get_ph_number,
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "Your not agent in ".$get_group_name." group",
                                    "value"     => $get_ph_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => $get_group_name."\n Unlisted group",
                                "value"     => $get_ph_number,
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "You must enter the credit member",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "You must enter the phone number",
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "You must enter the group name",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

    //GROUP MESSAGE
        public function register_members()
        {
            //PARAMETER
                $get_group_id   = request('wa_group_id');
                $get_ph_number  = request('wa_ph_number');

            if($get_group_id != '')
            {
                if($get_ph_number != '')
                {
                    $get_group              = \App\Master_group::where('whatsapp_group_id',$get_group_id)->first();
                    if($get_group != '')
                    {
                        $id_group               = $get_group->id_groups;
                        $get_group_name         = $get_group->name_groups;
                        $get_credit_group       = $get_group->credit_groups;
                        $get_last_sessions      = \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
                                                                    ->where('whatsapp_group_id',$get_group_id)
                                                                    ->first();
                        if($get_last_sessions != '')
                        {
                            if($get_last_sessions->status_active_sessions == 1)
                            {
                                $id_sessions                = $get_last_sessions->id_sessions;
                                $get_start_date             = $get_last_sessions->start_date_sessions;
                                $get_end_date               = $get_last_sessions->end_date_sessions;
                                $get_credit_member_sessions = $get_last_sessions->credit_member_sessions;
                                $get_agent_id                = $get_last_sessions->users_id;
                                $get_agent                   = \App\Master_user::where('id',$get_agent_id)->first();
                                $get_phone_number_agent      = $get_agent->phone_number_users;
                                if($get_phone_number_agent != $get_ph_number)
                                {
                                    $check_register_members     = \App\Master_register_member::where('sessions_id',$id_sessions)
                                                                                            ->where('phone_number_register_members',$get_ph_number)
                                                                                            ->count();
                                    if($check_register_members == 0)
                                    {
                                        if($get_credit_group >= $get_credit_member_sessions)
                                        {
                                            $register_members_data      = [
                                                'sessions_id'                       => $id_sessions,
                                                'credit_register_members'           => $get_credit_member_sessions,
                                                'phone_number_register_members'     => $get_ph_number
                                            ];
                                            \App\Master_register_member::insert($register_members_data);

                                            $calculate_credit_group = $get_credit_group - $get_credit_member_sessions;
                                            $credit_group_data = [
                                                'credit_groups' => $calculate_credit_group
                                            ];
                                            \App\Master_group::where('id_groups',$id_group)->update($credit_group_data);

                                            $success_data = [
                                                "target"    => "group",
                                                "response"  => $get_ph_number." Success join the sessions! Good Luck! Sessions started at ".Shwetech::changeDBToDatetime($get_start_date)." and finished at ".Shwetech::changeDBToDatetime($get_end_date),
                                                "value"     => $get_group_id
                                            ];
                                            return response()->json(["success" => $success_data], $this->successStatus);
                                        }
                                        else
                                        {
                                            $error_data = [
                                                "target"    => "private",
                                                "response"  => $get_group_name." Credit group not enough",
                                                "value"     => $get_ph_number
                                            ];
                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                        }
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "group",
                                            "response"  => $get_ph_number." Your already registered",
                                            "value"     => $get_group_id
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => $get_group_name." Your is agent in this group, you can't play in your own group",
                                        "value"     => $get_ph_number,
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => $get_group_name." No sessions is active",
                                    "value"     => $get_ph_number
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => $get_group_name."\n Group doesn't have any sessions",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "Group unlisted",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "You must enter the phone number",
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "You must enter the group ID",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

    //PRIVATE MESSAGE BOT
        public function create_game()
        {
            //PARAMETER
                $get_group_name = request('wa_group_name');
                $get_ph_number  = request('wa_ph_number');
                $get_rtp        = request('rtp_game');

            if($get_group_name != '')
            {
                if($get_ph_number != '')
                {
                    if($get_rtp != '')
                    {
                        if(is_numeric($get_rtp))
                        {
                            if($get_rtp > 0 && $get_rtp <= 100)
                            {
                                $date_now               = date('Y-m-d H:i:s');
                                $check_group            = \App\Master_group::join('users','users_id','=','users.id')
                                                                            ->where('name_groups',$get_group_name)
                                                                            ->where('phone_number_users',$get_ph_number)
                                                                            ->count();
                                if($check_group != 0)
                                {
                                    $get_last_sessions  = \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
                                                                                ->where('name_groups',$get_group_name)
                                                                                ->first();
                                    if($get_last_sessions != '')
                                    {
                                        if($get_last_sessions->status_active_sessions)
                                        {
                                            $id_sessions    = $get_last_sessions->id_sessions;
                                            $check_games    = \App\Master_game::where('sessions_id',$id_sessions)
                                                                                ->where('sessions_id',$id_sessions)
                                                                                ->first();
                                            if($check_games->status_active_games != 1)
                                            {
                                                if($check_games->start_date_games != '0000-00-00 00:00:00')
                                                {
                                                    $check_phone_number_agent    = \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
                                                                                                        ->join('users','users_id','=','users.id')
                                                                                                        ->where('phone_number_users',$get_ph_number)
                                                                                                        ->first();
                                                    if($check_phone_number_agent != '')
                                                    {
                                                        $games_data     = [
                                                            'sessions_id'           => $id_sessions,
                                                            'start_date_games'      => '0000-00-00 00:00:00',
                                                            'end_date_games'        => '0000-00-00 00:00:00',
                                                            'rtp_games'             => $get_rtp,
                                                            'status_active_games'   => 0,
                                                        ];
                                                        \App\Master_game::insert($games_data);

                                                        $success_data = [
                                                            "target"    => "private",
                                                            "response"  => $get_group_name."Awesome! Your game settings are: \n Return to Player = ".$get_rtp." \n ------------------------------- \n Now you can start the game by enter \n #start ".$get_group_name,
                                                            "value"     => $get_ph_number
                                                        ];
                                                        return response()->json(["success" => $success_data], $this->successStatus);
                                                    }
                                                    else
                                                    {
                                                        $error_data = [
                                                            "target"        => "private", 
                                                            "response"      => "Your not agent in ".$get_group_name." group",
                                                            "value"         => $get_ph_number
                                                        ];
                                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                                    }
                                                }
                                                else
                                                {
                                                    $error_data = [
                                                        "target"    => "private",
                                                        "response"  => $get_group_name."\n There are games that have not been started in the current sessions",
                                                        "value"     => $get_ph_number
                                                    ];
                                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                                }
                                                
                                            }
                                            else
                                            {
                                                $error_data = [
                                                    "target"    => "private",
                                                    "response"  => $get_group_name."\n There is an active game",
                                                    "value"     => $get_ph_number,
                                                ];
                                                return response()->json(["error" => $error_data], $this->errorStatus);
                                            }
                                        }
                                        else
                                        {
                                            $error_data = [
                                                "target"    => "private",
                                                "response"  => $get_group_name."\n No sessions is active",
                                                "value"     => $get_ph_number,
                                            ];
                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                        }
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => $get_group_name."\n Group doesn't have any sessions",
                                            "value"     => $get_ph_number,
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "Group unlisted",
                                        "value"     => $get_ph_number
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data =[
                                    "target"    => "private",
                                    "response"  => "RTP must be set 1 to 100",
                                    "value"     => $get_ph_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "RTP should be a number",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "You must enter the RTP (Return To Player)",
                            "value"     => $get_ph_number
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "You must enter the phone number",
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "You must enter the group name",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

    //PRIVATE MESSAGE BOT
        public function start_game()
        {
            //PARAMETER
                $get_group_name = request('wa_group_name');
                $get_ph_number  = request('wa_ph_number');
                $get_duration   = request('minutes_duration');

            if($get_group_name != '')
            {
                if($get_ph_number != '')
                {
                    $check_group = \App\Master_group::where('name_groups',$get_group_name)
                                                    ->first();
                    if($check_group != '')
                    {
                        $id_group   = $check_group->id_groups;
                        $check_agent = \App\Master_group::join('users','users_id','=','users.id')
                                                        ->where('id_groups',$id_group)
                                                        ->where('phone_number_users',$get_ph_number)
                                                        ->count();
                        if($check_agent != 0)
                        {
                            $check_active_game           = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                                            ->where('groups_id',$id_group)
                                                                            ->where('status_active_games',0)
                                                                            ->first();
                            if($check_active_game != '')
                            {
                                $id_games               = $check_active_game->id_games;
                                $date_now               = date('Y-m-d H:i:s');
                                $get_start_date         = $date_now;
                                if($get_duration != '')
                                {
                                    if(is_numeric($get_duration))
                                        $get_end_date       = date('Y-m-d H:i:s',strtotime('+'.$get_duration.' minutes',strtotime($get_start_date)));
                                    else
                                        return response()->json(["error" => $get_group_name."\n Minutes should be a number"], $this->errorStatus);
                                }
                                else
                                {
                                    $get_app_configuration  = \App\Master_app_configuration::first();
                                    $get_duration           = $get_app_configuration->game_minutes_duration_app_configurations;
                                    $get_end_date           = date('Y-m-d H:i:s',strtotime('+'.$get_duration.' minutes',strtotime($get_start_date)));
                                }

                                $date_now                   = date('Y-m-d H:i:s');
                                if(strtotime($date_now) < strtotime($get_start_date) && strtotime($date_now) < strtotime($get_end_date))
                                    $status                 = '0';
                                elseif(strtotime($date_now) >= strtotime($get_start_date) && strtotime($date_now) <= strtotime($get_end_date))
                                    $status                 = '1';
                                elseif(strtotime($date_now) >= strtotime($get_start_date) && strtotime($date_now) >= strtotime($get_end_date))
                                    $status                 = '2';

                                $games_data     = [
                                    'start_date_games'      => $get_start_date,
                                    'end_date_games'        => $get_end_date,
                                    'status_active_games'   => $status,
                                ];
                                \App\Master_game::where('id_games',$id_games)->update($games_data);

                                $success_data = [
                                    "target"    => "private",
                                    "response"  => $get_group_name."\n Perfect! 🏁 Ok we can start the game. 🏁 \n 🎉 You can invite your friends to the group now.",
                                    "value"     => $get_ph_number
                                ];
                                return response()->json(["success" => $success_data], $this->successStatus);
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "Your not agent in ".$get_group_name." group",
                                    "value"     => $get_ph_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "Your not agent in ".$get_group_name." group",
                                "value"     => $get_ph_number
                            ];
                            return response()->jsoN(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "Group unlisted",
                            "value"     => $get_ph_number
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "You must enter the phone number",
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "You must enter the group name",
                    "value"     => $get_ph_number
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

    //PRIVATE MESSAGE BOT
        public function end_game()
        {
            //PARAMETER
                $get_group_name = request('wa_group_name');
                $get_ph_number  = request('wa_ph_number');

            if($get_group_name != '')
            {
                if($get_ph_number != '')
                {
                    $get_group = \App\Master_group::where('name_groups',$get_group_name)->first();
                    if($get_group != '')
                    {
                        $id_group       = $get_group->id_groups;
                        $credit_group   = $get_group->credit_groups;
                        $check_agent     = \App\Master_group::join('users','users_id','=','users.id')
                                                        ->where('id_groups',$id_group)
                                                        ->where('phone_number_users',$get_ph_number)
                                                        ->first();
                        if($check_agent != '')
                        {
                            $get_group_id   = $check_agent->whatsapp_group_id;
                            $check_game = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                            ->where('groups_id',$id_group)
                                                            ->where('status_active_games','1')
                                                            ->first();
                            if($check_game != '')
                            {
                                $id_games   = $check_game->id_games;
                                $rtp_games  = $check_game->rtp_games;

                                $get_total_all_stake = \App\Master_stake::selectRaw('SUM(value_stakes) AS total_all_stakes')
                                                                        ->where('games_id',$id_games)
                                                                        ->first();
                                if($get_total_all_stake != '')
                                    $total_all_stakes = $get_total_all_stake->total_all_stakes;
                                else
                                    $total_all_stakes = 0;

                                $get_calculate_rtp = \App\Master_stake::selectRaw('name_list_stakes,
                                                                                    (
                                                                                        ROUND(
                                                                                                (('.$total_all_stakes.' - (sum(value_stakes) * 10)) / '.$total_all_stakes.') * 100, 2
                                                                                            )
                                                                                    ) AS calculate_rtp')
                                                                        ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                                                        ->where('games_id',$id_games)
                                                                        ->groupBy('id_list_stakes')
                                                                        ->having('calculate_rtp','>',$rtp_games)
                                                                        ->orderBy('calculate_rtp')
                                                                        ->limit(1)
                                                                        ->first();
                                if($get_calculate_rtp != '')
                                    $stakes_winner         = $get_calculate_rtp->name_list_stakes; 
                                else
                                {
                                    $get_winner_optional = \App\Master_stake::selectRaw('name_list_stakes,
                                                                                        (
                                                                                            ROUND(
                                                                                                    (('.$total_all_stakes.' - (sum(value_stakes) * 10)) / '.$total_all_stakes.') * 100, 2
                                                                                                )
                                                                                        ) AS calculate_rtp')
                                                                            ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                                                            ->where('games_id',$id_games)
                                                                            ->groupBy('id_list_stakes')
                                                                            ->having('calculate_rtp','<',$rtp_games)
                                                                            ->orderBy('calculate_rtp','desc')
                                                                            ->limit(1)
                                                                            ->first();
                                    if($get_winner_optional != '')
                                        $stakes_winner         = $get_winner_optional->name_list_stakes;
                                    else
                                        $stakes_winner         = 'No Winner';
                                }

                                if($stakes_winner != 'No Winner')
                                {
                                    $get_member_winner = \App\Master_stake::selectRaw('CONCAT(SUBSTRING(`phone_number_register_members`, 1, CHAR_LENGTH(`phone_number_register_members`) - 5),"****") as phone_number,
                                                                                        name_list_stakes,
                                                                                        SUM(value_stakes * 10) AS profit,
                                                                                        id_register_members,
                                                                                        id_stakes,
                                                                                        credit_register_members')
                                                                            ->join('master_register_members','register_members_id','master_register_members.id_register_members')
                                                                            ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                                                            ->where('name_list_stakes',$stakes_winner)
                                                                            ->where('games_id',$id_games)
                                                                            ->groupBy('id_register_members')
                                                                            ->get();

                                    foreach($get_member_winner as $member_winner)
                                    {
                                        $winloses_data = [
                                            'stakes_id'         => $member_winner->id_stakes,
                                            'profit_winloses'   => $member_winner->profit
                                        ];
                                        \App\Master_winlose::insert($winloses_data);

                                        $id_register_members        = $member_winner->id_register_members;
                                        $calculate_credit_register_members = $member_winner->credit_register_members + $member_winner->profit;
                                        $credit_register_members_data = [
                                            'credit_register_members' => $calculate_credit_register_members
                                        ];
                                        \App\Master_register_member::where('id_register_members',$id_register_members)->update($credit_register_members_data);
                                    }

                                    $get_total_winlose      = \App\Master_winlose::selectRaw('SUM(profit_winloses) AS total_winlose')
                                                                                    ->join('master_stakes','stakes_id','=','master_stakes.id_stakes')
                                                                                    ->join('master_games','games_id','=','master_games.id_games')
                                                                                    ->where('games_id',$id_games)
                                                                                    ->first();

                                    $calculate_credit_group = $credit_group + ($total_all_stakes - $get_total_winlose->total_winlose);
                                    $credit_group_data      = [
                                        'credit_groups' => $calculate_credit_group
                                    ];
                                    \App\Master_group::where('id_groups',$id_group)->update($credit_group_data);

                                    $games_data = [
                                        'end_date_games'     => date('Y-m-d H:i:s'),
                                        'status_active_games'=> 2
                                    ];
                                    \App\Master_game::where('id_games',$id_games)->update($games_data);

                                    $success_data = [
                                        "target"    => "group",
                                        "response"  => "This is the winner in this game ".$get_member_winner,
                                        "value"     => $get_group_id
                                    ];
                                    return response()->json(["success" => $success_data], $this->successStatus);
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "group",
                                        "response"  => $get_group_name."\n No winner in this game",
                                        "value"     => $get_group_id,
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => $get_group_name."\n No game is active",
                                    "value"     => $get_ph_number
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => $get_group_name."\n Your not agent in this group",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => $get_group_name."\n Group unlisted",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "You must enter the phone number",
                        "value"     => $get_ph_number,
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "You must enter the group name",
                    "value"     => $get_ph_number
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

    //GROUP MESSAGE
        public function stakes()
        {
            //PARAMETER
                $get_group_id   = request('wa_group_id');
                $get_ph_number  = request('wa_ph_number');
                $get_stake      = request('stake');
                $get_value      = request('value');

            if($get_group_id != '')
            {
                if($get_ph_number != '')
                {
                    $get_group  = \App\Master_group::where('whatsapp_group_id',$get_group_id)->first();
                    if($get_group != '')
                    {
                        $get_group_name = $get_group->name_groups;
                        if($get_stake != '')
                        {
                            if($get_value != '')
                            {
                                if(is_numeric($get_value))
                                {
                                    $check_list_stakes = \App\Master_list_stake::where('name_list_stakes',$get_stake)->first();
                                    if($check_list_stakes != '')
                                    {
                                        $get_register_member = \App\Master_register_member::where('phone_number_register_members',$get_ph_number)->first();
                                        if($get_register_member != '')
                                        {
                                            $id_register_members    = $get_register_member->id_register_members;
                                            $credit_register_members= $get_register_member->credit_register_members;
                                            if($credit_register_members >= $get_value)
                                            {
                                                if($get_value > 0)
                                                {
                                                    $get_active_games = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                                                        ->join('master_groups','groups_id','=','master_groups.id_groups')
                                                                                        ->where('whatsapp_group_id',$get_group_id)
                                                                                        ->where('status_active_games','1')
                                                                                        ->first();
                                                    if($get_active_games != '')
                                                    {
                                                        $id_list_stake = $check_list_stakes->id_list_stakes;
                                                        $stakes_data = [
                                                            'games_id' => $get_active_games->id_games,
                                                            'register_members_id' => $id_register_members,
                                                            'list_stakes_id' => $id_list_stake,
                                                            'value_stakes' => $get_value,
                                                        ];
                                                        \App\Master_stake::insert($stakes_data);

                                                        $calculate_credit_members = $credit_register_members - $get_value;
                                                        $credit_register_members = [
                                                            'credit_register_members'   => $calculate_credit_members
                                                        ];
                                                        \App\Master_register_member::where('id_register_members',$id_register_members)->update($credit_register_members);

                                                        $success_data = [
                                                            "target"    => "group",
                                                            "response"  => "Great! ".$get_ph_number." success to stake ".$get_stake." with value ".$get_value,
                                                            "value"     => $get_group_id
                                                        ];
                                                        return response()->json(["success" => $success_data], $this->successStatus);
                                                    }
                                                    else
                                                    {
                                                        $error_data = [
                                                            "target"    => "private",
                                                            "response"  => $get_group_name." No game is active",
                                                            "value"     => $get_ph_number
                                                        ];
                                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                                    }
                                                }
                                                else
                                                {
                                                    $error_data = [
                                                        "target"    => "private",
                                                        "response"  => $get_group_name." Value can't be smaller than 0",
                                                        "value"     => $get_ph_number,
                                                    ];
                                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                                }
                                            }
                                            else
                                            {
                                                $error_data = [
                                                    "target"    => "private",
                                                    "response"  => $get_group_name." Your credit not enough",
                                                    "value"     => $get_ph_number,
                                                ];
                                                return response()->json(["error" => $error_data], $this->errorStatus);
                                            }
                                        }
                                        else
                                        {
                                            $error_data = [
                                                "target"    => "private",
                                                "response"  => $get_group_name."\n Your not member in this group",
                                                "value"     => $get_ph_number
                                            ];
                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                        }
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => $get_group_name."\n Your stakes not in list",
                                            "value"     => $get_ph_number
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => $get_group_name."\n Value should be a number",
                                        "value"     => $get_ph_number
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => $get_group_name."\n You must enter the value",
                                    "value"     => $get_ph_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => $get_group_name."\n You must enter the stake",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "Group unlisted",
                            "value"     => $get_ph_number
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "You must enter the phone number",
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "You must enter the group ID",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

    //GROUP MESSAGE
        public function check_stakes_members()
        {
            //PARAMETER
                $get_group_id      = request('wa_group_id');
            
            if($get_group_id != '')
            {
                $get_stakes_member = \App\Master_stake::selectRaw('CONCAT(SUBSTRING(`phone_number_register_members`, 1, CHAR_LENGTH(`phone_number_register_members`) - 5),"****") as phone_number,
                                                                    name_list_stakes,
                                                                    value_stakes')
                                                        ->join('master_games','games_id','=','master_games.id_games')
                                                        ->join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                        ->join('master_groups','groups_id','=','master_groups.id_groups')
                                                        ->join('master_register_members','register_members_id','=','master_register_members.id_register_members')
                                                        ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                                        ->where('whatsapp_group_id',$get_group_id)
                                                        ->get();
                if($get_stakes_member != '')
                {
                    $stakes_members_data = [
                        'check_stakes_members' => $get_stakes_member
                    ];

                    $success_data = [
                        "target"    => "group",
                        "response"  => $stakes_members_data,
                        "value"     => $get_group_id,
                    ];
                    return response()->json(["success" => $success_data], $this->successStatus);
                }
                else
                {
                    $error_data = [
                        "target"    => "group",
                        "response"  => "List stakes empty",
                        "value"     => $get_group_id
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "group",
                    "response"  => "You must enter the whatsapp group ID",
                    "value"     => $get_group_id
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

    //GROUP MESSAGE
        public function list_stakes()
        {
            $get_group_id          = request('wa_group_id');
            if($get_group_id != '')
            {
                $check_group = \App\Master_group::where("whatsapp_group_id",$get_group_id)->count();
                if($check_group != 0)
                {
                    $check_list_stakes = \App\Master_list_stake::count();
                    if($check_list_stakes != 0)
                    {
                        $get_list_stakes = \App\Master_list_stake::select('name_list_stakes')
                                                                ->get();
                        $list_stakes_data = [
                            "target"                => "group",
                            "response"              => "The following is a list of stakes : \n".$get_list_stakes,
                            "value"                 => $get_group_id,
                        ];
                        return response()->json(["success" => $list_stakes_data], $this->successStatus);
                    }
                    else
                    {
                        $error_data = [
                            "target"                => "group",
                            "response"              => "No list stakes available",
                            "value"                 => $get_group_id,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "group",
                        "response"  => "Group Unlisted",
                        "value"     => $get_group_id
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "group",
                    "response"  => "You must enter the group ID",
                    "value"     => "",
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

    //TOP UP HOST
        public function top_up_agent()
        {
            //PARAMETER
                $get_ph_number_master_agent     = request('wa_ph_number_master_agent');
                $get_ph_number_agent            = request('wa_ph_number_agent');
                $get_credit_top_ups             = request('credit_top_up');

            if($get_ph_number_master_agent != '')
            {
                if($get_ph_number_agent != '')
                {
                    if($get_credit_top_ups != '')
                    {
                        if(is_numeric($get_credit_top_ups))
                        {
                                $get_master_agent      = \App\Master_user::where('phone_number_users',$get_ph_number_master_agent)
                                                                    ->first();
                                if($get_master_agent != '')
                                {
                                    $get_agent   = \App\Master_user::where('phone_number_users',$get_ph_number_agent)
                                                                    ->first();
                                    if($get_agent != '')
                                    {
                                        $id_master_agent        = $get_master_agent->id;
                                        $id_agent               = $get_agent->id;
                                        $check_master_agent     = \App\Master_user::where('id',$id_agent)
                                                                                ->where('sub_users_id',$id_master_agent)
                                                                                ->first();
                                        if($check_master_agent != '')
                                        {
                                            $credit_master_agent = $get_master_agent->credit_users;
                                            if($credit_master_agent >= $get_credit_top_ups)
                                            {
                                                $top_ups_data = [
                                                    'from_users_id' => $get_ph_number_master_agent,
                                                    'to_users_id'   => $get_ph_number_agent,
                                                    'date_top_ups'  => date('Y-m-d'),
                                                    'time_top_ups'  => date('H:i:s'),
                                                    'credit_top_ups'=> $get_credit_top_ups,
                                                ];
                                                \App\Master_top_up::insert($top_ups_data);

                                                $credit_agent    = $check_master_agent->credit_users;
                                                $calculate_agent = $credit_agent + $get_credit_top_ups;
                                                $agent_data = [
                                                    'credit_users' => $calculate_agent
                                                ];
                                                \App\Master_user::where('id',$id_agent)->update($agent_data);

                                                $calculate_master_agent = $credit_master_agent - $get_credit_top_ups;
                                                $master_agent_data      = [
                                                    'credit_users'  => $calculate_master_agent
                                                ];
                                                \App\Master_user::where('id',$id_master_agent)->update($master_agent_data);

                                                $success_data = [
                                                    "target"    => "private",
                                                    "response"  => "Congratulations you successfully fill credit to no ".$get_ph_number_agent,
                                                    "value"     => $get_ph_number_master_agent
                                                ];
                                                return response()->json(["success" => $success_data], $this->successStatus);
                                            }
                                            else
                                                $error_data = [
                                                    "target"    => "private",
                                                    "response"  => "Your credit not enough. Your current credit is ".$credit_master_agent,
                                                    "value"     => $get_ph_number_master_agent
                                                ];
                                        }
                                        else
                                            $error_data = [
                                                "target"    => "private",
                                                "response"  => "Your is not master agent this ".$get_ph_number_agent." agent",
                                                "value"     => $get_ph_number_master_agent
                                            ];
                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => "Phone number agent unlisted",
                                            "value"     => $get_ph_number_master_agent
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "Credit should be a number",
                                        "value"     => $get_ph_number_master_agent
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "Phone number master agent unlisted",
                                "value"     => $get_ph_number_master_agent
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "You must enter the credit top up",
                            "value"     => $get_ph_number_master_agent
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "You must enter the phone number agent",
                        "value"     => $get_ph_number_master_agent
                    ];
                    return response()->json(["error" => ""], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "You must enter the phone number master agent",
                    "value"     => ""
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

    //TOP UP GROUP
        public function top_up_group()
        {
            //PARAMETER
                $get_ph_number      = request('wa_ph_number');
                $get_group_name     = request('wa_group_name');
                $get_credit_group   = request('credit_groups');

            if($get_ph_number != '')
            {
                if($get_group_name != '')
                {
                    if($get_credit_group != '')
                    {
                        if(is_numeric($get_credit_group))
                        {
                            $check_group    = \App\Master_group::where('name_groups',$get_group_name)
                                                                ->first();
                            if($check_group != '')
                            {
                                $id_groups          = $check_group->id_groups;
                                $id_users_group     = $check_group->users_id;
                                $get_agent           = \App\Master_user::where('id',$id_users_group)->first();
                                if($get_agent->phone_number_users == $get_ph_number)
                                {
                                    $credit_groups = $check_group->credit_groups;
                                    $calculate_credit_group = $credit_groups + $get_credit_group;
                                    $group_data = [
                                        'credit_groups' => $calculate_credit_group,
                                    ];
                                    \App\Master_group::where('id_groups', $id_groups)->update($group_data);

                                    $success_data = [
                                        "target"    => "private",
                                        "response"  => "Congratulations you successfully fill credit to group ".$get_group_name,
                                        "value"     => $get_ph_number 
                                    ];
                                    return response()->json(["success" => $success_data], $this->successStatus);
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "Your not agent in ".$get_group_name." group",
                                        "value"     => $get_ph_number,
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "Group unlisted",
                                    "value"     => $get_ph_number
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "Credit should be a number",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "You must enter the credit",
                            "value"     => $get_ph_number
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "You must enter the name of group",
                        "value"     => $get_ph_number, 
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "You must enter the phone number",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

    //SESSION STATUS (CRONJOB)
        public function end_sessions()
        {
            $check_sessions = \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
                                                  ->where('status_active_sessions',1)
                                                  ->get();
            foreach($check_sessions as $sessions)
            {
                $id_sessions         = $sessions->id_sessions;
                $date_now            = date('Y-m-d H:i:s');
                $start_date_sessions = $sessions->start_date_sessions;
                $end_date_sessions   = $sessions->end_date_sessions;
                if(strtotime($date_now) < strtotime($start_date_sessions) && strtotime($date_now) < strtotime($end_date_sessions))
                    $status_sessions = '0';
                elseif(strtotime($date_now) >= strtotime($start_date_sessions) && strtotime($date_now) <= strtotime($end_date_sessions))
                    $status_sessions = '1';
                elseif(strtotime($date_now) >= strtotime($start_date_sessions) && strtotime($date_now) >= strtotime($end_date_sessions))
                    $status_sessions = '2';

                if($status_sessions == '2')
                {
                    $check_game = \App\Master_game::where('sessions_id',$id_sessions)
                                                    ->where('status_active_games',2)
                                                    ->get();
                    if($check_game != '')
                    {
                        foreach($check_game as $game)
                        {
                            $start_date_games    = $game->start_date_games;
                            $end_date_games      = $game->end_date_games;
                            if(strtotime($date_now) < strtotime($start_date_games) && strtotime($date_now) < strtotime($end_date_games))
                                $status_game         = '0';
                            elseif(strtotime($date_now) >= strtotime($start_date_games) && strtotime($date_now) <= strtotime($end_date_games))
                                $status_game         = '1';
                            elseif(strtotime($date_now) >= strtotime($start_date_games) && strtotime($date_now) >= strtotime($end_date_games))
                                $status_game         = '2';

                            if($status_game == '2')
                            {
                                $get_group_name = $check_sessions->name_groups;
                                $get_group      = \App\Master_group::where('name_groups',$get_group_name)->first();
                                if($get_group != '')
                                {
                                    $id_group       = $get_group->id_groups;
                                    $credit_group   = $get_group->credit_groups;
                                    $check_agent     = \App\Master_group::join('users','users_id','=','users.id')
                                                                    ->where('id_groups',$id_group)
                                                                    ->first();
                                    if($check_agent != '')
                                    {
                                        $check_game = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                                        ->where('groups_id',$id_group)
                                                                        ->where('status_active_games','1')
                                                                        ->first();
                                        if($check_game != '')
                                        {
                                            $id_games   = $check_game->id_games;
                                            $rtp_games  = $check_game->rtp_games;

                                            $get_total_all_stake = \App\Master_stake::selectRaw('SUM(value_stakes) AS total_all_stakes')
                                                                                    ->where('games_id',$id_games)
                                                                                    ->first();
                                            if($get_total_all_stake != '')
                                                $total_all_stakes = $get_total_all_stake->total_all_stakes;
                                            else
                                                $total_all_stakes = 0;

                                            $get_calculate_rtp = \App\Master_stake::selectRaw('name_list_stakes,
                                                                                                (
                                                                                                    ROUND(
                                                                                                            (('.$total_all_stakes.' - (sum(value_stakes) * 10)) / '.$total_all_stakes.') * 100, 2
                                                                                                        )
                                                                                                ) AS calculate_rtp')
                                                                                    ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                                                                    ->where('games_id',$id_games)
                                                                                    ->groupBy('id_list_stakes')
                                                                                    ->having('calculate_rtp','>',$rtp_games)
                                                                                    ->orderBy('calculate_rtp')
                                                                                    ->limit(1)
                                                                                    ->first();
                                            if($get_calculate_rtp != '')
                                                $stakes_winner         = $get_calculate_rtp->name_list_stakes; 
                                            else
                                            {
                                                $get_winner_optional = \App\Master_stake::selectRaw('name_list_stakes,
                                                                                                    (
                                                                                                        ROUND(
                                                                                                                (('.$total_all_stakes.' - (sum(value_stakes) * 10)) / '.$total_all_stakes.') * 100, 2
                                                                                                            )
                                                                                                    ) AS calculate_rtp')
                                                                                        ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                                                                        ->where('games_id',$id_games)
                                                                                        ->groupBy('id_list_stakes')
                                                                                        ->having('calculate_rtp','<',$rtp_games)
                                                                                        ->orderBy('calculate_rtp','desc')
                                                                                        ->limit(1)
                                                                                        ->first();
                                                if($get_winner_optional != '')
                                                    $stakes_winner         = $get_winner_optional->name_list_stakes;
                                                else
                                                    $stakes_winner         = 'No Winner';
                                            }

                                            if($stakes_winner != 'No Winner')
                                            {
                                                $get_member_winner = \App\Master_stake::selectRaw('CONCAT(SUBSTRING(`phone_number_register_members`, 1, CHAR_LENGTH(`phone_number_register_members`) - 5),"****") as phone_number,
                                                                                                    name_list_stakes,
                                                                                                    SUM(value_stakes * 10) AS profit,
                                                                                                    id_register_members,
                                                                                                    id_stakes,
                                                                                                    credit_register_members')
                                                                                        ->join('master_register_members','register_members_id','master_register_members.id_register_members')
                                                                                        ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                                                                        ->where('name_list_stakes',$stakes_winner)
                                                                                        ->where('games_id',$id_games)
                                                                                        ->groupBy('id_register_members')
                                                                                        ->get();

                                                foreach($get_member_winner as $member_winner)
                                                {
                                                    $winloses_data = [
                                                        'stakes_id'         => $member_winner->id_stakes,
                                                        'profit_winloses'   => $member_winner->profit
                                                    ];
                                                    \App\Master_winlose::insert($winloses_data);

                                                    $id_register_members        = $member_winner->id_register_members;
                                                    $calculate_credit_register_members = $member_winner->credit_register_members + $member_winner->profit;
                                                    $credit_register_members_data = [
                                                        'credit_register_members' => $calculate_credit_register_members
                                                    ];
                                                    \App\Master_register_member::where('id_register_members',$id_register_members)->update($credit_register_members_data);
                                                }

                                                $get_total_winlose      = \App\Master_winlose::selectRaw('SUM(profit_winloses) AS total_winlose')
                                                                                                ->join('master_stakes','stakes_id','=','master_stakes.id_stakes')
                                                                                                ->join('master_games','games_id','=','master_games.id_games')
                                                                                                ->where('games_id',$id_games)
                                                                                                ->first();

                                                $calculate_credit_group = $credit_group + ($total_all_stakes - $get_total_winlose->total_winlose);
                                                $credit_group_data      = [
                                                    'credit_groups' => $calculate_credit_group
                                                ];
                                                \App\Master_group::where('id_groups',$id_group)->update($credit_group_data);

                                                $games_data = [
                                                    'end_date_games'     => date('Y-m-d H:i:s'),
                                                    'status_active_games'=> 2
                                                ];
                                                \App\Master_game::where('id_games',$id_games)->update($games_data);
                                                return response()->json(["success" => $get_member_winner], $this->successStatus);
                                            }
                                            else
                                                return response()->json(["error" => $get_group_name."\n No winner in this game"], $this->errorStatus);
                                        }
                                        else
                                            return response()->json(["error" => $get_group_name."\n No game is active"], $this->errorStatus);
                                    }
                                    else
                                        return response()->json(["error" => $get_group_name."\n Your not agent in this group"], $this->errorStatus);
                                }
                                else
                                    return response()->json(["error" => $get_group_name."\n Group Unlisted"], $this->errorStatus);
                            }
                        }
                    }
                }

                $sessions_data = [
                    'status_active_sessions'    => $status_sessions
                ];
                \App\Master_session::where('id_sessions',$id_sessions)
                                    ->update($sessions_data);
            }
            return response()->json(["success" => "Its Worked"], $this->successStatus);
        }
}