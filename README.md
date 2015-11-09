bolt-htmlminifier
======================

A simple extension to minify the HTML output.

*ATTENTION:* it only works if debug is false (in config.yml)

We simply pass the following function to the output rendered:

```
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
```

I have detected that the methods in the Bolt file "Bolt/Src/Extensions.php", that will be deprecated: insertEndOfHead and the like, do not work well with this extension, because of the regex pattern:
```
if (preg_match("~^([ \t]*)</head~mi", $html, $matches)) {

}
```

*Solution:*
Replace it removing the "^" of all these functions and it will work, result:
```
if (preg_match("~([ \t]*)
```

This solution has been accepted by the Bolt team as a fix, so it will be like that in the future of Bolt:
https://github.com/bolt/bolt/pull/4367
