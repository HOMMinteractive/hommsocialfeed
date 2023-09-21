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
class SetColor extends ElementAction
{
    /**
     * @var null|string Change/Remove the color of a feed
     */
    public $color = null;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getTriggerHtml(): ?string
    {
        // Render the trigger menu template with all the available ingredients
        $colors = HOMMSocialFeed::$plugin->getSettings()->colors;

        \Craft::$app->view->setTemplateMode(\craft\web\View::TEMPLATE_MODE_CP);
        return \Craft::$app->view->renderTemplate('hommsocialfeed/feeds/_setColorTrigger', ['colors' => $colors]);
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
            if (!HOMMSocialFeed::$plugin->socialFeedService->update($socialFeed, ['color' => $this->color ?? null])) {
                $this->setMessage($socialFeed->getErrors());
                return false;
            }
        }

        $this->setMessage(\Craft::t('hommsocialfeed', 'Successfully updated.'));
        return true;
    }
}
