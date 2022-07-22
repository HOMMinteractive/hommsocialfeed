<?php
/**
 * HOMM Social Feed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\elements\actions;

use craft\base\ElementAction;
use craft\elements\db\ElementQueryInterface;
use homm\hommsocialfeed\HOMMSocialFeed;

/**
 * DeleteRedirects represents a Delete Redirect element action.
 *
 */
class HideMedia extends ElementAction
{
    /**
     * @var bool Hide/Show the image/video
     */
    public $hideMedia = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getTriggerHtml(): ?string
    {
        \Craft::$app->view->setTemplateMode(\craft\web\View::TEMPLATE_MODE_CP);
        return \Craft::$app->view->renderTemplate('hommsocialfeed/feeds/_hideMediaTrigger');
    }

    /**
     * Performs the action on any elements that match the given criteria.
     *
     * @param ElementQueryInterface $query The element query defining which elements the action should affect.
     *
     * @return bool Whether the action was performed successfully.
     */
    public function performAction(ElementQueryInterface $query): bool
    {
        foreach ($query->all() as $socialFeed) {
            if (!HOMMSocialFeed::$plugin->socialFeedService->update($socialFeed, ['isMediaHidden' => $this->hideMedia])) {
                $this->setMessage($socialFeed->getErrors());
                return false;
            }
        }

        $this->setMessage(\Craft::t('hommsocialfeed', 'Successfully updated.'));
        return true;
    }
}
