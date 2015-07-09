<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	{!! csrf_meta_tags() !!}

	<title>jQuery-Laravel with custom layout</title>

	{{--!! stylesheet_link_tag('app') !!--}}

	{{-- Size should be 32 x 32 pixels --}}
	{{-- favicon_link_tag('favicon.ico', ['rel' => 'shortcut icon']) --}}

	{{--!! javascript_include_tag('app') !!--}}
</head>
<body>
	<nav id='navbar_top' class="navbar navbar-default" data-turbolinks-permanent>
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">jQuery-Laravel demo</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ route('projects.index') }}" data-remote>Projects</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
    <section id="content">
      @yield('content')
    </section>{{-- /content --}}
  </div>{{-- /container --}}
</body>
</html>
