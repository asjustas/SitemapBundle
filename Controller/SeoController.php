<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\Bundle\SitemapBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Tadcka\Bundle\SitemapBundle\Frontend\Model\ResponseContent;
use Tadcka\Bundle\SitemapBundle\Model\NodeInterface;
use Tadcka\Bundle\SitemapBundle\Model\NodeTranslationInterface;
use Tadcka\Component\Tree\Event\TreeNodeEvent;
use Tadcka\Component\Tree\TadckaTreeEvents;
use Tadcka\Bundle\SitemapBundle\Form\Factory\SeoFormFactory;
use Tadcka\Bundle\SitemapBundle\Form\Handler\SeoFormHandler;
use Tadcka\Bundle\SitemapBundle\Frontend\Message\Messages;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since  14.6.29 20.57
 */
class SeoController extends AbstractController
{
    public function indexAction(Request $request, $nodeId)
    {
        $node = $this->getNodeOr404($nodeId);
        $hasController = $this->getRouterHelper()->hasRouteController($node->getType());
        $messages = new Messages();
        $form = $this->getFormFactory()->create(array('translations' => $node->getTranslations()), $hasController);

        if ($this->getFormHandler()->process($request, $form, $node)) {
            $this->getEventDispatcher()->dispatch(TadckaTreeEvents::NODE_EDIT_SUCCESS, new TreeNodeEvent($node));
            $this->getNodeManager()->save();

            $messages->addSuccess($this->translate('success.seo_save'));
            $form = $this->getFormFactory()->create($form->getData(), $hasController);
        }

        if ($request->isXmlHttpRequest()) {
            $content = new ResponseContent();
            $content->setMessages($this->getMessageHtml($messages));
            $content->setTab(
                $this->render('TadckaSitemapBundle:Seo:seo.html.twig', array('form' => $form->createView()))
            );
            $content->setToolbar($this->getToolbarHtml($node));

            return $this->getJsonResponse($content);
        }

        return $this->renderResponse(
            'TadckaSitemapBundle:Seo:seo.html.twig',
            array(
                'form' => $form->createView(),
                'messages' => $messages,
            )
        );
    }


    public function onlineAction($locale, $nodeId)
    {
        $content = new ResponseContent();
        $messages = new Messages();
        $node = $this->getNodeOr404($nodeId);
        /** @var NodeTranslationInterface $nodeTranslation */
        $nodeTranslation = $node->getTranslation($locale);

        if (null === $nodeTranslation) {
            $messages->addError($this->translate('node_translation_not_found', array('%locale%' => $locale)));
            $content->setMessages($this->getMessageHtml($messages));

            return $this->getJsonResponse($content);
        }

        if ($this->nodeParentIsOnline($node->getParent(), $locale)) {
            $messages->addWarning($this->translate('node_parent_is_not_online', array('%locale%' => $locale)));
            $content->setMessages($this->getMessageHtml($messages));

            return $this->getJsonResponse($content);
        }

        $nodeTranslation->setOnline(!$nodeTranslation->isOnline());
        $this->getNodeTranslationManager()->save();

        $messages->addSuccess($this->translate('success.online_save'));
        $content->setMessages($this->getMessageHtml($messages));
        $content->setToolbar($this->getToolbarHtml($node));

        return $this->getJsonResponse($content);
    }

    /**
     * @return SeoFormFactory
     */
    private function getFormFactory()
    {
        return $this->container->get('tadcka_sitemap.form_factory.seo');
    }

    /**
     * @return SeoFormHandler
     */
    private function getFormHandler()
    {
        return $this->container->get('tadcka_sitemap.form_handler.seo');
    }

    /**
     * Check if node parent is online.
     *
     * @param NodeInterface $parent
     * @param $locale
     *
     * @return bool
     */
    private function nodeParentIsOnline(NodeInterface $parent, $locale)
    {
        $hasController = $this->getRouterHelper()->hasRouteController($parent->getType());

        if ((null !== $parent) && $hasController) {
            /** @var NodeTranslationInterface $translation */
            $translation = $parent->getTranslation($locale);
            if (null === $translation || !$translation->isOnline()) {
                return false;
            }
        }

        return true;
    }
}
