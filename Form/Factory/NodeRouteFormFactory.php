<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\Bundle\SitemapBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;
use Tadcka\Component\Tree\Model\NodeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since  14.10.25 22.10
 */
class NodeRouteFormFactory
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var array
     */
    private $allowedLinkAttributes;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     * @param array $allowedLinkAttributes
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        array $allowedLinkAttributes
    ) {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->allowedLinkAttributes = $allowedLinkAttributes;
    }

    /**
     * Create node route.
     *
     * @param NodeInterface $node
     *
     * @return FormInterface
     */
    public function create(NodeInterface $node)
    {
        return $this->formFactory->create(
            'tadcka_sitemap_node_route',
            $node,
            array(
                'action' => $this->router->getContext()->getPathInfo(),
                'allowed_link_attributes' => $this->allowedLinkAttributes,
            )
        );
    }
}
