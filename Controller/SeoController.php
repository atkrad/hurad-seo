<?php

App::uses('HuradSeoAppController', 'HuradSeo.Controller');

/**
 * Class SeoController
 */
class SeoController extends HuradSeoAppController
{
    /**
     * An array containing the class names of models this controller uses.
     *
     * @var mixed A single name as a string or a list of names as an array.
     */
    public $uses = ['Option'];

    /**
     * Called before the all controller action
     *
     * @param array $user Current user
     *
     * @return mixed
     */
    public function isAuthorized($user)
    {
        switch ($user['role']) {
            case "administrator":
                return Hurad::allowAuth();
            case "editor":
            case "author":
            case "user":
                return Hurad::denyAuth();
                break;
            default:
                return Hurad::denyAuth();
                break;
        }
    }

    /**
     * Configuration action
     */
    public function admin_config()
    {
        $this->set('title_for_layout', __d('hurad_seo', 'Configuration'));

        if ($this->request->is('post')) {
            $tmpOption = [];
            foreach ($this->request->data as $pluginName => $options) {
                foreach ($options as $option => $value) {
                    $tmpOption[$pluginName . '.' . $option] = $value;
                }
            }
            $optionData['Option'] = $tmpOption;

            if ($this->Option->update($optionData)) {
                $this->Session->setFlash(
                    __d('hurad_seo', 'configuration have been updated.'),
                    'flash_message',
                    ['class' => 'success']
                );
            } else {
                $this->Session->setFlash(
                    __d('hurad_seo', 'Unable to update configuration.'),
                    'flash_message',
                    ['class' => 'danger']
                );
            }
        } else {
            $this->request->data['HuradSeo'] = Configure::read('HuradSeo');
        }
    }
}
