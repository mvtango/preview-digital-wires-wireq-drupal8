<?php

namespace Drupal\dpa_digital_wires\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class DigitalWiresMigrateSubscriber.
 */
class DigitalWiresMigrateSubscriber implements EventSubscriberInterface {

  /**
   * Constructs a new DigitalWiresMigrateSubscriber object.
   */
  public function __construct() {

  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events['migrate.post_row_save'] = ['migratePostRowSave'];

    return $events;
  }

  /**
   * This method is called when the migrate.post_row_save is dispatched.
   *
   * @param \Symfony\Component\EventDispatcher\Event $event
   *   The dispatched event.
   */
  public function migratePostRowSave(Event $event) {
    \Drupal::messenger()->addMessage('Event migrate.post_row_save thrown by Subscriber in module dpa_digital_wires.', 'status', TRUE);
  }

}
