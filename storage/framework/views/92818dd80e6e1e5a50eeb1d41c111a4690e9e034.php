<?php $__env->startSection('content'); ?>

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Gamestat Report</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
	            <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard/gamestat_report')); ?>">Gamestat Report</a></li>
	            <li class="breadcrumb-item active">Detail</li>
	        </ol>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
				        <table class="table table-bordered table-condensed">
							<tr>
								<th width="35%">Group</th>
								<th width="1%">:</th>
								<td><?php echo e($read_gamestat_reports->name_groups); ?></td>
							</tr>
							<tr>
								<th>Sessions Start</th>
								<th>:</th>
								<td><?php echo e(Shwetech::changeDBToDatetime($read_gamestat_reports->start_date_sessions)); ?></td>
							</tr>
							<tr>
								<th>Sessions End</th>
								<th>:</th>
								<td><?php echo e(Shwetech::changeDBToDatetime($read_gamestat_reports->end_date_sessions)); ?></td>
							</tr>
							<tr>
								<th>Game Start</th>
								<th>:</th>
								<td><?php echo e(Shwetech::changeDBToDatetime($read_gamestat_reports->start_date_games)); ?></td>
							</tr>
							<tr>
								<th>Game End</th>
								<th>:</th>
								<td><?php echo e(Shwetech::changeDBToDatetime($read_gamestat_reports->end_date_games)); ?></td>
							</tr>
							<tr>
								<th>Credit / Members</th>
								<th>:</th>
								<td><?php echo e($read_gamestat_reports->credit_member_sessions); ?></td>
							</tr>
							<tr>
								<th>RTP</th>
								<th>:</th>
								<td><?php echo e($rtp_games = $read_gamestat_reports->rtp_games); ?>%</td>
							</tr>
						</table>
						<br/>
			            <?php ($id_games 		= $read_gamestat_reports->id_games); ?>
						<div align="center"><b><u>Winner</u></b></div>
							<table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
			                    <thead>
			                        <tr>
			                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Image</th>
			                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Name</th>
			                        </tr>
			                    </thead>
			                    <tbody>
			                    	<?php ($check_stake_winners = \App\Master_stake_winner::where('games_id',$id_games)
			                    														->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
			                    														->first()); ?>
			                    	<?php if($check_stake_winners != ''): ?>
			                    		<tr>
			                    			<td width="5%">
		                                        <a href="<?php echo e(URL::to($check_stake_winners->path_image_list_stakes)); ?>/<?php echo e($check_stake_winners->name_image_list_stakes); ?>" class="image-popup-no-margins">
		                                            <img width="100%" src="<?php echo e(URL::to($check_stake_winners->path_image_list_stakes)); ?>/<?php echo e($check_stake_winners->name_image_list_stakes); ?>">
		                                        </a>
		                                    </td>
			                    			<td><?php echo e($check_stake_winners->name_list_stakes); ?></td>
			                    		</tr>
			                    	<?php else: ?>
			                    		<tr>
			                    			<td colspan="3" style="text-align: center"><b>game is still active</b></td>
			                    		</tr>
			                    	<?php endif; ?>
			                	</tbody>
			            	</table>
			           	</div>
			            <br/>
						<?php ($check_register_member = \App\Master_register_member::where('sessions_id',$read_gamestat_reports->id_sessions)->count()); ?>
						<?php if($check_register_member != 0): ?>
							<?php ($check_game = \App\Master_stake::where('games_id',$read_gamestat_reports->id_games)->count()); ?>
							<?php if($check_game != 0): ?>
								<div align="center"><b><u>List Stakes</u></b></div>
								<table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
			                        <thead>
			                            <tr>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%" rowspan="2">No</th>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Member</th>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Stake</th>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="5">Points</th>
			                            </tr>
			                        </thead>
			                        <tbody>
			                        	<?php
			                        		$no = 1;
			                        		foreach($list_stakes as $stakes):
			                        	?>
					                            <tr>
					                                <td><?php echo $no; ?></td>
					                                <td><?php echo $stakes->phone_number_register_members; ?></td>
					                                <td><?php echo $stakes->name_list_stakes; ?></td>
					                                <td><?php echo $stakes->value_stakes; ?></td>
					                            </tr>
					                    <?php
						                    	$no++;
						                    endforeach;
					                    ?>
					                    <tr>
					                    	<td colspan="3" style="text-align: center"><b>Total Points</b></td>
					                    	<td><?php echo $total_all_stakes = $total_amount->total_amount; ?></td>
					                    </tr>
			                        </tbody>
			                    </table>
			                    <br/>

			                    <!--
								<div align="center"><b><u>RTP Options</u></b></div>
								<table class="tablesaw table-hover table-bordered table" data-tablesaw-mode="columntoggle">
			                        <thead>
			                            <tr>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%" rowspan="2">No</th>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Stake</th>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Points Win (Points * 10)</th>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="5">RTP</th>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="6">WinLose</th>
			                            </tr>
			                        </thead>
			                        <tbody>
			                        	<?php
			                        		/*
			                        		$no 			= 1;
			                        		$check_winner	= \App\Master_stake::selectRaw('name_list_stakes,
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
		                                    if($check_winner != '')
		                                    	$stakes_winner 	= $check_winner->name_list_stakes;
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

		                                    if($stakes_winner != 'No Winner'):
		                                    	$no = 1;
		                                    	$list_rtp = \App\Master_stake::selectRaw('name_list_stakes,
		                                    												SUM(value_stakes) * 10 AS total_value,
		                                                                                    (
			                                                                                    ROUND(
			                                                                                            (('.$total_all_stakes.' - (sum(value_stakes) * 10)) / '.$total_all_stakes.') * 100, 2
			                                                                                        )
		                                                                                    ) AS calculate_rtp')
		                                                                        ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
		                                                                        ->where('games_id',$id_games)
		                                                                        ->groupBy('id_list_stakes')
		                                                                        ->orderBy('calculate_rtp')
		                                                                        ->get();

		                                    	foreach($list_rtp as $rtp):
		                                    		if($stakes_winner == $rtp->name_list_stakes)
					                        			$style_winner = 'style="background-color:#74fc93"';
					                        		else
					                        			$style_winner = '';
		                                   	?>
		                                   			<tr <?php echo $style_winner; ?>>
						                                <td><?php echo $no; ?></td>
						                                <td><?php echo $rtp->name_list_stakes; ?></td>
						                                <td><?php echo $rtp->total_value; ?></td>
						                                <td><?php echo $rtp->calculate_rtp; ?>%</td>
						                                <td>
						                                	<?php
						                                		$WinLose = $total_all_stakes - $rtp->total_value;
						                                		echo $WinLose;
						                                	?>
					                                	</td>
						                            </tr>
		                                   	<?php
		                                   		$no++;
		                                   		endforeach;
		                                   	else:
		                                   	?>
		                                   		<tr>
		                                   			<td colspan="5">No Winner</td>
		                                   		</tr>
		                                   	<?php
		                                   		endif; 
												*/
		                                   	?>
			                        </tbody>
			                    </table>
			                    -->

			                    <br/>
			                    <div align="center"><b><u>List of Winner</u></b></div>
								<table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
			                        <thead>
			                            <tr>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%" rowspan="2">No</th>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Phone Number</th>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Stake</th>
			                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="5">Profit</th>
			                            </tr>
			                        </thead>
			                        <tbody>
			                        	<?php
			                        		$no 				= 1;

			                        		// $list_member_winner = \App\Master_stake::selectRaw('phone_number_register_members as phone_number,
		                           //                                                              name_list_stakes,
		                           //                                                              SUM(value_stakes * 10) AS profit,
		                           //                                                              id_register_members,
		                           //                                                              id_stakes,
		                           //                                                              credit_register_members')
		                           //                                                  ->join('master_register_members','register_members_id','master_register_members.id_register_members')
		                           //                                                  ->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
		                           //                                                  ->where('name_list_stakes',$stakes_winner)
		                           //                                                  ->where('games_id',$id_games)
		                           //                                                  ->groupBy('id_register_members')
		                           //                                                  ->get();

			                        		$list_member_winner = \App\Master_winlose::selectRaw('phone_number_register_members as phone_number,
			                        																name_list_stakes,
			                        																profit_winloses as profit')
			                        													->join('master_stakes','stakes_id','=','master_stakes.id_stakes')
			                        													->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
			                        													->join('master_register_members','register_members_id','=','master_register_members.id_register_members')
			                        													->where('games_id',$id_games)
			                        													->groupBy('id_register_members')
			                        													->get();
			                        		$total_list_member_winner = \App\Master_winlose::selectRaw('phone_number_register_members as phone_number,
			                        																name_list_stakes,
			                        																profit_winloses as profit')
			                        													->join('master_stakes','stakes_id','=','master_stakes.id_stakes')
			                        													->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
			                        													->join('master_register_members','register_members_id','=','master_register_members.id_register_members')
			                        													->where('games_id',$id_games)
			                        													->groupBy('id_register_members')
			                        													->count();
			                        		if($total_list_member_winner != 0):
					                        	foreach($list_member_winner as $member_winner):
			                        	?>
							                        <tr>
							                            <td><?php echo $no; ?></td>
							                            <td><?php echo $member_winner->phone_number; ?></td>
							                            <td><?php echo $member_winner->name_list_stakes; ?></td>
							                            <td><?php echo $member_winner->profit; ?></td>
							                        </tr>
					                    <?php
							                		$no++;
							                	endforeach;
							                else:
					                    ?>
					                    		<tr>
					                    			<td colspan="4" style="text-align: center">No Winner In This Game</td>
					                    		</tr>
						                <?php endif; ?>
			                        </tbody>
			                    </table>
		                	<?php endif; ?>
		                <?php else: ?>
		                	<div style="text-align:center;color:red"><b>No Winner In This Game</b></div>
		                	<br/>
		                <?php endif; ?>
						<br/>
	                    <div class="form-group" align="center">
		            		<?php if(request()->session()->get('page') != ''): ?>
		            			<?php ($get_back = request()->session()->get('page')); ?>
	                    	<?php else: ?>
	                    		<?php ($get_back = 'dashboard/gamestat_report'); ?>
	                    	<?php endif; ?>

	                    	<a href="<?php echo e($get_back); ?>" class="btn waves-effect waves-light btn-danger"> Back</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layouts.container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>