<?php $__env->startSection('content'); ?>

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Gamestat Report</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
	            <li class="breadcrumb-item active">Gamestat Report</li>
	        </ol>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
	                    <div class="row">
	                       	<div class="col-lg-12">
								<form method="GET" action="<?php echo e(URL('dashboard/gamestat_report/search')); ?>" class="form-horizontal m-t-40">
									<?php echo e(csrf_field()); ?>

									<div class="input-group">
										<?php if(Auth::user()->level_systems_id != 3): ?>
											<select name="search_agent" class="custom-select" id="inlineFormCustomSelect" required autofocus>
			                                    <?php ($selected_none = ''); ?>
		                                        <?php if($result_agent == 0): ?>
		                                             <?php ($selected_none = 'selected'); ?>
		                                        <?php endif; ?>
			                                    <option value="0" <?php echo e($selected_none); ?>>All</option>
			                                    <?php $__currentLoopData = $view_agent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                                    	<?php ($selected = ''); ?>
			                                    	<?php if($agent->id == $result_agent): ?>
			                                    		<?php ($selected = 'selected'); ?>
			                                    	<?php endif; ?>
			                                    	<?php if(Auth::user()->level_systems_id == 1): ?>
			                                    		<?php ($get_master_agent = \App\Master_user::where('id',$agent->sub_users_id)->first()); ?>
			                                    		<option value="<?php echo e($agent->id); ?>" <?php echo e($selected); ?> ><?php echo e($get_master_agent->name); ?> - <?php echo e($agent->name); ?></option>
			                                    	<?php elseif(Auth::user()->level_systems_id == 2): ?>
			                                    		<option value="<?php echo e($agent->id); ?>" <?php echo e($selected); ?> ><?php echo e($agent->name); ?></option>
			                                    	<?php endif; ?>
			                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			                                </select>
										<?php endif; ?>
										<input name="search_word" placeholder="search" value="<?php echo e($result_word); ?>" class="form-control" type="text">
										<span class="input-group-btn">
											<button class="btn btn-info" name="submit_search" value="submit_search" type="submit">Search</button>
										</span>
									</div>
								</form>
							</div>
						</div>
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Credit</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Members</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Start</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="5">End</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="6">RTP</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="7">Status</th>
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	<?php ($no_group = 1); ?>
	                        	<?php $__currentLoopData = $view_gamestat_reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gamestat_reports): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                            <tr>
		                                <td><?php echo e($no_group.'. '.$gamestat_reports->name_groups); ?></td>
		                                <td><?php echo e($gamestat_reports->credit_groups); ?></td>
		                                <?php if(Auth::user()->level_systems_id != 3): ?>
		                                	<?php if(Auth::user()->level_systems_id == 1): ?>
		                                		<td colspan="6">
		                                			<?php ($id_master_agent 	= $gamestat_reports->sub_users_id); ?>
		                                			<?php ($get_master_agent = \App\Master_user::where('id',$id_master_agent)->first()); ?>
		                                			<?php echo e($get_master_agent->name.' - '.$gamestat_reports->name); ?>

		                                		</td>
		                                	<?php elseif(Auth::user()->level_systems_id == 2): ?>
		                                		<td colspan="6">
		                                			<?php echo e($gamestat_reports->name); ?>

		                                		</td>
		                                	<?php endif; ?>
		                                <?php else: ?>
			                                <td colspan="6"></td>
		                                <?php endif; ?>
		                            </tr>
			                        <?php ($id_groups 	= $gamestat_reports->id_groups); ?>
			                        <?php ($get_sessions	= \App\Master_session::where('groups_id',$id_groups)->get()); ?>
			                        <?php ($no_sessions 	= 1); ?>
			                        <?php $__currentLoopData = $get_sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sessions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                            <?php ($id_sessions 	= $sessions->id_sessions); ?>
			                            <tr>
			                            	<td><?php echo e($no_group.'.'.$no_sessions.'. Sessions '.$no_sessions); ?></td>
			                            	<td><?php echo e($sessions->credit_member_sessions); ?> / Members</td>
			                            	<td>
			                            		<?php ($get_total_register_members = \App\Master_register_member::where('sessions_id',$id_sessions)->count()); ?>
			                            		<?php echo e($get_total_register_members); ?>

			                            	</td>
			                            	<td><?php echo e(Shwetech::changeDBToDatetime($sessions->start_date_sessions)); ?></td>
			                            	<td><?php echo e(Shwetech::changeDBToDatetime($sessions->end_date_sessions)); ?></td>
			                            	<td colspan="3"></td>
			                            </tr>
			                            <?php ($get_game 		= \App\Master_game::where('sessions_id', $id_sessions)->get()); ?>
			                            <?php ($no_game 		= 1); ?>
			                            <?php $__currentLoopData = $get_game; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                            	<tr>
			                            		<td><?php echo e($no_group.'.'.$no_sessions.'.'.$no_game); ?></td>
			                            		<td></td>
			                            		<td></td>
			                            		<td><?php echo e(Shwetech::changeDBToDatetime($game->start_date_games)); ?></td>
			                            		<td><?php echo e(Shwetech::changeDBToDatetime($game->end_date_games)); ?></td>
			                            		<td><?php echo e($game->rtp_games); ?>%</td>
			                            		<td>
			                            			<?php if($game->status_active_games == '0'): ?>
			                            				<?php ($status_game = 'Pending'); ?>
			                            				<?php ($style_status_game = 'style="color:red"'); ?>
			                            			<?php elseif($game->status_active_games == '1'): ?>
			                            				<?php ($status_game = 'Active'); ?>
			                            				<?php ($style_status_game = 'style="color:green"'); ?>
			                            			<?php elseif($game->status_active_games == '2'): ?>
			                            				<?php ($status_game = 'Finished'); ?>
			                            				<?php ($style_status_game = 'style="color:blue"'); ?>
			                            			<?php endif; ?>

			                            			<b <?php echo e($style_status_game); ?>><?php echo e($status_game); ?></b>
			                            		</td>
			                            		<td>
													<?php echo e(Shwetech::detail($link_gamestat_report,'dashboard/gamestat_report/detail/'.$game->id_games)); ?>

			                            		</td>
			                            	</tr>
			                            	<?php ($no_game++); ?>
			                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			                            <?php ($no_sessions++); ?>
			                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                            <?php ($no_group++); ?>
		                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layouts.container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>