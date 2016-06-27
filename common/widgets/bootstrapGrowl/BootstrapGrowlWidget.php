<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.04.2016
 * Time: 13:47
 */

/**
 * Yii::$app->session->setFlash('0',
 *      [
 *          'type'      => 'info',
 *          'icon'      => 'glyphicon glyphicon-envelope',
 *          'title'     => 'Title',
 *          'message'   => 'Message',
 *      ]
 * );
 * // для нескольких сообщений
 * Yii::$app->session->setFlash('1',
 *      [
 *          'type'      => 'danger',
 *          'icon'      => 'glyphicon glyphicon-envelope',
 *          'title'     => 'Title',
 *          'message'   => 'Message',
 *      ]
 * );
*/

namespace common\widgets\BootstrapGrowl;

use yii\bootstrap\Widget;

class BootstrapGrowlWidget extends Widget
{
    private $type = 'info';
    private $icon;
    private $title;
    private $message;
    private $url;
    private $target;

    public function init()
    {
        parent::init();

        $session = \Yii::$app->session;
        $message = $session->get('message');

        //dd($message);

        $view = $this->getView();
        BootstrapGrowlAsset::register($view);

        if(isset($message)) {
            $this->setOptions($message);
            \Yii::$app->view->registerJs("
                $.notify({
                    icon:       '".$this->icon."',
                    title:      '".$this->title."',
	                message:    '".$this->message."',
	                url:        '".$this->url."',
	                target:     '".$this->target."',
                },{
                    // settings
                    element: 'body',
                    position: null,
                    type:       '".$this->type."',
                    allow_dismiss: true,
                    newest_on_top: false,
                    showProgressbar: false,
                    placement: {
                        from: \"top\",
                        align: \"right\"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1031,
                    delay: 5000,
                    timer: 1000,
                    url_target: '_blank',
                    mouse_over: null,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                    onShow: null,
                    onShown: null,
                    onClose: null,
                    onClosed: null,
                    icon_type: 'class'
                });
            ");
            $session->remove('message');
        }
    }

    private function setOptions($value) {
        if(isset($value['type']))
            $this->type = $value['type'];
        if(isset($value['icon']))
            $this->icon = $value['icon'];
        if(isset($value['title']))
            $this->title = $value['title'];
        if(isset($value['message']))
            $this->message = $value['message'];
        if(isset($value['url']))
            $this->url = $value['url'];
        if(isset($value['target']))
            $this->target = $value['target'];
    }
}