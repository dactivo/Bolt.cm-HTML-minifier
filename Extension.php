<?php

namespace Bolt\Extension\DisenoActivo\HtmlMinifier;

use Bolt\Application;
use Bolt\BaseExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Extension extends BaseExtension
{



    public function initialize() {


        if(!$this->app['config']->get('general/debug'))
        {

        //Add a Silex middleware to inject contact form into content
        $this->app->after(function (Request $request, Response $response) {

            $uri = $request->getRequestUri();
            //Don't be active on routes that have "editcontent" in them.  We don't want to affect the bolt backend.
            if ($this->app['config']->getWhichEnd()!='backend')
            {
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






