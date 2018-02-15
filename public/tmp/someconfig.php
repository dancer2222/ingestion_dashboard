<?php 
 return array (
  'types' => 
  array (
    0 => 'core',
    1 => 'albums',
    2 => 'books',
    3 => 'movies',
    4 => 'audiobooks',
  ),
  'actions' => 
  array (
    0 => 'activate',
    1 => 'deactivate',
    2 => 'check',
    3 => 'fix',
    4 => 'report',
    5 => 'reingest',
    6 => 'make',
  ),
  'commands' => 
  array (
    'core:make:blankTool' => 'JoMedia\\Tools\\ToolBuilder',
    'movies:fix:duplicateIds' => 'Tools\\Movies\\MoviesFixDuplicateIds',
    'movies:activate:byIds' => 'Tools\\MoviesActivateByIds',
    'movies:deactivate:byIds' => 'Tools\\MoviesDeactivateByIds',
    'albums:check:covers' => 'Tools\\AlbumsCheckCovers',
  ),
  'params' => 
  array (
    'core:make:blankTool' => 
    array (
      'options' => 
      array (
      ),
      'arguments' => 
      array (
      ),
    ),
    'movies:fix:duplicateIds' => 
    array (
      'options' => 
      array (
        'batch' => 
        array (
          'description' => NULL,
          'isRequired' => true,
        ),
      ),
      'arguments' => 
      array (
      ),
    ),
    'movies:activate:byIds' => 
    array (
      'options' => 
      array (
        'ids' => 
        array (
          'description' => NULL,
          'isRequired' => true,
        ),
      ),
      'arguments' => 
      array (
      ),
    ),
    'movies:deactivate:byIds' => 
    array (
      'options' => 
      array (
        'ids' => 
        array (
          'description' => NULL,
          'isRequired' => true,
        ),
      ),
      'arguments' => 
      array (
      ),
    ),
    'albums:check:covers' => 
    array (
      'options' => 
      array (
        'ids' => 
        array (
          'description' => NULL,
          'isRequired' => true,
        ),
        'names' => 
        array (
          'description' => NULL,
          'isRequired' => true,
        ),
      ),
      'arguments' => 
      array (
        'full' => 
        array (
          'description' => NULL,
          'isRequired' => false,
        ),
      ),
    ),
  ),
  'url' => 'api/v1/tools/config',
); 
