<div class="sidebar" data-color="purple" data-image="/../files/admin_dashboard/img/sidebar-1.jpg">
	<!--
		Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"
        Tip 2: you can also add an image using data-image tag
    -->
	<div class="logo">
		<a href="/admin/dashboard" class="simple-text">
			Dashboard
		</a>
	</div>
	<div class="sidebar-wrapper">
        <ul class="nav">
            <li class="<?php echo $controller == 'dashboard' ? 'active' : '' ?>">
                <a href="/admin/dashboard">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="<?php echo $controller == 'users' ? 'active' : '' ?>">
                <a href="/admin/users/list">
                    <i class="material-icons">person</i>
                    <p>Users</p>
                </a>
            </li>
            <li class="<?php echo $controller == 'tables' ? 'active' : '' ?>">
                <a href="/admin/tables/list">
                    <i class="material-icons">all_out</i>
                    <p>Tables</p>
                </a>
            </li>
            <li class="<?php echo $controller == 'categories' ? 'active' : '' ?>">
                <a href="/admin/categories/list">
                    <i class="material-icons">list</i>
                    <p>Categories</p>
                </a>
            </li>
            <li>
                <a href="/admin/users/logout">
                    <i class="material-icons">power_settings_new</i>
                    <p>Logout</p>
                </a>
            </li>

        </ul>
	</div>
</div>