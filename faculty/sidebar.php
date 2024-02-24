  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">
   	<a href="./" class="brand-link">
        <h3 class="text-center p-0 m-0"><b>Faculty In-charge Panel</b></h3>

    </a>
    <style>
      h3, .h3 {
  font-size: 1rem;
}
    </style>
      
    </div>
    <div class="sidebar ">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
         <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <!-- <li class="nav-item dropdown">
            <a href="./index.php?page=request_form" class="nav-link nav-request_form">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Request
              </p>
            </a>
          </li>  -->
            <li class="nav-item dropdown">
              <a href="./index.php?page=view_report" class="nav-link nav-view_report">
                <i class="nav-icon fas fa-list-alt"></i>
                <p>
                  View Report
                </p>
              </a>
            </li> 
            <li class="nav-item dropdown">
              <a href="./index.php?page=room" class="nav-link nav-room">
                <i class="nav-icon fas fa-building"></i>
                <p>
                  Room
                </p>
              </a>
            </li> 
          
          
          
        </ul>
      </nav>
    </div>
  </aside>
  <script>
  	$(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;
  		if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
     
  	})
  </script>