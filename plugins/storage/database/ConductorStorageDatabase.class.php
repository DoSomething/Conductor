<?php

/**
 * Provides the default handler for Conductor Storage using the dabase.
 *
 * TODO: Should we 
 */
class ConductorStorageDatabase implements ConductorStorage {

  protected $options = array();

  /**
   * Set the options to be used in these database connections.
   *
   * @param $options
   *   An options array as would be passed to db_select, db_update, etc.
   */
  public function setOptions(array $options) {
    $this->options = $options;
  }

  public function save(stdClass $data) {
    // TODO: How shall we decide whether to do an insert or an update?
  }

  public function load($uniqueId) {
    $result = db_query('SELECT * FROM {conductor_state} WHERE sid=:sid', array('sid' => $uniqueId), $options)->fetchObject();
    
  }

  public function loadPointer($pointerKey) {
    $unique_id = db_query('SELECT sid FROM {conductor_state_references} WHERE name = :name', array('name' => $name), $options)
      ->fetchField();
    return self::load($unique_id);
  }

  public function delete($uniqueId) {
    db_delete('conductor_state_references', $this->options)
     ->join()
     ->condition('');
    db_delete('conductor_state', $this->options)
      ->condition('');
  }

  public function savePointer($workflowName, $instanceId, $activityName, $pointerKey) {
  }

  public function deletePointer($pointerKey) {
    db_query('SELECT sid FROM {conductor_state} cs
      JOIN {conductor_state_references} csr ON cs.sid = csr.sid
      WHERE csr.name=:name', array('name' => $name), $this->options);
    db_delete('conductor_state_references')
     ->condition('sid', $sid);
    db_delete('conductor_state')
     ->condition('sid', $sid);
  }

}

