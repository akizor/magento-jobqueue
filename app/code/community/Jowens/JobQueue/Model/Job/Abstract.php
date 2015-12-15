<?php

abstract class Jowens_JobQueue_Model_Job_Abstract extends Mage_Core_Model_Abstract
{
  private $name;
  private $storeId;

  public function __construct($name=null) {
    $this->name = $name ? $name : $this->getType();
    $this->setStoreId(Mage::app()->getStore()->getStoreId());
  }

  public abstract function perform();

  public function performImmediate($retryQueue="default") {
    try {
      $this->perform();
    } catch(Exception $e) {
      $this->enqueue($retryQueue);
      Mage::logException($e);
    }
  }

  public function enqueue($queue="default", $run_at=null) {
    $job = Mage::getModel('jobqueue/job');
    $job->setStoreId($this->getStoreId());
    $job->setName($this->getName());
    $job->setHandler(serialize($this));
    $job->setQueue($queue);
    $job->setRunAt($run_at);
    $job->setCreatedAt(now());

    //aki
    /* $job->setTypeQueue($this->getTypeQueue());
    $job->setTypeId($this->getTypeId());
    $job->setUserId(Mage::getSingleton('admin/session')->getUser()->getId()); */
    //end aki

    $job->save();
  }

  public function setName($name)
  {
    $this->name = $name;
    return $this;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setStoreId($storeId)
  {
    $this->storeId = $storeId;
    return $this;
  }

  public function getStoreId()
  {
    return $this->storeId;
  }

  public function getType()
  {
    return get_class($this);
  }

  /**
   * AKI
   * New values for queue table
   */
  public function setTypeQueue($val){
    $this->type_queue = $val;
    return $this;
  }
  public function getTypeQueue(){
    return $this->type_queue;
  }

  public function setTypeId($val){
    $this->type_id = $val;
    return $this;
  }
  public function getTypeId(){
    return $this->type_id;
  }
}
