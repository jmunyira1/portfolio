<?php

return [
    /*
     * Absolute path to the repositories root folder.
     * Default: one level above the portfolio (~/repositories/).
     */
    'path' => env('REPOS_PATH', dirname(base_path())),
];
