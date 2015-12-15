<?php

$installer = $this;

$connection = $installer->getConnection();

$installer->startSetup();

/* $connection->modifyColumn(
  $installer->getTable('jobqueue/job'),
  'handler',
  'BLOB NOT NULL'
); */

$connection->addColumn(
  $installer->getTable('jobqueue/job'),
  'type_queue',
  'TEXT NULL'
);
$connection->addColumn(
  $installer->getTable('jobqueue/job'),
  'type_id',
  'BIGINT UNSIGNED NULL'
);

$connection->addColumn(
  $installer->getTable('jobqueue/job'),
  'user_id',
  'INT UNSIGNED NULL DEFAULT 0'
);

$connection->addColumn(
  $installer->getTable('jobqueue/job'),
  'finished',
  'INT UNSIGNED NULL DEFAULT 0'
);

$connection->addColumn(
  $installer->getTable('jobqueue/job'),
  'finished_at',
  'DATETIME NULL'
);

$installer->endSetup();
