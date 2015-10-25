bolt-htmlminifier
======================

A simple extension to minify the HTML output.

*ATTENTION:* it only works if debug is false (in config.yml)

We simply pass the following function to the output rendered:


function sanitize_output($buffer) {

$search = array(
'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
'/[^\S ]+\</s',  // strip whitespaces before tags, except space
'/(\s)+/s'       // shorten multiple whitespace sequences
);

$replace = array(
'>',
'<',
'\\1'
);

$buffer = preg_replace($search, $replace, $buffer);



return $buffer;
}