<div class="left-sidebar-section">
	<div class="sidebar-container">
		<ul>
			@if(auth()->user()->isRole('admin'))
			<li class="menu-divider">
				Administrator Menu
			</li>
		    <li>
		        <a href="{{url('/home')}}"><i class="fa fa-home fa-fw"></i> Dashboard</a>
		    </li>
		    <li>
		        <a href="{{route('product.index')}}" class="@yield('admin-products')"><i class="fa fa-archive fa-fw"></i> Products</a>
		    </li>
		    <li>
		        <a href="{{route('customer.index')}}" class="@yield('admin-customers')"><i class="fa fa-user fa-fw"></i> Customers</a>
		    </li>
		    <li>
		        <a href="{{route('payment.index')}}" class="@yield('admin-payments')"><i class="fa fa-paypal fa-fw"></i> Payments</a>
		    </li>
		    <li>
		        <a href="{{route('user.index')}}" class="@yield('admin-users')"><i class="fa fa-users fa-fw"></i> Users</a>
		    </li>
		    <li>
		        <a href="{{route('role.index')}}" class="@yield('admin-roles')"><i class="fa fa-vcard fa-fw"></i> Roles</a>
		    </li>
		    <li>
		        <a href="{{route('menu.index')}}" class="@yield('admin-menus')"><i class="fa fa-list fa-fw"></i> Menus</a>
		    </li>
		    @else
		    <li class="menu-divider">
		    	<div style="width: 150px;margin: auto;">
			    	<button type="button" class="btn z-techno-btn z-techno-primary" onclick="document.getElementById('picture').click()" style="position: absolute;"><i class="fa fa-pencil"></i></button>
			    	@if(auth()->user()->customer && auth()->user()->customer->picture)
			    	<img class="left-profile-picture" src="{{asset('uploads/schools/'.auth()->user()->customer->school->id.'/'.auth()->user()->customer->picture)}}" width="100%">
			    	@elseif(auth()->user()->picture)
			    	<img class="left-profile-picture" src="{{asset('uploads/schools/'.auth()->user()->school[0]->id.'/'.auth()->user()->id.'/'.auth()->user()->picture)}}" width="100%">
			    	@else
			    	<img class="left-profile-picture" src="{{asset('assets/default.png')}}" width="100%">
			    	@endif
			    	<center>
			    	<a href="{{route('profile')}}" style="padding: 0; margin:0; padding-top: 5px;">{{auth()->user()->name}}</a>
			    	@if(auth()->user()->isRole('admin_sistem_informasi') && auth()->user()->customer->school)
			    	<small class="left-school-name">{{auth()->user()->customer->school->name}}</small>
			    	@elseif(auth()->user()->school && count(auth()->user()->school) > 0)
			    	<small class="left-school-name">{{auth()->user()->school[0]->name}}</small>
			    	@endif
			    	</center>

			    	<form method="post" id="formUpload" action="{{route('profile.upload')}}" enctype="multipart/form-data" style="display: none;">
                    	{{csrf_field()}}
                    	<input type="file" onchange="document.getElementById('formUpload').submit()" id="picture" class="form-control z-techno-el @error('picture') is-invalid @enderror" name="picture">
                    </form>
		    	</div>
		    </li>
		    <li>
		        <a href="{{url('/home')}}"><i class="fa fa-home fa-fw"></i> Dashboard</a>
		    </li>
		    @endif

		    @if(auth()->user()->isRole('admin_sistem_informasi'))
		    <li class="menu-divider">
				Sistem Informasi Menu
			</li>
		    	@if(auth()->user()->isRole('admin_sistem_informasi')->menus)
		    		@foreach(auth()->user()->isRole('admin_sistem_informasi')->menus()->orderby('ordered_number','asc')->get() as $menu)
		    <li>
		        <a href="{{route($menu->route)}}" class="@yield($menu->route)"><i class="fa fa-list fa-fw"></i> {{$menu->name}}</a>
		    </li>
		    		@endforeach
		    	@endif
		    @endif

		    @if(auth()->user()->isRole('siswa'))
		    <li class="menu-divider">
				Siswa Menu
			</li>
		    	@if(auth()->user()->isRole('siswa')->menus)
		    		@foreach(auth()->user()->isRole('siswa')->menus()->orderby('ordered_number','asc')->get() as $menu)
		    <li>
		        <a href="{{route($menu->route)}}" class="@yield($menu->route)"><i class="fa fa-list fa-fw"></i> {{$menu->name}}</a>
		    </li>
		    		@endforeach
		    	@endif
		    @endif

		    @if(auth()->user()->isRole('guru'))
		    <li class="menu-divider">
				Guru Menu
			</li>
		    	@if(auth()->user()->isRole('guru')->menus)
		    		@foreach(auth()->user()->isRole('guru')->menus()->orderby('ordered_number','asc')->get() as $menu)
		    <li>
		        <a href="{{route($menu->route)}}" class="@yield($menu->route)"><i class="fa fa-list fa-fw"></i> {{$menu->name}}</a>
		    </li>
		    		@endforeach
		    	@endif
		    @endif

		    @if(auth()->user()->isRole('wali_kelas'))
		    <li class="menu-divider">
				Wali Kelas Menu
			</li>
		    	@if(auth()->user()->isRole('wali_kelas')->menus)
		    		@foreach(auth()->user()->isRole('wali_kelas')->menus()->orderby('ordered_number','asc')->get() as $menu)
		    <li>
		        <a href="{{route($menu->route)}}" class="@yield($menu->route)"><i class="fa fa-list fa-fw"></i> {{$menu->name}}</a>
		    </li>
		    		@endforeach
		    	@endif
		    @endif

		    <li class="menu-divider">
				Storage
			</li>
		    <li>
		        <a href="#"><i class="fa fa-folder fa-fw"></i> Locker Storage</a>
		    </li>
		</ul>
	</div>
</div>