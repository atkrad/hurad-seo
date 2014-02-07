<?php

App::uses('CakeEventListener', 'Event');

/**
 * Class HuradSeoListener
 */
class HuradSeoListener implements CakeEventListener
{

    /**
     * Returns a list of events this object is implementing. When the class is registered
     * in an event manager, each individual method will be associated with the respective event.
     *
     * ## Example:
     *
     * {{{
     *    public function implementedEvents() {
     *        return array(
     *            'Order.complete' => 'sendEmail',
     *            'Article.afterBuy' => 'decrementInventory',
     *            'User.onRegister' => array('callable' => 'logRegistration', 'priority' => 20, 'passParams' => true)
     *        );
     *    }
     * }}}
     *
     * @return array associative array or event key names pointing to the function
     * that should be called in the object when the respective event is fired
     */
    public function implementedEvents()
    {
        return [
            'View.Header' => [
                ['callable' => 'putKeywordDescriptionOnHeader', 'priority' => 1, 'passParams' => false],
                ['callable' => 'putWebmasterToolsConfigOnHeader', 'priority' => 2, 'passParams' => false]
            ],
        ];
    }

    /**
     * Put keywords and description meta on per page
     *
     * @param CakeEvent $event Represents the transport class of events across the system.
     *
     * @return string
     */
    public function putKeywordDescriptionOnHeader(CakeEvent $event)
    {
        $router = Router::getParams();

        if ($router['controller'] == 'posts') {
            /** @var $post Post */
            $post = ClassRegistry::init('Post');

            if ($router['action'] == 'view') {
                $conditions = ['Post.slug' => $router['slug']];
            } elseif ($router['action'] == 'viewByid') {
                $conditions = ['Post.id' => $router['id']];
            } else {
                return null;
            }

            $postData = $post->find(
                'first',
                ['recursive' => 0, 'contain' => ['PostMeta'], 'conditions' => $conditions]
            );

            $meta = [];
            $postMeta = $this->getPostMeta($postData['PostMeta']);
            if (array_key_exists('HuradSeo_keywords', $postMeta) && !empty($postMeta['HuradSeo_keywords'])) {
                $meta[] = $event->subject()->Html->meta('keywords', $postMeta['HuradSeo_keywords']);
            }

            if (array_key_exists('HuradSeo_description', $postMeta) && !empty($postMeta['HuradSeo_description'])) {
                $meta[] = $event->subject()->Html->meta('description', $postMeta['HuradSeo_description']);
            }

            echo implode("\n", $meta);
        }
    }

    /**
     * Put webmaster tools config on header
     *
     * @param CakeEvent $event Represents the transport class of events across the system.
     *
     * @return string
     */
    public function putWebmasterToolsConfigOnHeader(CakeEvent $event)
    {
        $router = Router::getParams();

        if ($router['controller'] == 'posts' && $router['action'] == 'index') {
            $meta = [];
            if (Configure::check('HuradSeo')) {
                $verification = Configure::read('HuradSeo.google_webmaster_verification');
                if (Configure::check('HuradSeo.google_webmaster_verification') && !empty($verification)) {
                    $meta[] = $event->subject()->Html->meta(
                        ['name' => 'google-site-verification', 'content' => $verification]
                    );
                }
            }

            echo implode("\n", $meta);
        }
    }

    /**
     * Iterate post meta result
     *
     * @param array $postMeta PostMeta result
     *
     * @return array
     */
    protected function getPostMeta($postMeta)
    {
        $tmpPostMeta = [];

        if ($postMeta) {
            foreach ($postMeta as $pMeta) {
                $tmpPostMeta[$pMeta['meta_key']] = $pMeta['meta_value'];
            }
        }

        return $tmpPostMeta;
    }
}