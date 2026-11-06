<?php

/**
 * Retired. This one-time deploy helper carried a token in a public repo, so it
 * now does nothing. The file stays only so the next deploy overwrites old
 * copies left on the servers. Migrations run through setup.php / ab-bootstrap.php.
 */

http_response_code(404);
exit;
