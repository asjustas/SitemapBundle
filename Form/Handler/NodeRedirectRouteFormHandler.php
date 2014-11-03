<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\Bundle\SitemapBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/1/14 8:01 PM
 */
class NodeRedirectRouteFormHandler
{
    public function process(Request $request, FormInterface $form)
    {
        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {


                return true;
            }
        }

        return false;
    }
}
