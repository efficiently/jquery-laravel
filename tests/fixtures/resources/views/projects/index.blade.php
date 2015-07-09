@section('content')
  <h1 class="page-header">All projects:</h1>
  <div id="projects">
    {{-- renders views/projects/_project.blade.php for each project --}}
    @foreach ($projects as $project)
      @include('projects._project')
    @endforeach
  </div>
@stop
