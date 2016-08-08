<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\widgets;

/**
 * Pjax
 *
 * Modified Pjax widget with support of session notifications.
 * @author skoro
 */
class Pjax extends \yii\widgets\Pjax
{
    
    /**
     * @var array
     */
    public $notifyOptions = [];
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->requiresPjax()) {
            echo Notify::widget($this->notifyOptions);
        }
        parent::run();
    }
}