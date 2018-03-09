<!DOCTYPE html>
<?php
    if($this->session->userdata('login') != TRUE AND $this->session->userdata('user_uid') == '')
    {
	redirect('login');
    }
    $set = $this->catalog->get_setting(array('row' => true));
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Web Administrator | <?php echo $set->web_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="shortcut icon" href="<?php echo $this->config->item('base_static')."/images/$set->web_favicon"; ?>">
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo $this->config->item('base_cdn').'/css/bootstrap/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo $this->config->item('base_cdn').'/css/bootstrap/css/build.css'; ?>">
    
    <!-- Font Awesome -->
    <link rel='stylesheet' href='<?php echo base_url(ASSETS.'/css/font-awesome/css/font-awesome.css'); ?>'>
    
    <!-- Default CSS -->
    <link rel='stylesheet' href='<?php echo $this->config->item('base_cdn').'/css/'.$this->config->item('base_theme').'/style.css'; ?>'>
    
    <script src='<?php echo $this->config->item('base_cdn').'/js/jquery-2.0.2.js'; ?>'></script>
    <script src='<?php echo $this->config->item('base_cdn').'/js/validation/jquery.validate.js'; ?>'></script>
    <script src='<?php echo $this->config->item('base_cdn').'/js/themes/'.$this->config->item('base_theme').'/admin.js'; ?>'></script>
    <script src='<?php echo $this->config->item('base_cdn').'/js/themes/'.$this->config->item('base_theme').'/main.js'; ?>'></script>
    <script src='<?php echo $this->config->item('base_cdn').'/js/themes/'.$this->config->item('base_theme').'/www.js'; ?>'></script>
    
    <!-- Pagination -->
    <link href='<?php echo $this->config->item('base_cdn').'/js/themes/'.$this->config->item('base_theme').'/pagination/style.css'; ?>' rel='stylesheet' type='text/css'>
    <script src='<?php echo $this->config->item('base_cdn').'/js/themes/'.$this->config->item('base_theme').'/pagination/jquery.pagination.js'; ?>'></script>
    
    <!-- Datetime -->
    <link href='<?php echo $this->config->item('base_cdn').'/js/datetime/jquery.datetimepicker.css'; ?>' rel='stylesheet' type='text/css'>
    <script src='<?php echo $this->config->item('base_cdn').'/js/datetime/jquery.datetimepicker.js'; ?>'></script>
    
    <!-- TinyMCE -->
    <script src='<?php echo base_url(ASSETS.'/js/tinymce/tinymce.js'); ?>'></script>
    
    <!-- iScroll -->
    <script src='<?php echo $this->config->item('base_cdn').'/js/scroll/iscroll/iscroll.js'; ?>'></script>
    
    <!-- Highcharts -->
    <script src='<?php echo $this->config->item('base_cdn').'/js/chart/highcharts/js/highcharts.js'; ?>'></script>
    <script src='<?php echo $this->config->item('base_cdn').'/js/chart/highcharts/js/modules/exporting.js'; ?>'></script>
    
    <!-- Bootstrap JS -->
    <script src="<?php echo $this->config->item('base_cdn').'/css/bootstrap/js/bootstrap.min.js'; ?>"></script>
    
    <!-- Chosen -->
    <script type="text/javascript" src="<?php echo $this->config->item('base_cdn').'/js/chosen/chosen.jquery.js'; ?>"></script>
    <link href="<?php echo $this->config->item('base_cdn').'/js/chosen/chosen.css'; ?>" rel="stylesheet" type="text/css" media="screen">
    <script>
	$(function() {
	    $('.chosen-select').chosen();
	    $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
	    $('.chosen-container').css({width: '100%'});
	    //$('.chosen-choices .search-field input').css({width: '100%'});
	});
    </script>

    <!-- Tags Input -->
    <link href='<?php echo $this->config->item('base_cdn').'/js/tags/bootstrap-tagsinput.css'; ?>' rel='stylesheet' type='text/css'>
    <script src='<?php echo $this->config->item('base_cdn').'/js/tags/bootstrap-tagsinput.js'; ?>'></script>
    <!--<select multiple data-role="tagsinput">
	<option value="Amsterdam">Amsterdam</option>
	<option value="Washington">Washington</option>
	<option value="Sydney">Sydney</option>
	<option value="Beijing">Beijing</option>
	<option value="Cairo">Cairo</option>
    </select>-->
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkZAL2EWQnhdKmkkVHppBsjzzAVQmtIk8&signed_in=true&libraries=places" async defer></script>
</head>
<body>
    <div id='header'>
	<div class='box_header'>
	    <div class='box_logo'>
		<?php
		    echo "<span style='background: url(".$this->config->item('base_static')."/images/$set->web_logo/medium".") center no-repeat; background-size: contain'></span>";
		?>
	    </div>
	    <div class='box_admin'>
		<div class='col-lg-6 col-md-6 col-sm-5 col-xs-3 hdlogo'>
		    <div class='hdtitle'>Web Administrator</div>
		    <?php
			echo "<span style='background: url(".$this->config->item('base_static')."/images/$set->web_logo/medium".") no-repeat left center; background-size: contain'></span>";
		    ?>
		</div>
		<div class='col-lg-6 col-md-6 col-sm-7 col-xs-9 hdmenu tx-right'>
		    <div id='menu-sidebar' class='hdbox hdside'><i class='fa fa-bars fa-fw'></i></div>
		    <div id='user-account' class='hdbox'><i class='fa fa-user fa-fw'></i></div>
		    <div id='comment' class='hdbox'><i class='fa fa-comments fa-fw'></i></div>
		    <div class='hdbox'>
			<a href='<?php echo base_url('../home'); ?>' title='View Web' target='_blank'>
			    <i class='fa fa-refresh fa-spin fa-fw'></i><span class='hdtext' style='margin-left: 5px;'>View Web</span>
			</a>
		    </div>
		    <div class='hdbox'>
			<a href='<?php echo base_url('login/signout'); ?>' title='Sign Out' >
			    <i class='fa fa-sign-out fa-fw'></i><span class='hdtext' style='margin-left: 5px;'>Sign Out</span>
			</a>
		    </div>
		</div>
	    </div>
	    <div style='clear: both;'></div>
	</div>
    </div>
    <div id='container'>
	<div id='sidebar'>
	    <div class='user_login'>
		<?php echo $this->session->userdata('user_fname'); ?>
	    </div>
	    <ul>
		<?php
		    $linkhost = $_SERVER['HTTP_HOST'];
		    $uri = explode("/", $_SERVER['REQUEST_URI']);
		    $link = explode('.', $linkhost);
		    
		    $domain = 0;
		    if($link[0] != 'www')
		    {
			$c = 0;
			switch($linkhost)
			{
			    case 'localhost': $c = 1; break;
			    case 'localhost:8081': $c = 1; break;
			}
			
			if($c > 0)
			{
			    /*if(isset($uri[6]))
			    {
				$newuri = $uri[5].'/'.$uri[6];
			    } else {
				$newuri = $uri[5];
			    }*/
			    $newuri = '';
			} else {
			    $domain = 1;
			}
		    } else {
			$domain = 1;
		    }
		    
		    if($domain > 0)
		    {
			if(isset($uri[3]))
			{
			    $newuri = $uri[2].'/'.$uri[3];
			} else {
			    $newuri = $uri[2];
			}
		    }
		    
		    $dt = array('sortBy' => 'menu_order', 'sortDir' => 'asc');
		    if($this->session->userdata('user_level') != 'admin')
		    {
			$dt = array_merge($dt, array('user_level' => $this->session->userdata('user_level')));
		    }
		    $mn = $this->catalog->get_menu(array_merge($dt, array('menu_parent' => 0, 'is_active' => 1)));
		    if($mn)
		    {
			$parent = (isset($parent)) ? $parent : '';
			foreach($mn as $m1)
			{
			    $menu_act = ($m1->menu_name == $parent) ? 'mn-active' : '';
			    $menu_url1 = ($m1->menu_url == '#') ? 'javascript:void(0)' : base_url("$m1->menu_url");
			    $ulevel = $this->library->user_check();
			    $umenu = ($ulevel->ff == 0) ? 'mnmenu' : '';
			    echo "<li><a href='$menu_url1' class='$umenu $menu_act' id='gp-$m1->menu_icon'><i class='fa $m1->menu_icon fa-fw'></i>$m1->menu_name</a>";
			    
			    $submn = $this->catalog->get_menu(array_merge($dt, array('menu_parent' => $m1->menu_id, 'is_active' => 1)));
			    if($submn)
			    {
				$menu_act = ($m1->menu_name == $parent) ? 'active="true" style="display: block;"' : '';
				$udisplay = ($ulevel->ff > 0) ? 'style="display: block;"' : '';
				echo "<div class='submenu' id='gp-$m1->menu_icon' $menu_act $udisplay><ul>";
				foreach($submn as $m2)
				{
				    $menu_url2 = ($m2->menu_url == '#') ? 'javascript:void(0)' : base_url("$m2->menu_url");
				    $active = ($newuri == $m2->menu_url) ? 'active' : '';
				    echo "<li><a href='$menu_url2' class='$active'>$m2->menu_name</a>";
				    
				    $xsubmn = $this->catalog->get_menu(array_merge($dt, array('menu_parent' => $m2->menu_id)));
				    if($xsubmn)
				    {
					echo "<ul>";
					foreach($xsubmn as $m3)
					{
					    $menu_url3 = ($m3->menu_url == '#') ? 'javascript:void(0)' : base_url("$m3->menu_url");
					    echo "<li><a href='$menu_url3'>$m3->menu_name</a></li>";
					}
					echo "</ul>";
				    }
				    
				    echo "</li>";
				}
				echo "</ul></div>";
			    }
			    
			    echo "</li>";
			}
		    }
		?>
	    </ul>
	</div>
	<div id='content'>
	    <div class='boxcontent'>
		<?php echo $this->load->view($content); ?>
	    </div>
	</div>
	<div class='jqtest' val='false'></div>
	<div class='base_url' val='<?php echo base_url(); ?>'></div>
    </div>
    <div class='xh'></div>
</body>
</html>