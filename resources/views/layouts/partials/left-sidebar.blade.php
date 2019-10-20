<div class="left-sidebar-section">
	<div class="sidebar-container">
		<ul>
		    <li>
		        <a href="#"><i class="fa fa-home fa-fw"></i> Dashboard</a>
		    </li>
		    <li>
		        <a href="{{route('product.index')}}"><i class="fa fa-archive fa-fw"></i> Products</a>
		    </li>
		    <li>
		        <a href="#"><i class="fa fa-user fa-fw"></i> Customers</a>
		    </li>
		    <li>
		        <a href="#"><i class="fa fa-paypal fa-fw"></i> Payments</a>
		    </li>
		    <li>
		        <a href="#"><i class="fa fa-users fa-fw"></i> Users</a>
		    </li>
		    <li>
		        <a href="#"><i class="fa fa-vcard fa-fw"></i> Role</a>
		    </li>
		    <li>
		    	<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
		    		<i class="fa fa-sign-out fa-fw"></i>  {{ __('Logout') }}
		    	</a>

		    	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		    		@csrf
		    	</form>
		    </li>
		</ul>
	</div>
</div>