@foreach ($projects as $project)
  var project{{ $project->id }} = {!! json_encode($project) !!};
@endforeach
