<script src="<?php echo e(URL::asset('public/dashboard/plugins/bootstrap/js/popper.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/plugins/bootstrap/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/js/jquery.slimscroll.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/js/waves.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/js/sidebarmenu.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/plugins/sticky-kit-master/dist/sticky-kit.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/js/custom.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/plugins/sparkline/jquery.sparkline.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/plugins/raphael/raphael-min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/plugins/morrisjs/morris.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/plugins/styleswitcher/jQuery.style.switcher.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/plugins/tablesaw-master/dist/tablesaw.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/plugins/tablesaw-master/dist/tablesaw-init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/js/jasny-bootstrap.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/plugins/jqueryui/jquery-ui.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('public/dashboard/plugins/select2/dist/js/select2.full.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('public/dashboard/plugins/datetimepicker/bootstrap-datetimepicker.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('public/dashboard/plugins/templateEditor/ckeditor/ckeditor.js')); ?> "></script>  
<script src="<?php echo e(URL::asset('public/dashboard/plugins/price/jquery.price.js')); ?> "></script>  
<script type="text/javascript" src="<?php echo e(URL::asset('public/dashboard/plugins/chained/jquery.chained.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('public/dashboard/plugins/daterangepicker/moment.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('public/dashboard/plugins/daterangepicker/daterangepicker.js')); ?>"></script>
<script type="text/javascript">
    window.setTimeout("timeJavascript()",1000);
    function timeJavascript()
	{
        var dateNow = new Date();    
        setTimeout("timeJavascript()",1000);    
       	document.getElementById("output").innerHTML = dateNow.getHours()+":"+dateNow.getMinutes()+":"+dateNow.getSeconds();  
	}

	$(document).ready(function(){
		//Modal Confirmation
			$('.showModalDelete').click(function(e){
				e.preventDefault();
				var myLink 	= $(this).data('link');
				var myName 	= $(this).data('name');
				$('#myModalDelete').modal('show');
				$('#myModalDelete #text').text(myName);
				$('#myModalDelete #btnYes').attr("href", myLink);
			});

		//Value Dropdown Group
			<?php if(Request::segment(2) == 'group' && Request::segment(3) == 'add' || Request::segment(2) == 'group' && Request::segment(3) == 'edit'): ?>
				$("#users_id").change(function() {
					var credit_agents = $('option:selected', this).attr('get_credit_agent');
					$("#credit_agents").val(credit_agents);
				});
			<?php endif; ?>

		//Dropdown
			$(".select2").select2();

		//Price
			$('#price_format').priceFormat({
			    clearPrefix: true
			});
			$('.form-control.getPrice').priceFormat({
				clearPrefix: true
			});

		//Number
			$('#number_format').keyup(function() {
				this.value = this.value.replace(/[^0-9\.]/g,'0');
			});
			$('.form-control.number_format').keyup(function() {
				this.value = this.value.replace(/[^0-9\.]/g,'0');
			});

		//Datepicker
			$('.form-control.getDate').datepicker({
				dateFormat: "dd M yy",
			});
			$('#getDateTime').datetimepicker({
				dateFormat: "dd M yy",
				timeFormat: "HH:mm:ss",
			});
			$('.form-control.getDateTime').datetimepicker({
				dateFormat: 'dd M yy',
				timeFormat: 'HH:mm:ss'
			});

		//Daterangepicker
			var dateNowRange = new Date();
			$('#getStartEndDate').daterangepicker({
		       	startDate 	: dateNowRange,
		       	endDate 	: dateNowRange,
		       	format 		: 'YYYY-MM-DD'
			});
			var dateNowRange = new Date();
            $('#getDateRange').daterangepicker({
                timePicker: true,
                timePickerIncrement: 1,
                timePicker12Hour: false,
                timePickerSeconds: true,
                format: 'YYYY-MM-DD HH:mm:ss',
                startDate: "<?php echo date('Y-m-d'); ?>",
                minDate: "<?php echo date('Y-m-d'); ?>",
            });

		//Chained
			<?php if(Request::segment(2) == 'pending_confirmation' && Request::segment(3) == 'successconfirmation'): ?>
				$("#remark").chained("#type");
				$("#remark").trigger("liszt:updated");

				$("#type").bind("change", function(){
				    $("#remark").trigger("liszt:updated")
				});
			<?php endif; ?>

			if ($('#editor1').attr('class') != undefined){
				CKEDITOR.replace('editor1',
				{
					extraPlugins: 'divarea',
				    on: {
				        instanceReady: function() {
				            this.editable().setStyle( 'background-color', '#ffe987' );
				        }
				    },
				    filebrowserBrowseUrl 		: 'public/dashboard/plugins/templateEditor/kcfinder/browse.php?opener=ckeditor&type=files',
					filebrowserImageBrowseUrl 	: 'public/dashboard/plugins/templateEditor/kcfinder/browse.php?opener=ckeditor&type=images',
					filebrowserFlashBrowseUrl 	: 'public/dashboard/plugins/templateEditor/kcfinder/browse.php?opener=ckeditor&type=flash',

					filebrowserUploadUrl 		: 'public/dashboard/plugins/templateEditor/kcfinder/upload.php?opener=ckeditor&type=files',
					filebrowserImageUploadUrl 	: 'public/dashboard/plugins/templateEditor/kcfinder/upload.php?opener=ckeditor&type=images',
					filebrowserFlashUploadUrl 	: 'public/dashboard/plugins/templateEditor/kcfinder/upload.php?opener=ckeditor&type=flash',
				    font_names : 'Arial/Arial, Helvetica, sans-serif;' +
									'Comic Sans MS/Comic Sans MS, cursive;' +
									'Courier New/Courier New, Courier, monospace;' +
									'Georgia/Georgia, serif;' +
									'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
									'Tahoma/Tahoma, Geneva, sans-serif;' +
									'Times New Roman/Times New Roman, Times, serif;' +
									'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
									'Verdana/Verdana, Geneva, sans-serif',
				});
			}
		CKEDITOR.on('dialogDefinition', function(ev) {
		    var dialogName = ev.data.name,
		        dialogDefinition = ev.data.definition;
		    if (dialogName === 'image') {
		        dialogDefinition.removeContents('Upload');
		    }
		});

		//Level System
			//Check Checkbox Before
				var check_checkbox_one_view =  $('input[class="chk-col-black sub"]').prop('checked');
				if(check_checkbox_one_view == false)
					$('input[name="checkbox_all_view"]').prop('checked', false);
				else if(check_checkbox_one_view == true)
				{
					var check_checked 	= $('input:checkbox:checked.chk-col-black.sub').length;
					var check_unchecked = $('input:checkbox.chk-col-black.sub').length;
					if(check_checked == check_unchecked)
						$('input[name="checkbox_all_view"]').prop('checked', true);
				}

				var check_checkbox_one_read =  $('input[class="chk-col-amber sub"]').prop('checked');
				if(check_checkbox_one_read == false)
					$('input[name="checkbox_all_read"]').prop('checked', false);
				else if(check_checkbox_one_read == true)
				{
					var check_checked 	= $('input:checkbox:checked.chk-col-amber.sub').length;
					var check_unchecked = $('input:checkbox.chk-col-amber.sub').length;
					if(check_checked == check_unchecked)
						$('input[name="checkbox_all_read"]').prop('checked', true);
				}

				var check_checkbox_one_add =  $('input[class="chk-col-cyan sub"]').prop('checked');
				if(check_checkbox_one_add == false)
					$('input[name="checkbox_all_add"]').prop('checked', false);
				else if(check_checkbox_one_add == true)
				{
					var check_checked 	= $('input:checkbox:checked.chk-col-cyan.sub').length;
					var check_unchecked = $('input:checkbox.chk-col-cyan.sub').length;
					if(check_checked == check_unchecked)
						$('input[name="checkbox_all_add"]').prop('checked', true);
				}

				var check_checkbox_one_edit =  $('input[class="chk-col-purple sub"]').prop('checked');
				if(check_checkbox_one_edit == false)
					$('input[name="checkbox_all_edit"]').prop('checked', false);
				else if(check_checkbox_one_edit == true)
				{
					var check_checked 	= $('input:checkbox:checked.chk-col-purple.sub').length;
					var check_unchecked = $('input:checkbox.chk-col-purple.sub').length;
					if(check_checked == check_unchecked)
						$('input[name="checkbox_all_edit"]').prop('checked', true);
				}

				var check_checkbox_one_delete =  $('input[class="chk-col-red sub"]').prop('checked');
				if(check_checkbox_one_delete == false)
					$('input[name="checkbox_all_delete"]').prop('checked', false);
				else if(check_checkbox_one_delete == true)
				{
					var check_checked 	= $('input:checkbox:checked.chk-col-red.sub').length;
					var check_unchecked = $('input:checkbox.chk-col-red.sub').length;
					if(check_checked == check_unchecked)
						$('input[name="checkbox_all_delete"]').prop('checked', true);
				}

				var check_checkbox_one_print =  $('input[class="chk-col-green sub"]').prop('checked');
				if(check_checkbox_one_print == false)
					$('input[name="checkbox_all_print"]').prop('checked', false);
				else if(check_checkbox_one_print == true)
				{
					var check_checked 	= $('input:checkbox:checked.chk-col-green.sub').length;
					var check_unchecked = $('input:checkbox.chk-col-green.sub').length;
					if(check_checked == check_unchecked)
						$('input[name="checkbox_all_print"]').prop('checked', true);
				}

			//All Checkbox
				$('input[name="checkbox_all_view"]').click(function () {
					var check_checkbox_all =  $('input[name="checkbox_all_view"]').prop('checked');
					if(check_checkbox_all == true)
						$('input[class="chk-col-black sub"]').prop('checked', true);
					else if(check_checkbox_all == false)
						$('input[class="chk-col-black sub"]').prop('checked', false);
				});

				$('input[name="checkbox_all_read"]').click(function () {
					var check_checkbox_all =  $('input[name="checkbox_all_read"]').prop('checked');
					if(check_checkbox_all == true)
						$('input[class="chk-col-amber sub"]').prop('checked', true);
					else if(check_checkbox_all == false)
						$('input[class="chk-col-amber sub"]').prop('checked', false);
				});

				$('input[name="checkbox_all_add"]').click(function () {
					var check_checkbox_all =  $('input[name="checkbox_all_add"]').prop('checked');
					if(check_checkbox_all == true)
						$('input[class="chk-col-cyan sub"]').prop('checked', true);
					else if(check_checkbox_all == false)
						$('input[class="chk-col-cyan sub"]').prop('checked', false);
				});

				$('input[name="checkbox_all_edit"]').click(function () {
					var check_checkbox_all =  $('input[name="checkbox_all_edit"]').prop('checked');
					if(check_checkbox_all == true)
						$('input[class="chk-col-purple sub"]').prop('checked', true);
					else if(check_checkbox_all == false)
						$('input[class="chk-col-purple sub"]').prop('checked', false);
				});

				$('input[name="checkbox_all_delete"]').click(function () {
					var check_checkbox_all =  $('input[name="checkbox_all_delete"]').prop('checked');
					if(check_checkbox_all == true)
						$('input[class="chk-col-red sub"]').prop('checked', true);
					else if(check_checkbox_all == false)
						$('input[class="chk-col-red sub"]').prop('checked', false);
				});

				$('input[name="checkbox_all_print"]').click(function () {
					var check_checkbox_all =  $('input[name="checkbox_all_print"]').prop('checked');
					if(check_checkbox_all == true)
						$('input[class="chk-col-green sub"]').prop('checked', true);
					else if(check_checkbox_all == false)
						$('input[class="chk-col-green sub"]').prop('checked', false);
				});

			//One Checkbox
				$('input[class="chk-col-black sub"]').click(function () {
					var check_checked 	= $('input:checkbox:checked.chk-col-black.sub').length;
					var check_unchecked = $('input:checkbox.chk-col-black.sub').length;
					if(check_checked == check_unchecked)
						$('input[name="checkbox_all_view"]').prop('checked', true);
					else
						$('input[name="checkbox_all_view"]').prop('checked', false);
				});

				$('input[class="chk-col-amber sub"]').click(function () {
					var check_checked 	= $('input:checkbox:checked.chk-col-amber.sub').length;
					var check_unchecked = $('input:checkbox.chk-col-amber.sub').length;
					if(check_checked == check_unchecked)
						$('input[name="checkbox_all_read"]').prop('checked', true);
					else
						$('input[name="checkbox_all_read"]').prop('checked', false);
				});

				$('input[class="chk-col-cyan sub"]').click(function () {
					var check_checked 	= $('input:checkbox:checked.chk-col-cyan.sub').length;
					var check_unchecked = $('input:checkbox.chk-col-cyan.sub').length;
					if(check_checked == check_unchecked)
						$('input[name="checkbox_all_add"]').prop('checked', true);
					else
						$('input[name="checkbox_all_add"]').prop('checked', false);
				});

				$('input[class="chk-col-purple sub"]').click(function () {
					var check_checked 	= $('input:checkbox:checked.chk-col-purple.sub').length;
					var check_unchecked = $('input:checkbox.chk-col-purple.sub').length;
					if(check_checked == check_unchecked)
						$('input[name="checkbox_all_edit"]').prop('checked', true);
					else
						$('input[name="checkbox_all_edit"]').prop('checked', false);
				});

				$('input[class="chk-col-red sub"]').click(function () {
					var check_checked 	= $('input:checkbox:checked.chk-col-red.sub').length;
					var check_unchecked = $('input:checkbox.chk-col-red.sub').length;
					if(check_checked == check_unchecked)
						$('input[name="checkbox_all_delete"]').prop('checked', true);
					else
						$('input[name="checkbox_all_delete"]').prop('checked', false);
				});

				$('input[id="chk-col-green sub"]').click(function () {
					var check_checked 	= $('input:checkbox:checked.chk-col-green.sub').length;
					var check_unchecked = $('input:checkbox.chk-col-green.sub').length;
					if(check_checked == check_unchecked)
						$('input[name="checkbox_all_print"]').prop('checked', true);
					else
						$('input[name="checkbox_all_print"]').prop('checked', false);
				});
		
		//Menu
			$('#order_page').sortable({
				handle: 'span',
				update: function(event, ui) {
					$.ajaxSetup({
					   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
					});
					$.post("<?php echo e(URL::asset('/').'dashboard/menu/processorder'); ?>", { type: "orderPage", namePage: $('#order_page').sortable('serialize') } );
				}
			});

		//Fitur Sub Menu
			<?php if(Request::segment(3) == 'add_submenu' || Request::segment(3) == 'edit_submenu'): ?>
				checkCheckedSubMenu();
				$("#md_checkbox_features_view_sub_menu").click(function(){
					checkCheckedSubMenu();
				});

				function checkCheckedSubMenu()
				{
					if( $('#md_checkbox_features_view_sub_menu').prop('checked') == true)
					{
						$('#md_checkbox_features_read_sub_menu').prop('disabled', false);
						$('#md_checkbox_features_add_sub_menu').prop('disabled', false);
						$('#md_checkbox_features_edit_sub_menu').prop('disabled', false);
						$('#md_checkbox_features_delete_sub_menu').prop('disabled', false);
						$('#md_checkbox_features_print_sub_menu').prop('disabled', false);
					}
					else
					{
						$('#md_checkbox_features_read_sub_menu').prop('checked', false);
						$('#md_checkbox_features_read_sub_menu').prop('disabled', true);
						$('#md_checkbox_features_add_sub_menu').prop('checked', false);
						$('#md_checkbox_features_add_sub_menu').prop('disabled', true);
						$('#md_checkbox_features_edit_sub_menu').prop('checked', false);
						$('#md_checkbox_features_edit_sub_menu').prop('disabled', true);
						$('#md_checkbox_features_delete_sub_menu').prop('checked', false);
						$('#md_checkbox_features_delete_sub_menu').prop('disabled', true);
						$('#md_checkbox_features_print_sub_menu').prop('checked', false);
						$('#md_checkbox_features_print_sub_menu').prop('disabled', true);
					}
				}
			<?php endif; ?>
	});
</script>