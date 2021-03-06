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

    /* MASTER AGENT */
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
                            if($get_credit_top_ups > 0)
                            {
                                $get_master_agent      = \App\Master_user::where('phone_number_users',$get_ph_number_master_agent)
                                                                    ->first();
                                if($get_master_agent != '')
                                {
                                    if(Shwetech::checkBOT($get_master_agent->id) == 1)
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
                                                        'from_users_id'             => $get_master_agent->id,
                                                        'to_users_id'               => $get_agent->id,
                                                        'to_register_members_id'    => 0,
                                                        'date_top_ups'              => date('Y-m-d'),
                                                        'time_top_ups'              => date('H:i:s'),
                                                        'credit_top_ups'            => $get_credit_top_ups,
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
                                                        "response"  => "🎆*Congratulations‼*🎆 you successfully fill *credit* to agent *".$get_ph_number_agent."*",
                                                        "value"     => $get_ph_number_master_agent
                                                    ];
                                                    return response()->json(["success" => $success_data], $this->successStatus);
                                                }
                                                else
                                                {
                                                    $error_data = [
                                                        "target"    => "private",
                                                        "response"  => "⛔ Your *credit* not enough. Your *current credit* is *".$credit_master_agent."*",
                                                        "value"     => $get_ph_number_master_agent
                                                    ];
                                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                                }
                                            }
                                            else
                                            {
                                                $error_data = [
                                                    "target"    => "private",
                                                    "response"  => "⛔ Your is not the *master agent* of *".$get_ph_number_agent."*",
                                                    "value"     => $get_ph_number_master_agent
                                                ];
                                                return response()->json(["error" => $error_data], $this->errorStatus);
                                            }
                                        }
                                        else
                                        {
                                            $error_data = [
                                                "target"    => "private",
                                                "response"  => "⛔ *Phone number agent* unlisted",
                                                "value"     => $get_ph_number_master_agent
                                            ];
                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                        }
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                            "value"     => $get_ph_number,
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ *Phone number master agent* unlisted",
                                        "value"     => $get_ph_number_master_agent
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "⛔ *Credit* must be greater than 0",
                                    "value"     => $get_ph_number_master_agent,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ *Credit* should be a number",
                                "value"     => $get_ph_number_master_agent
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ You must enter the *credit top up*",
                            "value"     => $get_ph_number_master_agent
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *phone number agent*",
                        "value"     => $get_ph_number_master_agent
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *phone number master agent*",
                    "value"     => $get_ph_number_master_agent
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function mahelp()
        {
            //PARAMETER
                $get_ph_number                  = request('wa_ph_number');

            if($get_ph_number != '')
            {
                $check_master_agent = \App\Master_user::where('phone_number_users',$get_ph_number)->first();
                if($check_master_agent != '')
                {
                    $id_level_systems = $check_master_agent->level_systems_id;
                    if(Shwetech::checkBOT($check_master_agent->id) == 1)
                    {
                        if($id_level_systems == 2)
                        {
                            $get_bot_phone_number       = \Request::segment(2);
                            $get_bots                   = \App\Master_bot::where('phone_number_bots',$get_bot_phone_number)->first();
                            $name_bots                  = $get_bots->name_bots;

                            $success_data = [
                                "target"    => "private",
                                "response"  => "🆘 Hi, I am your BOT, my name is *".$name_bots."*, *Here is some command i understand* :
                                                \n🏷 Create agent = *#areg*[space]*phone number*[space]*email*[space]*credit*
                                                \n🏷 Top up agent = *#tpagent*[space]*agent phone number*[space]*credit*",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["success" => $success_data], $this->successStatus);
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ Your not *master agent*",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ *Phone number* unlisted",
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *phone number*",
                    "value"     => $get_ph_number
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function check_credit_master_agent()
        {
            //PARAMETER
                $get_ph_number = request('wa_ph_number');

            if($get_ph_number != '')
            {
                $get_master_agent = \App\Master_user::where('phone_number_users',$get_ph_number)
                                                    ->first();
                if($get_master_agent != '')
                {
                    $id_master_agent    = $get_master_agent->id;
                    $id_level_systems   = $get_master_agent->level_systems_id;
                    if(Shwetech::checkBOT($id_master_agent) == 1)
                    {
                        if($id_level_systems == 2)
                        {
                            $success_master_agent_data = [
                                "target"    => "private",
                                "response"  => "💰 Your *credit* : *".$get_master_agent->credit_users."*",
                                "value"     => $get_ph_number
                            ];

                            $total_agent = \App\Master_user::where('sub_users_id',$id_master_agent)->count();

                            if($total_agent != 0)
                            {
                                $get_agent = \App\Master_user::select('name',
                                                                        'email',
                                                                        'phone_number_users AS phone number',
                                                                        'credit_users AS credit',
                                                                        'max_group_users AS max group')
                                                            ->where('sub_users_id',$id_master_agent)
                                                            ->get();
                            }
                            else
                                $get_agent = "";

                            $success_agent_data = [
                                "target"    => "private",
                                "response"  => $get_agent,
                                "value"     => $get_ph_number
                            ];

                            return response()->json(["success_master_agent" => $success_master_agent_data, "success_agent" => $success_agent_data], $this->successStatus);
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ Your not *master agent*",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ *Phone number* unlisted",
                        "value"     => $get_ph_number,
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *phone number*",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function create_agent()
        {
            //PARAMETER
                $get_ph_number      = request('wa_ph_number');
                $get_agent_number   = request('wa_ph_number_agent');
                $get_agent_email    = request('email_agent');
                $get_credit_users   = request('credit_agent');

            if($get_ph_number != '')
            {
                if($get_agent_number != '')
                {
                    if($get_agent_email != '')
                    {
                        if($get_credit_users != '')
                        {
                            $check_available_email = \App\Master_user::where('email',$get_agent_email)->count();
                            if($check_available_email == 0)
                            {
                                if (filter_var($get_agent_email, FILTER_VALIDATE_EMAIL))
                                {
                                    if(is_numeric($get_credit_users))
                                    {
                                        $check_master_agent = \App\Master_user::where('phone_number_users',$get_ph_number)
                                                                                ->first();
                                        if($check_master_agent != '')
                                        {
                                            if(Shwetech::checkBOT($check_master_agent->id) == 1)
                                            {
                                                if($check_master_agent->level_systems_id == 2)
                                                {
                                                    $check_number_agent = \App\Master_user::where('phone_number_users',$get_agent_number)
                                                                                            ->first();
                                                    if($check_number_agent == '')
                                                    {
                                                        if($get_credit_users > 0)
                                                        {
                                                            if($check_master_agent->credit_users >= $get_credit_users)
                                                            {
                                                                $create_agent_data = [
                                                                    'sub_users_id'          => $check_master_agent->id,
                                                                    'level_systems_id'      => 3,
                                                                    'name'                  => $get_agent_number,
                                                                    'email'                 => $get_agent_email,
                                                                    'phone_number_users'    => $get_agent_number,
                                                                    'bots_id'               => $check_master_agent->bots_id,
                                                                    'credit_users'          => $get_credit_users,
                                                                    'max_group_users'       => 100,
                                                                    'created_at'            => date('Y-m-d H:i:s'),
                                                                    'updated_at'            => date('Y-m-d H:i:s'),
                                                                    'password'              => bcrypt($get_agent_number),
                                                                    'remember_token'        => str_random(100)
                                                                ];
                                                                \App\Master_user::insert($create_agent_data);

                                                                $calculate_credit_master_agent = $check_master_agent->credit_users - $get_credit_users;
                                                                $credit_master_agent_data    = [
                                                                    'credit_users'          => $calculate_credit_master_agent
                                                                ];
                                                                \App\Master_user::where('id',$check_master_agent->id)->update($credit_master_agent_data);

                                                                $success_agent_data = [
                                                                    "target"    => "private",
                                                                    "response"  => "🎆*Congratulations‼*🎆 You have successfully created the *agent* 👪
                                                                                    \n🏷 Email : *".$get_agent_email."*
                                                                                    \n🏷 Password : *".$get_agent_number."*
                                                                                    \n🏷Phone Number : *".$get_agent_number."*
                                                                                    \n🏷 Credit : *".$get_credit_users."*
                                                                                    \n🏷 This data can be used to login at trivia.shweapi.com/login
                                                                                    \nfor display help guide, please type #ahelp in group with your master agent",
                                                                    "value"     => $get_agent_number
                                                                ];

                                                                $success_master_agent_data = [
                                                                    "target"    => "private",
                                                                    "response"  => "🎆*Congratulations‼*🎆 You have successfully create the agent ".$get_agent_number."
                                                                                    \nwith set credit ".$get_credit_users.".
                                                                                    \nYour current balance is ".$check_master_agent->credit_users,
                                                                    "value"     => $get_ph_number
                                                                ];

                                                                return response()->json(["success_agent" => $success_agent_data, "success_master_agent" => $success_master_agent_data], $this->successStatus);
                                                            }
                                                            else
                                                            {
                                                                $error_data = [
                                                                    "target"    => "private",
                                                                    "response"  => "⛔ Your *credit* is not enough. Your *credit* : *".$check_master_agent->credit_users."*",
                                                                    "value"     => $get_ph_number
                                                                ];
                                                                return response()->json(["error" => $error_data], $this->errorStatus);
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $error_data = [
                                                                "target"    => "private",
                                                                "response"  => "⛔ *Credit* must be greater than *0*",
                                                                "value"     => $get_ph_number
                                                            ];
                                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $id_master_agent    = $check_number_agent->sub_users_id;
                                                        $get_master_agent   = \App\Master_user::where('id',$id_master_agent)->first();
                                                        if($get_master_agent != '')
                                                        {
                                                            $error_data = [
                                                                "target"    => "private",
                                                                "response"  => "⛔ *Phone number* already registered.
                                                                                \nThis *phone number* is agent from *".$get_master_agent->phone_number_users."*",
                                                                "value"     => $get_ph_number
                                                            ];
                                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                                        }
                                                        else
                                                        {
                                                            $error_data = [
                                                                "target"    => "private",
                                                                "response"  => "⛔ *Phone number* already registered. Please register another *phone number*",
                                                                "value"     => $get_ph_number
                                                            ];
                                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    $error_data = [
                                                        "target"    => "private",
                                                        "response"  => "⛔ Your not *master agent*",
                                                        "value"     => $get_ph_number
                                                    ];
                                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                                }
                                            }
                                            else
                                            {
                                                $error_data = [
                                                    "target"    => "private",
                                                    "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                                    "value"     => $get_ph_number,
                                                ];
                                                return response()->json(["error" => $error_data], $this->errorStatus);
                                            }
                                        }
                                        else
                                        {
                                            $error_data = [
                                                "target"    => "private",
                                                "response"  => "⛔ *Phone number* unlisted",
                                                "value"     => $get_ph_number,
                                            ];
                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                        }
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => "⛔ *Credit* should be a number",
                                            "value"     => $get_ph_number
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ Invalid *email* format. ex : *info@trivia.com*",
                                        "value"     => $get_ph_number
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response" => "⛔ *Email* already registered. Please choose another *email*",
                                    "value"     => $get_ph_number
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ You must enter the *credit*",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ You must enter the *agent email*",
                            "value"     => $get_ph_number
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *agent phone number*",
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *phone number*",
                    "value"     => $get_ph_number
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }
    /* MASTER AGENT */

    /* AGENT */
        public function check_master_agent_number()
        {
            //PARAMETER
                $get_group_id           = request('wa_group_id');
                $get_agent_phone_number = request('wa_ph_number');

            if($get_group_id != '')
            {
                if($get_agent_phone_number != '')
                {
                    $check_phone_number_agent = \App\Master_user::where('phone_number_users',$get_agent_phone_number)->first();
                    if($check_phone_number_agent != '')
                    {
                        $check_group_agent = \App\Master_group::where('whatsapp_group_id',$get_group_id)->count();
                        if($check_group_agent == 0)
                        {
                            $get_master_agent = $check_phone_number_agent->sub_users_id;
                            $check_master_agent = \App\Master_user::where('id',$get_master_agent)->first();
                            if($check_master_agent != '')
                            {
                                if(Shwetech::checkBOT($get_master_agent) == 1)
                                {
                                    $success_data = [
                                        "target"    => "group",
                                        "response"  => array("master_agent_ph_number" => $check_master_agent->phone_number_users),
                                        "value"     => $get_group_id
                                    ];
                                    return response()->json(["success" => $success_data], $this->successStatus);
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                        "value"     => $get_ph_number,
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "group",
                                    "response"  => "⛔ *Master agent* unlisted",
                                    "value"     => $get_group_id,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $get_group        = \App\Master_group::where('whatsapp_group_id',$get_group_id)->first();
                            $get_group_name   = $get_group->name_groups;
                            $error_data = [
                                "target"    => "private",
                                "response"  => "🆔".$get_group_name."🆔
                                                \n⛔ This is not manual group from master agent created",
                                "value"     => $get_agent_phone_number,
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "group",
                            "response"  => "⛔ Your not *agent*",
                            "value"     => $get_group_id
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "group",
                        "response"  => "⛔ You must enter the *phone number*",
                        "value"     => $get_group_id
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "group",
                    "response"  => "⛔ You must enter the *group ID*",
                    "value"     => $get_group_id,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function create_group()
        {
            if($this->check_master_agent_number())
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
                            $get_agent = \App\Master_user::where('phone_number_users',$get_phone_number)
                                                        ->first();
                            if($get_agent != '')
                            {
                                if(Shwetech::checkBOT($get_agent->id) == 1)
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
                                                    if($credit_users > 0)
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
                                                                "response"  => "🎆*Congratulations‼*🎆 Your ".$get_group_name." has successfully created.
                                                                                \nAt the first, please create sessions by sending command bellow :
                                                                                \n🏷 *#session*[space]*group name*[space]*credit / member*[space]*day duration*
                                                                                \nfor example:
                                                                                \n🏷 *#session trivia 5000 7*
                                                                                \nabove command means that when a *player register*, each player get *5000* credit upon registration in sessions. And session will run for *7 days*",
                                                                "value"     => $get_phone_number,
                                                            ];
                                                            return response()->json(["success" => $success_data], $this->successStatus);
                                                        }
                                                        else
                                                        {
                                                            $error_data = [
                                                                "target"    => "private",
                                                                "response"  => "⛔ Group *".$get_group_name."* already exits. Please find another *name* for your *group*",
                                                                "value"     => $get_phone_number,
                                                            ];
                                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $error_data = [
                                                            "target"    => "private",
                                                            "response"  => "⛔ Your credit is *0*. You can't create *group* anymore.\nPlease top up to your *master agent* - *".$get_phone_master_agent."*",
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
                                                                "response"  => "🎆*Congratulations‼*🎆 Your ".$get_group_name." has successfully created.
                                                                                \nAt the first, please create sessions by sending command bellow :
                                                                                \n🏷 *#session*[space]*group name*[space]*credit / member*[space]*day duration*
                                                                                \nfor example:
                                                                                \n🏷 *#session trivia 5000 7*
                                                                                \nabove command means that when a *player register*, each player get *5000* credit upon registration in sessions. And session will run for *7 days*",
                                                                "value"     => $get_phone_number,
                                                            ];
                                                            return response()->json(["success" => $success_data], $this->successStatus);
                                                        }
                                                        else
                                                        {
                                                            $error_data = [
                                                                "target"    => "private",
                                                                "response"  => "⛔ Group *".$get_group_name."* already exist. Please find another *name* for your *group*",
                                                                "value"     => $get_phone_number
                                                            ];
                                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $error_data = [
                                                            "target"    => "private",
                                                            "response"  => "⛔ Your *credit* is not *enough*. Your current *credit* is *".$credit_users."*",
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
                                                    "response"  => "⛔ *Credit* should be a number",
                                                    "value"     => $get_phone_number
                                                ];
                                                return response()->json(["error" => $error_data], $this->errorStatus);
                                            }
                                        }
                                        else
                                        {
                                            $error_data = [
                                                "target"    => "private",
                                                "response"  => "⛔ Your *group* has reached the limit",
                                                "value"     => $get_group_name,
                                            ];
                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                        }
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => "⛔ Your not *agent*",
                                            "value"     => $get_phone_number,
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                        "value"     => $get_ph_number,
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "⛔ *Number* Not listed",
                                    "value"     => $get_phone_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ *Group name* must not have spaces",
                                "value"     => $get_phone_number,
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }

                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ You must enter the *phone number*",
                            "value"     => "",
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *group name*",
                        "value"     => $get_phone_number,
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
        }

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
                                if(Shwetech::checkBOT($get_group->id) == 1)
                                {
                                    $id_group = $get_group->id_groups;
                                    $group_data = [
                                        'whatsapp_group_id' => $get_group_id
                                    ];
                                    \App\Master_group::where('id_groups',$id_group)->update($group_data);

                                    $success_data = [
                                        "target"    => "private",
                                        "response"  => "🎆*Congratulations‼*🎆 Your ".$get_group_name." has successfully created.
                                                        \nAt the first, please create sessions by sending command bellow :
                                                        \n🏷 *#session*[space]*group name*[space]*credit / member*[space]*day duration*
                                                        \nfor example:
                                                        \n🏷 *#session trivia 5000 7*
                                                        \nabove command means that when a *player register*, each player get *5000* credit upon registration in sessions. And session will run for *7 days*",
                                        "value"     => $get_ph_number,
                                    ];
                                    return response()->json(['success' => $success_data], $this->successStatus);
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                        "value"     => $get_ph_number,
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "⛔ Your not *agent* in *".$get_group_name."* group",
                                    "value"     => $get_ph_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ *Group* unlisted",
                                "value"     => $get_ph_number,
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ You must enter the *phone number*",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *group name*",
                        "value"     => $get_ph_number,
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *whatsapp group ID*",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

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
                            $id_agent                   = $get_group->id;
                            if(Shwetech::checkBOT($id_agent) == 1)
                            {
                                if($get_group->phone_number_users == $get_ph_number)
                                {
                                    $credit_groups              = $get_group->credit_groups;
                                    if($credit_groups > 0)
                                    {
                                        if($credit_groups >= $get_credit_member)
                                        {
                                            $check_sessions = \App\Master_session::where('groups_id',$id_group)
                                                                                ->where('end_date_sessions', '>' ,$date_now)
                                                                                ->count();
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
                                                            "response"  => $get_group_name."\nDay should be a number",
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
                                                    "response"  => "*".$get_group_name."*
                                                                    \n🎆*Congratulations‼*🎆 Your *sessions* has successfully created.
                                                                    \nThis *sessions* :
                                                                    \n🏷 Started at : *".Shwetech::changeDBToDatetime($get_start_date)."*
                                                                    \n🏷 Finished at : *".Shwetech::changeDBToDatetime($get_end_date)."*
                                                                    \nThe next stage, please *create* your *game* first by sending this command bellow:
                                                                    \n🏷 *#autorun*[space]*group name*
                                                                    \nFor example :
                                                                    \n🏷 *#autorun trivia*",
                                                    "value"     => $get_ph_number,
                                                ];
                                                return response()->json(["success" => $success_data], $this->successStatus);
                                            }
                                            $error_data = [
                                                "target"    => "private",
                                                "response"  => "⛔ You have an active *session*",
                                                "value"     => $get_ph_number,
                                            ];
                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                        }
                                        else
                                        {
                                            $error_data = [
                                                "target"    => "private",
                                                "response"  => "*".$get_group_name."*
                                                                \n*Credit group* not enough. *Credit ".$get_group_name."* is *".$credit_groups."*",
                                                "value"     => $get_ph_number,
                                            ];
                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                        }
                                    }
                                    elseif($credit_groups <= 0)
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => "*".$get_group_name."*
                                                            \n*Credit group* not enough. *Credit ".$get_group_name."* is *".$credit_groups."*",
                                            "value"     => $get_ph_number,
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ Your not *agent* in *".$get_group_name."* group",
                                        "value"     => $get_ph_number,
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                    "value"     => $get_ph_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "*".$get_group_name."*
                                                \n*Group* unlisted",
                                "value"     => $get_ph_number,
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ You must enter the *credit member*",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *phone number*",
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *group name*",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function create_game()
        {
            //PARAMETER
                $get_group_name = request('wa_group_name');
                $get_ph_number  = request('wa_ph_number');
                // $get_rtp        = request('rtp_game');

            if($get_group_name != '')
            {
                if($get_ph_number != '')
                {
                    // if($get_rtp != '')
                    // {
                        // if(is_numeric($get_rtp))
                        // {
                            // if($get_rtp > 0 && $get_rtp <= 100)
                            // {
                                $date_now               = date('Y-m-d H:i:s');
                                $check_group            = \App\Master_group::join('users','users_id','=','users.id')
                                                                            ->where('name_groups',$get_group_name)
                                                                            ->where('phone_number_users',$get_ph_number)
                                                                            ->count();
                                if($check_group != 0)
                                {
                                    $get_last_sessions  = \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
                                                                                ->where('name_groups',$get_group_name)
                                                                                ->where('status_active_sessions',1)
                                                                                ->first();
                                    if($get_last_sessions != '')
                                    {
                                        $id_sessions    = $get_last_sessions->id_sessions;
                                        $check_games    = \App\Master_game::where('sessions_id',$id_sessions)
                                                                            ->first();
                                        if($check_games != '')
                                        {
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
                                                        if(Shwetech::checkBOT($check_phone_number_agent->id) == 1)
                                                        {
                                                            $games_data     = [
                                                                'sessions_id'           => $id_sessions,
                                                                'start_date_games'      => '0000-00-00 00:00:00',
                                                                'end_date_games'        => '0000-00-00 00:00:00',
                                                                // 'rtp_games'             => $get_rtp,
                                                                'status_active_games'   => 0,
                                                            ];
                                                            \App\Master_game::insert($games_data);

                                                            $success_data = [
                                                                "target"    => "private",
                                                                // "response"  => $get_group_name."\nAwesome! Your game settings are:\nReturn to Player = ".$get_rtp." \n ------------------------------- \nNow you can start the game by enter :\n#start ".$get_group_name." duration (in minutes).\nBefore you start your game, make sure you have invited your friends to join in ".$get_group_name." group. Then you can start the game",
                                                                "response"  => "*".$get_group_name."*
                                                                                \n🎆*Congratulations‼*🎆 Your game will start automatically!!! make sure you have invited your *friends* to join in *".$get_group_name."*",
                                                                "value"     => $get_ph_number
                                                            ];
                                                            return response()->json(["success" => $success_data], $this->successStatus);
                                                        }
                                                        else
                                                        {
                                                            $error_data = [
                                                                "target"    => "private",
                                                                "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                                                "value"     => $get_ph_number,
                                                            ];
                                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $error_data = [
                                                            "target"        => "private", 
                                                            "response"      => "⛔ Your not *agent* in *".$get_group_name." group*",
                                                            "value"         => $get_ph_number
                                                        ];
                                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                                    }
                                                }
                                                else
                                                {
                                                    $error_data = [
                                                        "target"    => "private",
                                                        "response"  => "⛔ ".$get_group_name."
                                                                        \nThere are *games* that have not been started in the current *sessions*",
                                                        "value"     => $get_ph_number
                                                    ];
                                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                                }
                                            }
                                            else
                                            {
                                                $error_data = [
                                                    "target"    => "private",
                                                    "response"  => "⛔ *".$get_group_name."*
                                                                    \nThere is an active *game*",
                                                    "value"     => $get_ph_number,
                                                ];
                                                return response()->json(["error" => $error_data], $this->errorStatus);
                                            }
                                        }
                                        else
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
                                                    // 'rtp_games'             => $get_rtp,
                                                    'status_active_games'   => 0,
                                                ];
                                                \App\Master_game::insert($games_data);

                                                $success_data = [
                                                    "target"    => "private",
                                                    // "response"  => $get_group_name."\nAwesome! Your game settings are:\nReturn to Player = ".$get_rtp." \n ------------------------------- \nNow you can start the game by enter :\n#start ".$get_group_name." duration (in minutes).\nBefore you start your game, make sure you have invited your friends to join in ".$get_group_name." group. Then you can start the game",
                                                    "response"  => "*".$get_group_name."*
                                                                    \n🎆*Congratulations‼*🎆 Your game will start automatically!!! make sure you have invited your *friends* to join in *".$get_group_name."*",
                                                    "value"     => $get_ph_number
                                                ];
                                                return response()->json(["success" => $success_data], $this->successStatus);
                                            }
                                            else
                                            {
                                                $error_data = [
                                                    "target"        => "private",
                                                    "response"      => "⛔ Your not *agent* in *".$get_group_name."* group",
                                                    "value"         => $get_ph_number
                                                ];
                                                return response()->json(["error" => $error_data], $this->errorStatus);
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => "⛔ *".$get_group_name."*
                                                            \n*Group* doesn't have any *sessions* active",
                                            "value"     => $get_ph_number,
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ *Group* unlisted",
                                        "value"     => $get_ph_number
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                    //         }
                    //         else
                    //         {
                    //             $error_data =[
                    //                 "target"    => "private",
                    //                 "response"  => "RTP must be set 1 to 100",
                    //                 "value"     => $get_ph_number,
                    //             ];
                    //             return response()->json(["error" => $error_data], $this->errorStatus);
                    //         }
                    //     }
                    //     else
                    //     {
                    //         $error_data = [
                    //             "target"    => "private",
                    //             "response"  => "RTP should be a number",
                    //             "value"     => $get_ph_number
                    //         ];
                    //         return response()->json(["error" => $error_data], $this->errorStatus);
                    //     }
                    // }
                    // else
                    // {
                    //     $error_data = [
                    //         "target"    => "private",
                    //         "response"  => "You must enter the RTP (Return To Player)",
                    //         "value"     => $get_ph_number
                    //     ];
                    //     return response()->json(["error" => $error_data], $this->errorStatus);
                    // }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *phone number*",
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *group name*",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

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
                            if(Shwetech::checkBOT($check_agent->id) == 1)
                            {
                                $get_group = \App\Master_group::join('users','users_id','=','users.id')
                                                            ->where('id_groups',$id_group)
                                                            ->where('phone_number_users',$get_ph_number)
                                                            ->first();
                                $get_group_id               = $get_group->whatsapp_group_id;
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
                                            return response()->json(["error" => $get_group_name."\nMinutes should be a number"], $this->errorStatus);
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

                                    $success_private_data = [
                                        "target"    => "private",
                                        "response"  => "*".$get_group_name."*
                                                        \n🎆*Congratulations‼*🎆 *Game* *starts* from *now* and will *end* in *".Shwetech::changeDBToDatetime($get_end_date)."*",
                                        "value"     => $get_ph_number
                                    ];

                                    $success_group_data = [
                                        "target"    => "group",
                                        "response" => "🎆🏁 🏁 The *game* is *start*, you can place your *stake* 🏎 🏎 🏎🎆",
                                        "value"     => $get_group_id
                                    ];

                                    return response()->json(["successgroup" => $success_group_data, "successprivate" => $success_private_data], $this->successStatus);
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ No *games* are active in *".$get_group_name."* group",
                                        "value"     => $get_ph_number,
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                    "value"     => $get_ph_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ Your not *agent* in *".$get_group_name."* group",
                                "value"     => $get_ph_number
                            ];
                            return response()->jsoN(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ *Group* unlisted",
                            "value"     => $get_ph_number
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *phone number*",
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *group name*",
                    "value"     => $get_ph_number
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function get_group_from_private()
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
                            if(Shwetech::checkBOT($check_agent->id) == 1)
                            {
                                $get_group_id   = $check_agent->whatsapp_group_id;
                                $success_data = [
                                    "target"    => "private",
                                    "response"  => array("wa_group_id" => $get_group_id),
                                    "value"     => $get_ph_number
                                ];
                                return response()->json(["success" => $success_data], $this->successStatus);
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                    "value"     => $get_ph_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ *".$get_group_name."
                                                \nYour not *agent* in this *group*",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ *".$get_group_name."*
                                            \n*Group* unlisted",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *phone number*",
                        "value"     => $get_ph_number,
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *group name*",
                    "value"     => $get_ph_number
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

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
                            if(Shwetech::checkBOT($check_agent->id) == 1)
                            {
                                $get_group_id   = $check_agent->whatsapp_group_id;
                                $check_game = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                                ->where('groups_id',$id_group)
                                                                ->where('status_active_games','1')
                                                                ->first();
                                if($check_game != '')
                                {
                                    $id_games   = $check_game->id_games;
                                    // $rtp_games  = $check_game->rtp_games;
                                    // $check_stakes = \App\Master_stake::where('games_id',$id_games)->count();
                                    // if($check_stakes != 0)
                                    // {
                                        $get_total_all_stake = \App\Master_stake::selectRaw('SUM(value_stakes) AS total_all_stakes')
                                                                                ->where('games_id',$id_games)
                                                                                ->first();
                                        if($get_total_all_stake != '')
                                            $total_all_stakes = $get_total_all_stake->total_all_stakes;
                                        else
                                            $total_all_stakes = 0;

                                        // $get_calculate_rtp = \App\Master_stake::selectRaw('name_list_stakes,
                                        //                                                     (
                                        //                                                         ROUND(
                                        //                                                                 (('.$total_all_stakes.' - (sum(value_stakes) * 10)) / '.$total_all_stakes.') * 100, 2
                                        //                                                             )
                                        //                                                     ) AS calculate_rtp')
                                        //                                         ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                        //                                         ->where('games_id',$id_games)
                                        //                                         ->groupBy('id_list_stakes')
                                        //                                         ->having('calculate_rtp','>',$rtp_games)
                                        //                                         ->orderBy('calculate_rtp')
                                        //                                         ->limit(1)
                                        //                                         ->first();
                                        // if($get_calculate_rtp != '')
                                        //     $stakes_winner         = $get_calculate_rtp->name_list_stakes; 
                                        // else
                                        // {
                                        //     $get_winner_optional = \App\Master_stake::selectRaw('name_list_stakes,
                                        //                                                         (
                                        //                                                             ROUND(
                                        //                                                                     (('.$total_all_stakes.' - (sum(value_stakes) * 10)) / '.$total_all_stakes.') * 100, 2
                                        //                                                                 )
                                        //                                                         ) AS calculate_rtp')
                                        //                                             ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                        //                                             ->where('games_id',$id_games)
                                        //                                             ->groupBy('id_list_stakes')
                                        //                                             ->having('calculate_rtp','<',$rtp_games)
                                        //                                             ->orderBy('calculate_rtp','desc')
                                        //                                             ->limit(1)
                                        //                                             ->first();
                                        //     if($get_winner_optional != '')
                                        //         $stakes_winner         = $get_winner_optional->name_list_stakes;
                                        //     else
                                        //         $stakes_winner         = 'No Winner';
                                        // }

                                        // if($stakes_winner != 'No Winner')
                                        // {
                                            $get_winner         = \App\Master_list_stake::selectRaw('" " AS phone_number,
                                                                                                    name_list_stakes,
                                                                                                    " " AS profit,
                                                                                                    command_list_stakes,
                                                                                                    id_list_stakes,
                                                                                                    " " AS id_stakes,
                                                                                                    " " AS credit_register_members')
                                                                                        ->orderByRaw('RAND()')
                                                                                        ->limit(1)
                                                                                        ->first();
                                            $stakes_winner          = $get_winner->name_list_stakes;

                                            $stake_winners_data     = [
                                                "games_id"          => $id_games,
                                                "list_stakes_id"    => $get_winner->id_list_stakes
                                            ];
                                            \App\Master_stake_winner::insert($stake_winners_data);

                                            $check_member_winner  = \App\Master_stake::selectRaw('CONCAT(SUBSTRING(`phone_number_register_members`, 1, CHAR_LENGTH(`phone_number_register_members`) - 5),"****") as phone_number,
                                                                                                name_list_stakes,
                                                                                                SUM(value_stakes * 10) AS profit,
                                                                                                id_register_members,
                                                                                                command_list_stakes,
                                                                                                id_list_stakes,
                                                                                                id_stakes,
                                                                                                credit_register_members')
                                                                                    ->join('master_register_members','register_members_id','master_register_members.id_register_members')
                                                                                    ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                                                                    ->where('name_list_stakes',$stakes_winner)
                                                                                    ->where('games_id',$id_games)
                                                                                    ->groupBy('id_register_members')
                                                                                    ->count();

                                            if($check_member_winner != 0)
                                            {
                                                $get_member_winner  = \App\Master_stake::selectRaw('CONCAT(SUBSTRING(`phone_number_register_members`, 1, CHAR_LENGTH(`phone_number_register_members`) - 5),"****") as phone_number,
                                                                                                name_list_stakes,
                                                                                                SUM(value_stakes * 10) AS profit,
                                                                                                id_register_members,
                                                                                                command_list_stakes,
                                                                                                id_list_stakes,
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
                                                    "response"  => $get_member_winner,
                                                    "value"     => $get_group_id
                                                ];
                                                return response()->json(["success" => $success_data], $this->successStatus);
                                            }
                                            else
                                            {
                                                $get_all_stakes = \App\Master_stake::selectRaw('SUM(value_stakes) AS total_stakes')
                                                                                    ->where('games_id',$id_games)
                                                                                    ->first();
                                                $total_stakes   = $get_all_stakes->total_stakes;
                                                $calculate_credit_group = $credit_group + $total_stakes;
                                                
                                                $credit_group_data = [
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
                                                    "response"  => array($get_winner),
                                                    "value"     => $get_group_id
                                                ];
                                                return response()->json(["success" => $success_data], $this->successStatus);
                                            }
                                        // }
                                        // else
                                        // {
                                        //     $games_data = [
                                        //         'end_date_games'     => date('Y-m-d H:i:s'),
                                        //         'status_active_games'=> 2
                                        //     ];
                                        //     \App\Master_game::where('id_games',$id_games)->update($games_data);

                                        //     $success_data = [
                                        //         "target"    => "group",
                                        //         "response"  => $get_group_name."\n No winner in this game",
                                        //         "value"     => $get_group_id,
                                        //     ];
                                        //     return response()->json(["success" => $success_data], $this->errorStatus);
                                        // }
                                    // }
                                    // else
                                    // {
                                    //     $games_data = [
                                    //         'end_date_games'     => date('Y-m-d H:i:s'),
                                    //         'status_active_games'=> 2
                                    //     ];
                                    //     \App\Master_game::where('id_games',$id_games)->update($games_data);

                                    //     $success_data = [
                                    //         "target"    => "group",
                                    //         "response"  => $get_group_name."\n No winner in this game",
                                    //         "value"     => $get_group_id,
                                    //     ];
                                    //     return response()->json(["success" => $success_data], $this->successStatus);
                                    // }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ *".$get_group_name."*
                                                        \nNo *game* is active",
                                        "value"     => $get_ph_number
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                    "value"     => $get_ph_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ *".$get_group_name."*
                                                \nYour not *agent* in this *group*",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ *".$get_group_name."*
                                            \n*Group* unlisted",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *phone number*",
                        "value"     => $get_ph_number,
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *group name*",
                    "value"     => $get_ph_number
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

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
                                    if(Shwetech::checkBOT($check_agent->id) == 1)
                                    {
                                        $credit_groups = $check_group->credit_groups;
                                        $calculate_credit_group = $credit_groups + $get_credit_group;
                                        $group_data = [
                                            'credit_groups' => $calculate_credit_group,
                                        ];
                                        \App\Master_group::where('id_groups', $id_groups)->update($group_data);

                                        $top_ups_data = [
                                            'from_users_id'             => $id_users_group,
                                            'to_users_id'               => 0,
                                            'to_register_members_id'    => 0,
                                            'to_groups_id'              => $id_groups,
                                            'date_top_ups'              => date('Y-m-d'),
                                            'time_top_ups'              => date('H:i:s'),
                                            'credit_top_ups'            => $get_credit_group
                                        ];
                                        \App\Master_top_up::insert($top_ups_data);

                                        $success_data = [
                                            "target"    => "private",
                                            "response"  => "🎆*Congratulations‼*🎆 you successfully fill *credit* to *".$get_group_name."* group",
                                            "value"     => $get_ph_number 
                                        ];
                                        return response()->json(["success" => $success_data], $this->successStatus);
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                            "value"     => $get_ph_number,
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ Your not *agent* in *".$get_group_name."* group",
                                        "value"     => $get_ph_number,
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "⛔ *Group* unlisted",
                                    "value"     => $get_ph_number
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ *Credit* should be a number",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ You must enter the *credit*",
                            "value"     => $get_ph_number
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *name* of *group*",
                        "value"     => $get_ph_number, 
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *phone number*",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function top_up_member()
        {
            //PARAMETER
                $get_agent_number       = request('wa_ph_number');
                $get_member_number      = request('wa_member_ph_number');
                $get_credit_top_ups     = request('credit_top_up');

            if($get_agent_number != '')
            {
                if($get_member_number != '')
                {
                    if($get_credit_top_ups != '')
                    {
                        if(is_numeric($get_credit_top_ups))
                        {
                            if($get_credit_top_ups > 0)
                            {
                                $get_agent = \App\Master_user::where('phone_number_users',$get_agent_number)
                                                                ->first();
                                if($get_agent != '')
                                {
                                    if(Shwetech::checkBOT($get_agent->id) == 1)
                                    {
                                        $get_member = \App\Master_register_member::where('phone_number_register_members',$get_member_number)
                                                                                    ->first();
                                        if($get_member != '')
                                        {
                                            $id_agent   = $get_agent->id;
                                            $check_agent = \App\Master_group::join('master_sessions','id_groups','=','master_sessions.groups_id')
                                                                            ->join('master_register_members','id_sessions','=','master_register_members.sessions_id')
                                                                            ->where('users_id',$id_agent)
                                                                            ->where('phone_number_register_members',$get_member_number)
                                                                            ->orderBy('sessions_id','desc')
                                                                            ->limit(1)
                                                                            ->first();
                                            if($check_agent != '')
                                            {
                                                $credit_agent = $get_agent->credit_users;
                                                if($credit_agent >= $get_credit_top_ups)
                                                {
                                                    $id_register_members    = $get_member->id_register_members;
                                                    $top_ups_data = [
                                                        'from_users_id'         => $get_agent->id,
                                                        'to_users_id'           => 0,
                                                        'to_register_members_id'=> $id_register_members,
                                                        'date_top_ups'          => date('Y-m-d'),
                                                        'time_top_ups'          => date('H:i:s'),
                                                        'credit_top_ups'        => $get_credit_top_ups,
                                                    ];
                                                    \App\Master_top_up::insert($top_ups_data);

                                                    $credit_member          = $check_agent->credit_register_members;

                                                    $calculate_member       = $credit_member + $get_credit_top_ups;
                                                    $register_member_data = [
                                                        'credit_register_members' => $calculate_member
                                                    ];
                                                    \App\Master_register_member::where('id_register_members',$id_register_members)->update($register_member_data);

                                                    $calculate_agent = $credit_agent - $get_credit_top_ups;
                                                    $agent_data      = [
                                                        'credit_users'  => $calculate_agent
                                                    ];
                                                    \App\Master_user::where('id',$id_agent)->update($agent_data);

                                                    $success_data = [
                                                        "target"    => "private",
                                                        "response"  => "🎆*Congratulations‼*🎆 you successfully fill *credit* to member *".$get_member_number."*",
                                                        "value"     => $get_agent_number
                                                    ];
                                                    return response()->json(["success" => $success_data], $this->successStatus);
                                                }
                                                else
                                                {
                                                    $error_data = [
                                                        "target"    => "private",
                                                        "response"  => "⛔ Your *credit* not enough. Your current *credit* is *".$credit_master_agent."*",
                                                        "value"     => $get_ph_number_master_agent
                                                    ];
                                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                                }
                                            }
                                            else
                                            {
                                                $error_data = [
                                                    "target"    => "private",
                                                    "response"  => "⛔ Your is not *agent* this *".$get_member_number."* member",
                                                ];
                                                return response()->json(["error" => $error_data], $this->errorStatus);
                                            }
                                        }
                                        else
                                        {
                                            $error_data = [
                                                "target"    => "private",
                                                "response"  => "⛔ *Phone number* member unlisted",
                                                "value"     => $get_agent_number
                                            ];
                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                        }
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                            "value"     => $get_ph_number,
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ *Phone number agent* unlisted",
                                        "value"     => $get_agent_number
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "⛔ *Credit* must be greater than 0",
                                    "value"     => $get_agent_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ *Credit* should be a number",
                                "value"     => $get_agent_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ You must enter the *credit top up*",
                            "value"     => $get_agent_number
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *phone number member*",
                        "value"     => $get_agent_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *phone number agent*",
                    "value"     => $get_agent_number
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function check_credit_agent()
        {
            //PARAMETER
                $get_ph_number = request('wa_ph_number');

            if($get_ph_number != '')
            {
                $get_agent = \App\Master_user::where('phone_number_users',$get_ph_number)
                                                    ->first();
                if($get_agent != '')
                {
                    if(Shwetech::checkBOT($get_agent->id) == 1)
                    {
                        $id_level_systems   = $get_agent->level_systems_id;
                        if($id_level_systems == 3)
                        {
                            $success_data = [
                                "target"    => "private",
                                "response"  => "💰 Your *credit* : *".$get_agent->credit_users."*",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["success" => $success_data], $this->successStatus);
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ Your not *agent*",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ *Phone number* unlisted",
                        "value"     => $get_ph_number,
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *phone number*",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function ahelp()
        {
            //PARAMETER
                $get_ph_number = request('wa_ph_number');

            if($get_ph_number != '')
            {
                $check_agent = \App\Master_user::where('phone_number_users',$get_ph_number)->first();
                if($check_agent != '')
                {
                    if(Shwetech::checkBOT($check_agent->id) == 1)
                    {
                        $id_level_systems = $check_agent->level_systems_id;
                        if($id_level_systems == 3)
                        {
                            $get_bot_phone_number       = \Request::segment(2);
                            $get_bots                   = \App\Master_bot::where('phone_number_bots',$get_bot_phone_number)->first();
                            $name_bots                  = $get_bots->name_bots;

                            $success_data = [
                                "target"    => "private",
                                "response"  => "response"  => "🆘 Hi, I am your BOT, my name is *".$name_bots."*, *Here is some command i understand* :
                                                \n🏷 Create group = *#group*[space]*group name*[space]*credit*
                                                \n🏷 Create session = *#session*[space]*group name*[space]*credit per member*[space]*duration (in day)*
                                                \n🏷 Start game = *#autorun*[space]*group name*
                                                \n🏷 End Game = *#stop*[space]*group name*
                                                \n🏷 Top up group = *#credit*[space]*group name*[space]*amount*
                                                \n🏷 Top up member = *#tpmember*[space]*member phone number*[space]*amount*",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["success" => $success_data], $this->successStatus);
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ Your not agent",
                                "value"     => $get_ph_number,
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ Phone number unlisted",
                        "value"     => $get_ph_number,
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *phone number*",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function check_credit_member_from_agent()
        {
            //PARAMETER
                $get_ph_number  = request('wa_ph_number');
                $get_group_name = request('wa_group_name');

            if($get_ph_number != '')
            {
                if($get_group_name != '')
                {
                    $get_agent = \App\Master_user::where('phone_number_users',$get_ph_number)
                                                        ->first();
                    if($get_agent != '')
                    {
                        if(Shwetech::checkBOT($get_agent->id) == 1)
                        {
                            $check_group_agent = \App\Master_group::where('name_groups',$get_group_name)
                                                                    ->first();
                            if($check_group_agent != '')
                            {
                                $id_agent           = $get_agent->id;
                                $id_level_systems   = $get_agent->level_systems_id;
                                if($id_level_systems == 3)
                                {
                                    $get_member_agent = \App\Master_register_member::select('name_groups',
                                                                                            'start_date_sessions as start sessions',
                                                                                            'end_date_sessions as end_sessions',
                                                                                            'phone_number_register_members as phone number',
                                                                                            'credit_register_members as credit')
                                                                                    ->join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                                                    ->join('master_groups','groups_id','=','master_groups.id_groups')
                                                                                    ->where('users_id',$id_agent)
                                                                                    ->get();

                                    $success_data = [
                                        "target"    => "private",
                                        "response"  => $get_member_agent,
                                        "value"     => $get_ph_number
                                    ];
                                    return response()->json(["success" => $success_data], $this->successStatus);
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ Your not *agent*",
                                        "value"     => $get_ph_number
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "⛔ *".$get_group_name."*
                                                    \nYour not agent in this group",
                                    "value"     => $get_ph_number
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ BOT number unlisted or i'm not your BOT",
                                "value"     => $get_ph_number,
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ *Phone number* unlisted",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *group name*",
                        "value"     => $get_ph_number,
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *phone number*",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }
    /* AGENT */

    /* MEMBER */
        public function register_members()
        {
            //PARAMETER
                $get_group_id   = request('wa_group_id');
                $get_ph_number  = request('wa_ph_number');

            if($get_group_id != '')
            {
                if($get_ph_number != '')
                {
                    $get_group              = \App\Master_group::where('whatsapp_group_id',$get_group_id)
                                                                ->first();
                    if($get_group != '')
                    {
                        $id_group               = $get_group->id_groups;
                        $get_group_name         = $get_group->name_groups;
                        $get_credit_group       = $get_group->credit_groups;

                        $check_agent_master_agent   = \App\Master_user::where('phone_number_users',$get_ph_number)->count();
                        if($check_agent_master_agent == 0)
                        {
                            $get_last_sessions      = \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
                                                                            ->where('groups_id',$id_group)
                                                                            ->where('status_active_sessions',1)
                                                                            ->first();
                            if($get_last_sessions != '')
                            {
                                $id_sessions                = $get_last_sessions->id_sessions;
                                $get_start_date             = $get_last_sessions->start_date_sessions;
                                $get_end_date               = $get_last_sessions->end_date_sessions;
                                $get_credit_member_sessions = $get_last_sessions->credit_member_sessions;
                                $get_agent_id               = $get_last_sessions->users_id;
                                $get_agent                  = \App\Master_user::where('id',$get_agent_id)
                                                                                ->join('master_bots','bots_id','=','master_bots.id_bots')
                                                                                ->first();
                                $get_phone_number_agent     = $get_agent->phone_number_users;
                                $get_bots                   = $get_agent->name_bots;
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
                                                "target"    => "private",
                                                "response"  => "Hi *".$get_ph_number."*, I am a *".$get_bots."*, Your success join the *sessions* in *".$get_group_name."*! Good Luck!
                                                                \nThis *sessions* :
                                                                \n🏷 Started at : *".Shwetech::changeDBToDatetime($get_start_date)."*
                                                                \n🏷 Finished at : *".Shwetech::changeDBToDatetime($get_end_date)."*
                                                                \nI'll guide your game.
                                                                \nYou are already registered in this group. You can follow the game in this group by typing command :
                                                                \n🏷 *#b*[space]*list of stakes*[space]*amount of stake*
                                                                \nFor example :
                                                                \n🏷 *#b dr 100*
                                                                \nAbove command means that you give *stake* to a *dragon* worth *100*.
                                                                \n🏷 You can check list of stake with command : *#listbet*
                                                                \n🏷 To view all stakes in this group with command : *#list*
                                                                \nYour *credit* in *".$get_group_name."* group is *".$get_credit_member_sessions."*
                                                                \n🏷 You can see all your credits from each game by typing the command : *#bal*",
                                                "value"     => $get_ph_number
                                            ];
                                            return response()->json(["success" => $success_data], $this->successStatus);
                                        }
                                        else
                                        {
                                            $error_data = [
                                                "target"    => "private",
                                                "response"  => "⛔ *".$get_group_name."*
                                                                \n*Credit group* not enough. *Credit ".$get_group_name."* is *".$get_credit_group."*
                                                                \nAnd you can't join in this *group*",
                                                "value"     => $get_ph_number
                                            ];
                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                        }
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "group",
                                            "response"  => "⛔ *".$get_ph_number."*
                                                            \nYour already *registered*",
                                            "value"     => $get_group_id
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ *".$get_group_name."*
                                                        \nYour is *agent* in this *group*, you can't *play* in your *own group*",
                                        "value"     => $get_ph_number,
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "⛔ *".$get_group_name."*
                                                    \n*Group* doesn't have any sessions",
                                    "value"     => $get_ph_number
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ *".$get_group_name."*
                                                \nYour phone number have registered in our system, you can't join as member",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ *Group* unlisted",
                            "value"     => $get_ph_number,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *phone number*",
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *group ID*",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

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
                                    $check_list_stakes = \App\Master_list_stake::where('command_list_stakes',$get_stake)->first();
                                    if($check_list_stakes != '')
                                    {
                                        $get_active_games = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                                            ->join('master_groups','groups_id','=','master_groups.id_groups')
                                                                            ->where('whatsapp_group_id',$get_group_id)
                                                                            ->where('status_active_games','1')
                                                                            ->first();
                                        if($get_active_games != '')
                                        {
                                            $id_sessions            = $get_active_games->id_sessions;
                                            $get_register_member    = \App\Master_register_member::where('phone_number_register_members',$get_ph_number)
                                                                                                ->where('sessions_id',$id_sessions)
                                                                                                ->first();
                                            if($get_register_member != '')
                                            {
                                                $id_register_members    = $get_register_member->id_register_members;

                                                $get_credit_register_member_all_sessions = \App\Master_register_member::selectRaw("SUM(credit_register_members) AS total_credit_member")
                                                                                                                        ->join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                                                                                        ->where('phone_number_register_members',$get_ph_number)
                                                                                                                        ->where('groups_id',$get_group->id_groups)
                                                                                                                        ->first();

                                                $credit_register_members= $get_credit_register_member_all_sessions->total_credit_member;
                                                if($credit_register_members >= $get_value)
                                                {
                                                    if($get_value > 0)
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
                                                        $credit_register_members_data = [
                                                            'credit_register_members'   => $calculate_credit_members
                                                        ];
                                                        \App\Master_register_member::where('id_register_members',$id_register_members)->update($credit_register_members_data);

                                                        $get_credit_after_update    = \App\Master_register_member::selectRaw("SUM(credit_register_members) AS total_credit_member")
                                                                                                                    ->where('id_register_members',$id_register_members)
                                                                                                                    ->first();
                                                        $credit_register_members_now= $get_credit_after_update->total_credit_member;

                                                        $success_private_data = [
                                                            "target"    => "private",
                                                            "response"  => "🎆🎆 You have successfully stake on *".$get_stake."* with *".$get_value."* credit 🎆🎆.
                                                                            \nYour current *credit* in *".$get_group_name."* group is *".$credit_register_members_now."*",
                                                            "value"     => $get_ph_number
                                                        ];

                                                        $success_group_data = [
                                                            "target"    => "group",
                                                            "response"  => "🎆🎆 *".substr($get_ph_number, 0, -8)."**** Place a *stake*! 🎆🎆",
                                                            "value"     => $get_group_id
                                                        ];
                                                        return response()->json(["successgroup" => $success_group_data, "successprivate" => $success_private_data], $this->successStatus);
                                                    }
                                                    else
                                                    {
                                                        $error_data = [
                                                            "target"    => "private",
                                                            "response"  => "⛔ *".$get_group_name."
                                                                            \n*Amount* can't be smaller than 0",
                                                            "value"     => $get_ph_number,
                                                        ];
                                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                                    }
                                                }
                                                else
                                                {
                                                    $error_data = [
                                                        "target"    => "private",
                                                        "response"  => "⛔ *".$get_group_name."*
                                                                        \nYour *credit* not enough. Your *credit* is *".$credit_register_members."*",
                                                        "value"     => $get_ph_number,
                                                    ];
                                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                                }
                                            }
                                            else
                                            {
                                                $error_data = [
                                                    "target"    => "private",
                                                    "response"  => "⛔ *".$get_group_name."
                                                                    \nYour not *member* in *".$get_group_name."* group",
                                                    "value"     => $get_ph_number
                                                ];
                                                return response()->json(["error" => $error_data], $this->errorStatus);
                                            }
                                        }
                                        else
                                        {
                                            $error_data = [
                                                "target"    => "private",
                                                "response"  => "⛔ *".$get_group_name."*
                                                                \nNo *game* is active",
                                                "value"     => $get_ph_number
                                            ];
                                            return response()->json(["error" => $error_data], $this->errorStatus);
                                        }
                                    }
                                    else
                                    {
                                        $error_data = [
                                            "target"    => "private",
                                            "response"  => "⛔ *".$get_group_name."*
                                                            \nYour *stakes* not in list. You can check the list of stakes by typing command : *#listbet*",
                                            "value"     => $get_ph_number
                                        ];
                                        return response()->json(["error" => $error_data], $this->errorStatus);
                                    }
                                }
                                else
                                {
                                    $error_data = [
                                        "target"    => "private",
                                        "response"  => "⛔ *".$get_group_name."
                                                        \n*Amount* should be a number",
                                        "value"     => $get_ph_number
                                    ];
                                    return response()->json(["error" => $error_data], $this->errorStatus);
                                }
                            }
                            else
                            {
                                $error_data = [
                                    "target"    => "private",
                                    "response"  => "⛔ *".$get_group_name."*
                                                    \nYou must enter the *amount*",
                                    "value"     => $get_ph_number,
                                ];
                                return response()->json(["error" => $error_data], $this->errorStatus);
                            }
                        }
                        else
                        {
                            $error_data = [
                                "target"    => "private",
                                "response"  => "⛔ *".$get_group_name."*
                                                \nYou must enter the *stake*. You can check the list of stakes by typing command : *#listbet*",
                                "value"     => $get_ph_number
                            ];
                            return response()->json(["error" => $error_data], $this->errorStatus);
                        }
                    }
                    else
                    {
                        $error_data = [
                            "target"    => "private",
                            "response"  => "⛔ *Group* unlisted",
                            "value"     => $get_ph_number
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You must enter the *phone number*",
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *group ID*",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function check_credit_member()
        {
            //PARAMETER
                $get_ph_number = request('wa_ph_number');
            
            if($get_ph_number != '')
            {
                $check_register_members_all = \App\Master_register_member::where('phone_number_register_members',$get_ph_number)
                                                                          ->first();
                if($check_register_members_all != '')
                {
                    $list_credit_members = \App\Master_register_member::select('name_groups',
                                                                                'credit_register_members',
                                                                                'start_date_sessions AS start_sessions',
                                                                                'end_date_sessions AS end_sessions')
                                                                        ->join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                                        ->join('master_groups','groups_id','=','master_groups.id_groups')
                                                                        ->where('phone_number_register_members',$get_ph_number)
                                                                        ->get();
                    $success_data = [
                        "target"    => "private",
                        "response"  => $list_credit_members,
                        "value"     => $get_ph_number
                    ];
                    return response()->json(["success" => $success_data], $this->successStatus);
                }
                else
                {
                    $error_data = [
                        "target"    => "private",
                        "response"  => "⛔ You are not registered in any *group*",
                        "value"     => $get_ph_number,
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "private",
                    "response"  => "⛔ You must enter the *phone number*",
                    "value"     => $get_ph_number,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }
    /* MEMBER */

    /* AGENT + MEMBER */
        public function check_stakes_members()
        {
            //PARAMETER
                $get_group_id      = request('wa_group_id');
            
            if($get_group_id != '')
            {
                $get_stakes_member = \App\Master_stake::selectRaw('CONCAT(SUBSTRING(`phone_number_register_members`, 1, CHAR_LENGTH(`phone_number_register_members`) - 5),"****") as phone_number,
                                                                    name_list_stakes,
                                                                    value_stakes AS profit')
                                                        ->join('master_games','games_id','=','master_games.id_games')
                                                        ->join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                        ->join('master_groups','groups_id','=','master_groups.id_groups')
                                                        ->join('master_register_members','register_members_id','=','master_register_members.id_register_members')
                                                        ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                                        ->where('whatsapp_group_id',$get_group_id)
                                                        ->where('status_active_games',1)
                                                        ->get();
                if($get_stakes_member != '')
                {
                    $stakes_members_data = [
                        "check_stakes_members" => $get_stakes_member
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
                        "response"  => "⛔ *List stakes* empty",
                        "value"     => $get_group_id
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "group",
                    "response"  => "⛔ You must enter the whatsapp *group ID*",
                    "value"     => $get_group_id
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function list_stakes()
        {
            //PARAMATER
                $get_group_id          = request('wa_group_id');
            
            if($get_group_id != '')
            {
                $check_group = \App\Master_group::where("whatsapp_group_id",$get_group_id)->count();
                if($check_group != 0)
                {
                    $check_list_stakes = \App\Master_list_stake::count();
                    if($check_list_stakes != 0)
                    {
                        $get_list_stakes = \App\Master_list_stake::select('name_list_stakes','command_list_stakes')
                                                                ->get();
                        $list_stakes_data = [
                            "target"                => "group",
                            "response"              => $get_list_stakes,
                            "value"                 => $get_group_id,
                        ];
                        return response()->json(["success" => $list_stakes_data], $this->successStatus);
                    }
                    else
                    {
                        $error_data = [
                            "target"                => "group",
                            "response"              => "⛔ No *list stakes* available",
                            "value"                 => $get_group_id,
                        ];
                        return response()->json(["error" => $error_data], $this->errorStatus);
                    }
                }
                else
                {
                    $error_data = [
                        "target"    => "group",
                        "response"  => "⛔ *Group* Unlisted",
                        "value"     => $get_group_id
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "group",
                    "response"  => "⛔ You must enter the *group ID*",
                    "value"     => $get_group_id,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function help()
        {
            //PARAMETER
                $get_group_id          = request('wa_group_id');
            
            if($get_group_id != '')
            {
                $check_group = \App\Master_group::where("whatsapp_group_id",$get_group_id)->count();
                if($check_group != 0)
                {
                    $get_bot_phone_number       = \Request::segment(2);
                    $get_bots                   = \App\Master_bot::where('phone_number_bots',$get_bot_phone_number)->first();
                    $name_bots                  = $get_bots->name_bots;

                    $success_data = [
                        "target"    => "group",
                        "response"  => "🆘 Hi, my name is *".$name_bots."*, *i am a BOT in this group and here is some command i understand* :
                                        \n🏷 Register = *#reg*
                                        \n🏷 Bet = *#b*[space]*list stakes*[space]*amount*
                                        \n🏷 Check list stakes available = *#listbet*
                                        \n🏷 Check all member stakes in current game = *#list*
                                        \n🏷 See all your balance in each game = *#bal*",
                        "value"     => $get_group_id
                    ];
                    return response()->json(["success" => $success_data], $this->successStatus);
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
                    "value"     => $get_group_id,
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }

        public function stat()
        {
            //PARAMETER
                $get_group_id = request('wa_group_id');

            if($get_group_id != '')
            {
                $get_stake_winners = \App\Master_stake_winner::select('name_groups',
                                                                        'start_date_sessions',
                                                                        'end_date_sessions',
                                                                        'start_date_games',
                                                                        'end_date_games',
                                                                        'name_list_stakes')
                                                            ->join('master_games','games_id','=','master_games.id_games')
                                                            ->join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                            ->join('master_groups','groups_id','=','master_groups.id_groups')
                                                            ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                                            ->where('whatsapp_group_id',$get_group_id)
                                                            ->orderBy('id_games','desc')
                                                            ->limit(10)
                                                            ->get();
                if($get_stake_winners != '')
                {
                    $stake_winners_data = [
                        "check_stakes_winners" => $get_stake_winners
                    ];

                    $success_data = [
                        "target"    => "group",
                        "response"  => $stake_winners_data,
                        "value"     => $get_group_id,
                    ];
                    return response()->json(["success" => $success_data], $this->successStatus);
                }
                else
                {
                    $error_data = [
                        "target"    => "group",
                        "response"  => "⛔ *List stake winners* empty",
                        "value"     => $get_group_id
                    ];
                    return response()->json(["error" => $error_data], $this->errorStatus);
                }
            }
            else
            {
                $error_data = [
                    "target"    => "group",
                    "response"  => "⛔ You must enter the whatsapp *group ID*",
                    "value"     => $get_group_id
                ];
                return response()->json(["error" => $error_data], $this->errorStatus);
            }
        }
    /* AGENT + MEMBER */

    /* CRON JOB */
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
                                                    ->where('status_active_games',1)
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
                                            // $rtp_games  = $check_game->rtp_games;

                                            $get_total_all_stake = \App\Master_stake::selectRaw('SUM(value_stakes) AS total_all_stakes')
                                                                                    ->where('games_id',$id_games)
                                                                                    ->first();
                                            if($get_total_all_stake != '')
                                                $total_all_stakes = $get_total_all_stake->total_all_stakes;
                                            else
                                                $total_all_stakes = 0;

                                            // $get_calculate_rtp = \App\Master_stake::selectRaw('name_list_stakes,
                                            //                                                     (
                                            //                                                         ROUND(
                                            //                                                                 (('.$total_all_stakes.' - (sum(value_stakes) * 10)) / '.$total_all_stakes.') * 100, 2
                                            //                                                             )
                                            //                                                     ) AS calculate_rtp')
                                            //                                         ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                            //                                         ->where('games_id',$id_games)
                                            //                                         ->groupBy('id_list_stakes')
                                            //                                         ->having('calculate_rtp','>',$rtp_games)
                                            //                                         ->orderBy('calculate_rtp')
                                            //                                         ->limit(1)
                                            //                                         ->first();
                                            // if($get_calculate_rtp != '')
                                            //     $stakes_winner         = $get_calculate_rtp->name_list_stakes; 
                                            // else
                                            // {
                                            //     $get_winner_optional = \App\Master_stake::selectRaw('name_list_stakes,
                                            //                                                         (
                                            //                                                             ROUND(
                                            //                                                                     (('.$total_all_stakes.' - (sum(value_stakes) * 10)) / '.$total_all_stakes.') * 100, 2
                                            //                                                                 )
                                            //                                                         ) AS calculate_rtp')
                                            //                                             ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                            //                                             ->where('games_id',$id_games)
                                            //                                             ->groupBy('id_list_stakes')
                                            //                                             ->having('calculate_rtp','<',$rtp_games)
                                            //                                             ->orderBy('calculate_rtp','desc')
                                            //                                             ->limit(1)
                                            //                                             ->first();
                                            //     if($get_winner_optional != '')
                                            //         $stakes_winner         = $get_winner_optional->name_list_stakes;
                                            //     else
                                            //         $stakes_winner         = 'No Winner';
                                            // }

                                            // if($stakes_winner != 'No Winner')
                                            // {
                                                $get_winner         = \App\Master_list_stake::selectRaw('" " AS phone_number,
                                                                                                name_list_stakes,
                                                                                                " " AS profit,
                                                                                                command_list_stakes,
                                                                                                id_list_stakes,
                                                                                                " " AS id_stakes,
                                                                                                " " AS credit_register_members')
                                                                                            ->orderByRaw('RAND()')
                                                                                            ->limit(1)
                                                                                            ->first();
                                                $stakes_winner          = $get_winner->name_list_stakes;

                                                $stake_winners_data     = [
                                                    "games_id"          => $id_games,
                                                    "list_stakes_id"    => $get_winner->id_list_stakes
                                                ];
                                                \App\Master_stake_winner::insert($stake_winners_data);

                                                $check_member_winner  = \App\Master_stake::selectRaw('CONCAT(SUBSTRING(`phone_number_register_members`, 1, CHAR_LENGTH(`phone_number_register_members`) - 5),"****") as phone_number,
                                                                                                    name_list_stakes,
                                                                                                    SUM(value_stakes * 10) AS profit,
                                                                                                    id_register_members,
                                                                                                    command_list_stakes,
                                                                                                    id_list_stakes,
                                                                                                    id_stakes,
                                                                                                    credit_register_members')
                                                                                        ->join('master_register_members','register_members_id','master_register_members.id_register_members')
                                                                                        ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                                                                                        ->where('name_list_stakes',$stakes_winner)
                                                                                        ->where('games_id',$id_games)
                                                                                        ->groupBy('id_register_members')
                                                                                        ->count();

                                                if($check_member_winner != 0)
                                                {
                                                    $get_member_winner  = \App\Master_stake::selectRaw('CONCAT(SUBSTRING(`phone_number_register_members`, 1, CHAR_LENGTH(`phone_number_register_members`) - 5),"****") as phone_number,
                                                                                                    name_list_stakes,
                                                                                                    SUM(value_stakes * 10) AS profit,
                                                                                                    id_register_members,
                                                                                                    command_list_stakes,
                                                                                                    id_list_stakes,
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
                                                        "response"  => $get_member_winner,
                                                        "value"     => $get_group_id
                                                    ];
                                                    return response()->json(["success" => $success_data], $this->successStatus);
                                                }
                                                else
                                                {
                                                    $get_all_stakes = \App\Master_stake::selectRaw('SUM(value_stakes) AS total_stakes')
                                                                                ->where('games_id',$id_games)
                                                                                ->first();
                                                    $total_stakes   = $get_all_stakes->total_stakes;
                                                    $calculate_credit_group = $credit_group + $total_stakes;
                                                    
                                                    $credit_group_data = [
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
                                                        "response"  => array($get_winner),
                                                        "value"     => $get_group_id
                                                    ];
                                                    return response()->json(["success" => $success_data], $this->successStatus);
                                                }
                                            // }
                                            // else
                                            //     return response()->json(["error" => $get_group_name."\n No winner in this game"], $this->errorStatus);
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
    /* CRON JOB */
}