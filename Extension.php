<?php

namespace Bolt\Extension\DisenoActivo\HtmlMinifier;

use Bolt\Application;
use Bolt\BaseExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Extension extends BaseExtension
{



    public function initialize() {


        //not debugging, so that we don't be slower when developping
        //exclude backend
        if(!$this->app['config']->get('general/debug') && $this->app['config']->getWhichEnd()!='backend')
        {


            //after rendering, we sanitize the HTML
            $this->app->after(function (Request $request, Response $response) {

                //we have to make sure is only the output of the HTML that is minified, Silex/Bolt also handle all the other files
                //you should add more file extensions if it gives you problem with the output
                if($this->getExtension($request->getPathInfo())!=".css" && $this->getExtension($request->getPathInfo())!=".js")
                {
                    $uri = $request->getRequestUri();
                    $content = $response->getContent();
                    $content=$this->sanitize_output($content);
                    $response->setContent($content);
                }
        });
        }

    }

    public function getName()
    {
        return "htmlminifier";
    }

    private function getExtension($file)
    {
        return strtolower(strrchr($file,"."));
    }



    private  function sanitize_output($buffer) {

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


}






