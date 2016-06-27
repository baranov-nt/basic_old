<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.04.2016
 * Time: 15:40
 */

namespace common\widgets\SlideReveal;

use yii\bootstrap\Widget;
use common\widgets\SlideReveal\assets\SlideRevealWidgetAsset;
use common\widgets\SlideReveal\models\NoticeServiceForm;

class SlideRevealWidget extends Widget
{
    public $header;
    public $idButton;
    public $idBlock;
    public $classButton;
    public $iconButton;
    public $width;
    public $push = false;
    public $overlay = false;
    public $speed = 100;
    public $position;
    public $autoEscape = true;

    public function init()
    {
        parent::init();
        $this->registerClientScript();
    }

    public function run()
    {
        if($this->idBlock == 'serviceNoticeBlock') {
            $modelNoticeServiceForm = new NoticeServiceForm();
            return $this->render(
                'service-notice',
                [
                    'widget' => $this,
                    'modelNoticeServiceForm' => $modelNoticeServiceForm
                ]);
        }
        
        return $this->render(
            'chat',
            [
                'widget' => $this,
            ]);
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        SlideRevealWidgetAsset::register($view);

        $js = <<< JS
            $("#$this->idBlock").slideReveal({
                trigger: $("#$this->idButton"),
                width: "$this->width",
                top: "30%",
                push: "$this->push",
                overlay: "$this->overlay",
                position: "$this->position",
                speed: $this->speed,
                autoEscape: "$this->autoEscape",
                show: function(obj){
                    $("#$this->idButton").addClass("open-slide"); 
                },
                hidden: function(obj){
                    $("#$this->idButton").removeClass("open-slide");
                }
            });
JS;
        $view->registerJs($js);
    }
}