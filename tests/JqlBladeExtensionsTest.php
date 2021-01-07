<?php

use Mockery as m;

class JqlBladeExtensionsTest extends JqlTestCase
{
    public function testContentTag()
    {
        $contentTag = <<<EOT
@content_tag('div')
text
@endcontent_tag('div')

EOT;
        $expect = <<<EOT
<?php echo '<'.'div'.app('html')->attributes([]).'>';
 ?>text
<?php echo '</'.'div'.'>';
 ?>
EOT;
        $view = Blade::compileString($contentTag);
        $this->assertEquals($expect, $view);

        $expect2 = <<<EOT
<?php echo '<'.'div'.app('html')->attributes([]).'>';  ?>text2 <?php echo '</'.'div'.'>';
 ?>
EOT;
        $this->assertNotEquals($expect2, $view);

        $contentTag2 = <<<EOT
@content_tag('div') text2 @end_content_tag('div')

EOT;
        $view2 = Blade::compileString($contentTag2);
        $this->assertEquals($expect2, $view2);
    }

    public function testContentTagWithAttributes()
    {
        $contentTag = <<<EOT
@content_tag('div', ['class' => 'div-tag-class'])
text
@endcontent_tag('div')

EOT;
        $expect = <<<EOT
<?php echo '<'.'div'.app('html')->attributes(['class' => 'div-tag-class']).'>';
 ?>text
<?php echo '</'.'div'.'>';
 ?>
EOT;
        $view = Blade::compileString($contentTag);
        $this->assertEquals($expect, $view);

        $expect2 = <<<EOT
<?php echo '<'.'div'.app('html')->attributes(['id' => 'div_tag_id']).'>';  ?>text2 <?php echo '</'.'div'.'>';
 ?>
EOT;
        $this->assertNotEquals($expect2, $view);

        $contentTag2 = <<<EOT
@content_tag('div', ['id' => 'div_tag_id']) text2 @end_content_tag('div')

EOT;
        $view2 = Blade::compileString($contentTag2);
        $this->assertEquals($expect2, $view2);
    }

    public function testContentTagFor()
    {
        // Existing Project
        $project = new Jql\Project;
        $project->id = 3;
        $project->exists = true;

        $contentTagFor = <<<EOT
@content_tag_for('div', \$project)
text
@endcontent_tag_for('div')

EOT;
        $expect = <<<EOT
<?php
    \$projectRecord = \$project;
    if (! is_array(\$projectRecord) && ! is_a(\$projectRecord, "\IteratorAggregate")) {
        \$projectRecord = new \Illuminate\Support\Collection([\$projectRecord]);
    }
    \$projectIndex = -1;// -1 because we increment index at the beginnning of the loop
    foreach (\$projectRecord as \$project) {
        \$projectIndex++;
        \$options = (array) [];
        \$options['class'] = implode(" ",
            array_filter([dom_class(\$project, null), \Illuminate\Support\Arr::get(\$options, 'class')])
        );
        \$options['id'] = dom_id(\$project, null);
        echo '<'.'div'.app('html')->attributes(\$options).'>';
?>text
<?php
        echo '</'.'div'.'>';

    }
?>
EOT;
        $view = Blade::compileString($contentTagFor);
        $this->assertEquals($expect, $view);
    }

    public function testContentTagForWithOptions()
    {
        // Existing Project
        $project = new Jql\Project;
        $project->id = 3;
        $project->exists = true;

        $contentTagFor = <<<EOT
@content_tag_for('div', \$project, 'edit_prefix', ['remote' => 'true'])
text
@endcontent_tag_for('div')

EOT;
        $expect = <<<EOT
<?php
    \$projectRecord = \$project;
    if (! is_array(\$projectRecord) && ! is_a(\$projectRecord, "\IteratorAggregate")) {
        \$projectRecord = new \Illuminate\Support\Collection([\$projectRecord]);
    }
    \$projectIndex = -1;// -1 because we increment index at the beginnning of the loop
    foreach (\$projectRecord as \$project) {
        \$projectIndex++;
        \$options = (array) ['remote' => 'true'];
        \$options['class'] = implode(" ",
            array_filter([dom_class(\$project, 'edit_prefix'), \Illuminate\Support\Arr::get(\$options, 'class')])
        );
        \$options['id'] = dom_id(\$project, 'edit_prefix');
        echo '<'.'div'.app('html')->attributes(\$options).'>';
?>text
<?php
        echo '</'.'div'.'>';

    }
?>
EOT;
        $view = Blade::compileString($contentTagFor);
        $this->assertEquals($expect, $view);
    }


    public function testDivTag()
    {
        $divTag = <<<EOT
@div_tag
text
@enddiv_tag

EOT;
        $expect = <<<EOT
<?php echo '<'."div".app('html')->attributes([]).'>';
 ?>text
<?php echo '</'."div".'>';
 ?>
EOT;
        $view = Blade::compileString($divTag);
        $this->assertEquals($expect, $view);

        $expect2 = <<<EOT
<?php echo '<'."div".app('html')->attributes([]).'>';  ?>text2 <?php echo '</'."div".'>';
 ?>
EOT;
        $this->assertNotEquals($expect2, $view);

        $divTag2 = <<<EOT
@div_tag text2 @end_div_tag

EOT;
        $view2 = Blade::compileString($divTag2);
        $this->assertEquals($expect2, $view2);
    }

    public function testDivTagWithAttributes()
    {
        $divTag = <<<EOT
@div_tag(['class' => 'div-tag-class'])
text
@enddiv_tag

EOT;
        $expect = <<<EOT
<?php echo '<'."div".app('html')->attributes(['class' => 'div-tag-class']).'>';
 ?>text
<?php echo '</'."div".'>';
 ?>
EOT;
        $view = Blade::compileString($divTag);
        $this->assertEquals($expect, $view);

        $expect2 = <<<EOT
<?php echo '<'."div".app('html')->attributes(['id' => 'div_tag_id']).'>';  ?>text2 <?php echo '</'."div".'>';
 ?>
EOT;
        $this->assertNotEquals($expect2, $view);

        $divTag2 = <<<EOT
@div_tag(['id' => 'div_tag_id']) text2 @end_div_tag

EOT;
        $view2 = Blade::compileString($divTag2);
        $this->assertEquals($expect2, $view2);
    }
}
