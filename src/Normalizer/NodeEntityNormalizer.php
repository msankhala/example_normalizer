<?php
namespace Drupal\example_normalizer\Normalizer;
use Drupal\serialization\Normalizer\ContentEntityNormalizer;
use Drupal\Core\Datetime\DrupalDateTime;
/**
 * Converts the Drupal entity object structures to a normalized array.
 */
class NodeEntityNormalizer extends ContentEntityNormalizer {
  /**
   * The interface or class that this Normalizer supports.
   *
   * @var string
   */
  protected $supportedInterfaceOrClass = 'Drupal\node\NodeInterface';
  /**
   * {@inheritdoc}
   */
  public function normalize($entity, $format = NULL, array $context = array()) {
    $attributes = parent::normalize($entity, $format, $context);
    // Convert the 'changed' timestamp to ISO 8601 format.
    $changed_timestamp = $entity->getChangedTime();
    $changed_date = DrupalDateTime::createFromTimestamp($changed_timestamp);
    $attributes['changed_iso8601'] = $changed_date->format('c');
    // The link to the node entity.
    $attributes['link'] = $entity->toUrl()->toString();
    // Re-sort the array after our new additions.
    ksort($attributes);
    // Return the $attributes with our new values.
    return $attributes;
  }
}
