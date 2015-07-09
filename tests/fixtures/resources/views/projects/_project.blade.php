@div_for($project, null, ['class' => 'row'])
  <div class="col-lg-10 col-md-8 col-sm-6">
    <dl class="dl-horizontal">
      <dt>Name</dt>
      <dd>
        {{ $project->name }}
      </dd>

      <dt>Priority</dt>
      <dd>
        {{ $project->priority }}
      </dd>
    </dl>
  </div>
@end_div_for
