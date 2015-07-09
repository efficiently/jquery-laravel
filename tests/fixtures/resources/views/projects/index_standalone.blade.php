<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	{!! csrf_meta_tags() !!}

	<title>jQuery-Laravel without layout</title>
</head>
<body>
  <div class="container">
    <section id="content">
      <h1 class="page-header">All projects:</h1>
      <div id="projects">
        {{-- renders views/projects/_project.blade.php for each project --}}
        @foreach ($projects as $project)
          @include('projects._project')
        @endforeach
      </div>
    </section>{{-- /content --}}
  </div>{{-- /container --}}
</body>
</html>
