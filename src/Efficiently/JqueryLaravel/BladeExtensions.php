<?php namespace Efficiently\JqueryLaravel;

class BladeExtensions
{
    protected $blade;

    public function __construct($blade)
    {
        $this->blade = $blade;
        $this->registerContentTags();
    }

    public function registerContentTags()
    {
        $this->blade->extend(function ($view, $compiler) {

            $contentTags = [
                "a", "abbr", "acronym", "address", "applet", "article", "aside", "audio", "b", "basefont", "bdi", "bdo",
                "big", "blockquote", "body", "button", "canvas", "caption", "center", "cite", "code", "colgroup", "datalist",
                "dd", "del", "details", "dfn", "dialog", "dir", "div", "dl", "dt", "em", "fieldset", "figcaption", "figure",
                "font", "footer"/*, "form"*/, "frame", "frameset", "h1", "h2", "h3", "h4", "h5", "h6", "head", "header", "html",
                "i", "iframe", "ins", "kbd", "label", "legend", "li", "main", "map", "mark", "menu", "meter", "nav", "noframes",
                "noscript", "object", "ol", "optgroup", "option", "output", "p", "pre", "progress", "q", "rp", "rt", "ruby", "s",
                "samp", "script", "section", "select", "small", "span", "strike", "strong", "style", "sub", "summary", "sup",
                "table", "tbody", "td", "textarea", "tfoot", "th", "thead", "time", "title", "tr", "tt", "u", "ul", "var", "video"
            ];

            $contentTagsPattern = implode("|", $contentTags);
            // Convert @<tag>_tag to @content_tag('<tag>') extension
            // E.g. "@div_tag blabla @end_div_tag" becomes "@content_tag('div') blabla @end_contag_tag('div')"
            $contentTagsPattern = '/@('.$contentTagsPattern.')_(tag)(\(([^\r\n]*?)\)|[\r\n\s\t]*)([\r\n\s\t]+)/';
            if (preg_match($contentTagsPattern, $view, $result)) {
                $attributes = array_filter(preg_split('/\s?,\s?/', array_get($result, 4, [])));
                array_unshift($attributes, '"'.array_get($result, 1).'"');
                $replacement = '@content_$2('.implode(", ", $attributes).')$5';
                $view = preg_replace($contentTagsPattern, $replacement, $view);
            }

            $contentTagsPattern = implode("|", $contentTags);
            // Convert @<tag>_for to @content_tag_for(object, '<tag>') extension
            // E.g. "@div_for(object) blabla" becomes "@content_tag_for(object, 'div') blabla"
            $contentTagsPattern = '/@('.$contentTagsPattern.')_(tag_for|for)\((.+)\)([\r\n\s\t]+)/';
            if (preg_match($contentTagsPattern, $view)) {
                $replacement = '@content_tag_for("$1", $3)$4';
                $view = preg_replace($contentTagsPattern, $replacement, $view);
            }

            $contentTagsPattern = implode("|", $contentTags);
            // Convert @end_<tag>_tag and @end_<tag>_for to @endcontent_tag('<tag>') and @endcontent_tag_for('<tag>') extensions
            // E.g. "blabla @enddiv_for" becomes "blabla @endcontag_tag_for('div')"
            $contentTagsPattern = '/@end_?('.$contentTagsPattern.')_(tag|tag_for|for)([\r\n\s\t]+)/';
            if (preg_match($contentTagsPattern, $view, $matches)) {
                $type = array_get($matches, 2);
                if ($type === 'for') {
                    $type = 'tag_'.$type;
                }
                $replacement = '@endcontent_'.$type.'("$1")$3';
                $view = preg_replace($contentTagsPattern, $replacement, $view);
            }

            // Converts @content_tag extension in PHP code equivalent
            $pattern = '/@content_?tag\s?(\(([^\r\n]+?)\)|[\r\n\s\t]*)([\r\n\s\t]+)/s';
            if (preg_match_all($pattern, $view, $results, PREG_SET_ORDER)) {
                foreach ($results as $index => $result) {
                    $attributes = preg_split('/\s?,\s?/', array_get($result, 2, []));
                    $tagName = array_get(array_filter($attributes), 0, "'div'");

                    $options = count($attributes) >= 2 ? implode(array_slice($attributes, 1), ',') : "[]";
                    $replacement = "<?php echo '<'.$tagName.app('html')->attributes($options).'>';$3 ?>";
                    $view = preg_replace($pattern, $replacement, $view, 1);
                }
            }

            // Converts @endcontent_tag extension in PHP code equivalent
            $pattern = '/@end_?content_?tag\s?(\(([^\r\n]+?)\)|[\r\n\s\t]*)([\r\n\s\t]+)/s';
            if (preg_match_all($pattern, $view, $results, PREG_SET_ORDER)) {
                foreach ($results as $index => $result) {
                    $attributes = preg_split('/\s?,\s?/', array_get($result, 2, []));
                    $tagName = array_get(array_filter($attributes), 0, "'div'");

                    $replacement = "<?php echo '</'.$tagName.'>';$3 ?>";
                    $view = preg_replace($pattern, $replacement, $view, 1);
                }
            }

            // Converts @content_tag_for extension in PHP code equivalent
            $pattern = '/@content_?tag_?for\s?\(([^\r\n]+?)\)(\s+as\s?\(([^\r\n]+?)\)|)([\r\n\s\t]+)/s';
            if (preg_match_all($pattern, $view, $results, PREG_SET_ORDER)) {
                foreach ($results as $index => $result) {
                    $attributes = preg_split('/\s?,\s?/', array_get($result, 1, []));
                    $tagName = array_get(array_filter($attributes), 0, "'div'");
                    $record = array_get($attributes, 1);
                    $prefix = array_get($attributes, 2, "null");
                    $options = count($attributes) >= 4 ? implode(array_slice($attributes, 3), ',') : "[]";

                    $asOption = preg_split('/, */', array_get($result, 3));

                    $recordName = array_get($asOption, 0);
                    $recordName = preg_replace('/^\$/', '', $recordName ?: $record);

                    $recordIndex = array_get($asOption, 1);
                    $recordIndex = preg_replace('/^\$/', '', $recordIndex ?: $recordName.'Index');

                    $replacement = <<<EOT
<?php
    \${$recordName}Record = $record;
    if (! is_a(\${$recordName}Record, "\Illuminate\Support\Collection")) {
        \${$recordName}Record = new \Illuminate\Support\Collection([\${$recordName}Record]);
    }
    \${$recordIndex} = -1;// -1 because we increment index at the beginnning of the loop
    \${$recordName}Record->each(function(\${$recordName}) use(\$__env, &\${$recordIndex}){
        \${$recordIndex}++;
        \$options = (array) $options;
        \$options['class'] = implode(" ",
            array_filter([dom_class(\${$recordName}, $prefix), array_get(\$options, 'class')])
        );
        \$options['id'] = dom_id(\${$recordName}, $prefix);
        echo '<'.$tagName.app('html')->attributes(\$options).'>';
?>
EOT;
                    $view = preg_replace($pattern, $replacement, $view, 1);
                }
            }

            // Converts @endcontent_tag_for extension in PHP code equivalent
            $pattern = '/@end_?content_?tag_?for\s?(\(([^\r\n]+?)\)|[\r\n\s\t]*)([\r\n\s\t]+)/s';
            if (preg_match_all($pattern, $view, $results, PREG_SET_ORDER)) {
                foreach ($results as $index => $result) {
                    $attributes = preg_split('/\s?,\s?/', array_get($result, 2, []));
                    $tagName = array_get(array_filter($attributes), 0, "'div'");

                    $replacement = <<<EOT
<?php
        echo '</'.$tagName.'>';$3
    });
?>
EOT;
                    $view = preg_replace($pattern, $replacement, $view, 1);
                }
            }

            return $view;
        });

    }
}
